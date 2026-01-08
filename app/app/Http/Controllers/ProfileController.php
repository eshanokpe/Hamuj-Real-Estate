<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Show the profile page
     */
    public function index()
    {
        $user = Auth::user();
        
        // If user has no enrolled_at date, set it to now
        if (!$user->enrolled_at) {
            $user->update(['enrolled_at' => now()]);
        }
        
        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'phone_country_code' => 'nullable|string|max:5',
            'bio' => 'nullable|string|max:500',
            'job_title' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
        ], [
            'email.unique' => 'This email address is already registered.',
            'website.url' => 'Please enter a valid website URL (e.g., https://example.com).',
            'linkedin_url.url' => 'Please enter a valid LinkedIn URL.',
            'twitter_url.url' => 'Please enter a valid Twitter URL.',
            'facebook_url.url' => 'Please enter a valid Facebook URL.',
            'instagram_url.url' => 'Please enter a valid Instagram URL.',
            'github_url.url' => 'Please enter a valid GitHub URL.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Prepare update data
            $updateData = $request->only([
                'name', 'email', 'phone', 'phone_country_code', 'bio',
                'job_title', 'company', 'website', 'country', 'city',
                'state', 'postal_code', 'address', 'linkedin_url',
                'twitter_url', 'facebook_url', 'instagram_url', 'github_url'
            ]);

            // If email is being changed, reset email verification
            if ($request->email !== $user->email) {
                $updateData['email_verified_at'] = null;
            }

            // Mark profile as completed if not already
            if (!$user->profile_completed_at) {
                $updateData['profile_completed_at'] = now();
            }

            // Update the user
            $user->update($updateData);

            // Log the profile update
            Log::info('User profile updated', [
                'user_id' => $user->id,
                'changes' => $updateData
            ]);

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            Log::error('Profile update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'An error occurred while updating your profile.');
        }
    }

    /**
     * Update the user's profile picture
     */
    public function updatePicture(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ], [
                'profile_picture.required' => 'Please select an image to upload.',
                'profile_picture.image' => 'The file must be an image.',
                'profile_picture.mimes' => 'Only JPEG, PNG, JPG, GIF, and WEBP images are allowed.',
                'profile_picture.max' => 'The image size must be less than 5MB.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $user = Auth::user();

            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            
            // Update user's profile picture path
            $user->update(['profile_picture' => $path]);

            // Generate full URL for the image
            $imageUrl = Storage::url($path);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'image_url' => $imageUrl,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile picture upload failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile picture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the user's profile picture
     */
    public function removePicture(Request $request)
    {
        $user = Auth::user();

        if (!$user->profile_picture) {
            return back()->with('error', 'Failed to remove profile picture. Please try again.');
        }

        try {
            // Delete the profile picture from storage
            if (Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }

            // Remove profile picture reference from user
            $user->update(['profile_picture' => null]);

            // Log the removal
            Log::info('Profile picture removed', [
                'user_id' => $user->id
            ]);

            return back()->with('success', 'Profile picture removed successfully!');

        } catch (\Exception $e) {
            Log::error('Profile picture removal failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to remove profile picture. Please try again.');   
        }
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ], [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'New password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        try {
            // Update the password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            // Log the password change
            Log::info('Password updated', [
                'user_id' => $user->id
            ]);

            return back()->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            Log::error('Password update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update password.');
        }
    }

    /**
     * Update user preferences
     */
    public function updatePreferences(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean',
            'newsletter_subscription' => 'nullable|boolean',
            'marketing_emails' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        try {
            // Prepare preferences data
            $preferences = [
                'email_notifications' => $request->boolean('email_notifications', $user->email_notifications),
                'sms_notifications' => $request->boolean('sms_notifications', $user->sms_notifications),
                'newsletter_subscription' => $request->boolean('newsletter_subscription', $user->newsletter_subscription),
                'marketing_emails' => $request->boolean('marketing_emails', $user->marketing_emails),
            ];

            // Update user preferences
            $user->update($preferences);

            // Log preferences update
            Log::info('Preferences updated', [
                'user_id' => $user->id,
                'preferences' => $preferences
            ]);

           return back()->with('success', 'Preferences updated successfully!');

        } catch (\Exception $e) {
            Log::error('Preferences update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update preferences.');
        }
    }

    public function downloadData()
{
    $user = Auth::user();
    
    $data = [
        'personal_information' => [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ? $user->phone_country_code . ' ' . $user->phone : null,
            'account_type' => $user->account_type,
            'account_status' => $user->account_status,
            'joined_date' => $user->created_at->format('Y-m-d H:i:s'),
            'last_login' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
        ],
        'profile_information' => [
            'job_title' => $user->job_title,
            'company' => $user->company,
            'bio' => $user->bio,
            'website' => $user->website,
            'location' => [
                'country' => $user->country,
                'city' => $user->city,
                'state' => $user->state,
                'postal_code' => $user->postal_code,
                'address' => $user->address,
            ],
        ],
        'social_links' => [
            'linkedin' => $user->linkedin_url,
            'twitter' => $user->twitter_url,
            'facebook' => $user->facebook_url,
            'instagram' => $user->instagram_url,
            'github' => $user->github_url,
        ],
        'preferences' => [
            'email_notifications' => $user->email_notifications,
            'sms_notifications' => $user->sms_notifications,
            'newsletter_subscription' => $user->newsletter_subscription,
            'marketing_emails' => $user->marketing_emails,
        ],
        'account_statistics' => [
            'total_courses' => $user->courses()->count(),
            'completed_courses' => $user->completedCourses()->count(),
            'days_active' => $user->enrolled_at ? now()->diffInDays($user->enrolled_at) : 0,
            'profile_completion_date' => $user->profile_completed_at ? $user->profile_completed_at->format('Y-m-d H:i:s') : null,
            'email_verified_date' => $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : null,
        ],
    ];

    // Create a JSON file
    $filename = 'user-data-' . $user->id . '-' . now()->format('Y-m-d') . '.json';
    
    // Create the response with proper headers for download
    $headers = [
        'Content-Type' => 'application/json',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    // Return the JSON file for download
    return response()->json($data, 200, $headers);
}

    public function getProfileData()
    {
        $user = Auth::user();
        
        
        // If you need to pass data to the view, use compact or session
        return redirect()->route('learner.settings')->with([
            'user_data' => $user->only([
                'id', 'name', 'email', 'profile_picture', 'phone', 
                'phone_country_code', 'bio', 'job_title', 'company',
                'website', 'country', 'city', 'state', 'postal_code',
                'address', 'linkedin_url', 'twitter_url', 'facebook_url',
                'instagram_url', 'github_url', 'email_notifications',
                'sms_notifications', 'newsletter_subscription', 'marketing_emails',
                'account_status', 'account_type', 'last_login_at', 'enrolled_at',
                'email_verified_at', 'profile_completed_at', 'created_at'
            ]),
            'profile_picture_url' => $user->profile_picture 
                ? Storage::url($user->profile_picture) 
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0A1F44&color=fff&size=200',
            'stats' => [
                'courses_count' => $user->courses()->count(),
                'completed_courses' => $user->completedCourses()->count(),
                'courses_in_progress' => $user->courses_in_progress,
                'courses_not_started' => $user->courses_not_started,
                'overall_progress' => $user->overall_progress,
                'active_days' => $user->enrolled_at ? now()->diffInDays($user->enrolled_at) : 0,
                'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never',
            ]
        ]);
    }

    /**
     * Delete user account (soft delete)
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:DELETE MY ACCOUNT',
            'password' => 'required|current_password',
        ], [
            'confirmation.required' => 'Please type "DELETE MY ACCOUNT" to confirm.',
            'confirmation.in' => 'Please type "DELETE MY ACCOUNT" exactly as shown.',
            'password.required' => 'Your password is required to delete your account.',
            'password.current_password' => 'The password is incorrect.',
        ]);

        $user = Auth::user();

        try {
            // Log the account deletion
            Log::warning('User account deletion requested', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Soft delete the user account
            $user->delete();

            // Logout the user
            Auth::logout();

            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            
            return redirect()->route('home')->with('success', 'Your account has been deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Account deletion failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to delete account. Please try again.');
        }
    }
}