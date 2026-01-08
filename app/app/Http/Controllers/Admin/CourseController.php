<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
  
class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search'); 
        $status = $request->get('status');
        $level = $request->get('level');
        $perPage = $request->get('per_page', 10);

        $courses = Course::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('short_description', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($level, function ($query) use ($level) {
                $query->where('level', $level);
            })
            ->latest()
            ->paginate($perPage);

        return view('admin.courses.index', compact('courses', 'search', 'status', 'level', 'perPage'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255|unique:courses,title',
            'short_title' => 'required|string|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',// 10MB for images
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv,mkv|max:20240', // 20MB max for upload
            'video_type' => 'required|in:upload,youtube,vimeo,none',
            'video_url' => 'nullable|url|required_if:video_type,youtube,vimeo',
            'level' => 'required|in:beginner,intermediate,advanced,expert',
            'format' => 'required|in:self_paced,instructor_led,hybrid',
            'duration' => 'required|string|max:100',
            'modules_count' => 'required|integer|min:1|max:1000',
            'completed_modules' => 'nullable|integer|min:0|lte:modules_count',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_popular' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'learning_outcomes' => 'nullable|string',
            'prerequisites' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'certification' => 'nullable|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'video_type' => $request->video_type,
            'video_url' => $request->video_url,
            'level' => $request->level,
            'format' => $request->format,
            'duration' => $request->duration,
            // 'modules_count' => $request->modules_count,
            // 'completed_modules' => $request->completed_modules ?? 0,
            'modules_count' => (int) $request->modules_count,
            'completed_modules' => $request->completed_modules ? (int) $request->completed_modules : 0,
            'price' => $request->price ?? 0,
            'discount_price' => $request->discount_price ?? 0,
            'status' => $request->status,
            'is_featured' => $request->is_featured ?? false,
            'is_popular' => $request->is_popular ?? false,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'learning_outcomes' => $request->learning_outcomes,
            'prerequisites' => $request->prerequisites,
            'target_audience' => $request->target_audience,
            'certification' => $request->certification,
            'user_id' => auth()->guard('admin')->id(),
        ];

        // Handle video upload separately
        $videoPath = null;
        if ($request->video_type === 'upload' && $request->hasFile('video')) {
            try {
                $request->validate([
                    'video' => 'required|file|mimes:mp4,mov,avi,wmv,mkv|max:20480',
                ]);
                
                $videoPath = $request->file('video')->store('course-videos', 'public');
                
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['video' => 'Video upload failed: ' . $e->getMessage()]);
            }
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }
        // Debug video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            
            // Log video details for debugging
            \Log::info('Video upload attempt:', [
                'name' => $video->getClientOriginalName(),
                'size' => $video->getSize(),
                'mime' => $video->getMimeType(),
                'extension' => $video->getClientOriginalExtension(),
                'isValid' => $video->isValid(),
                'error' => $video->getError(),
            ]);
        }
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('course-videos', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function uploadVideo(Request $request)
    {
        // Handle only video upload separately
        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi,wmv,mkv|max:102400',
        ]);
        
        // Store video and return path
        $path = $request->file('video')->store('course-videos', 'public');
        
        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => asset('storage/' . $path)
        ]);
    }

    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:courses,title,' . $course->id,
            'short_title' => 'required|string|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv,mkv|max:51200',
            'video_type' => 'required|in:upload,youtube,vimeo,none',
            'video_url' => 'nullable|url|required_if:video_type,youtube,vimeo',
            'level' => 'required|in:beginner,intermediate,advanced,expert',
            'format' => 'required|in:self_paced,instructor_led,hybrid',
            'duration' => 'required|string|max:100',
            'modules_count' => ['required', 'numeric', 'min:1', function ($attribute, $value, $fail) use ($course) {
                if (!is_numeric($value)) {
                    $fail('The total modules must be a valid number.');
                }
                if ((int) $value < $course->completed_modules) {
                    $fail('Total modules cannot be less than completed modules (' . $course->completed_modules . ').');
                }
            }],
            'completed_modules' => ['nullable', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if (!is_numeric($value)) {
                    $fail('The completed modules must be a valid number.');
                }
                if ((int) $value > (int) $request->modules_count) {
                    $fail('Completed modules cannot exceed total modules.');
                }
            }],
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_popular' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'learning_outcomes' => 'nullable|string',
            'prerequisites' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'certification' => 'nullable|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'video_type' => $request->video_type,
            'video_url' => $request->video_url,
            'level' => $request->level,
            'format' => $request->format,
            'duration' => $request->duration,
            'modules_count' => (int) $request->modules_count, // Cast to int
            'completed_modules' => (int) ($request->completed_modules ?? $course->completed_modules), // Cast to int
            'price' => $request->price ?? 0,
            'discount_price' => $request->discount_price ?? 0,
            'status' => $request->status,
            'is_featured' => $request->is_featured ?? false,
            'is_popular' => $request->is_popular ?? false,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'learning_outcomes' => $request->learning_outcomes,
            'prerequisites' => $request->prerequisites,
            'target_audience' => $request->target_audience,
            'certification' => $request->certification,
        ];

        // Handle image removal/update
        if ($request->has('remove_image') && $course->image) {
            Storage::disk('public')->delete($course->image);
            $data['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }
        
        // Handle video update
        if ($request->video_type === 'upload' && $request->hasFile('video')) {
            if ($course->video) {
                Storage::disk('public')->delete($course->video);
            }
            $data['video'] = $request->file('video')->store('course-videos', 'public');
            $data['video_url'] = null;
        } elseif ($request->video_type === 'youtube' || $request->video_type === 'vimeo') {
            // Remove uploaded video if switching to URL
            if ($course->video) {
                Storage::disk('public')->delete($course->video);
                $data['video'] = null;
            }
        } elseif ($request->video_type === 'none') {
            // Remove all video data
            if ($course->video) {
                Storage::disk('public')->delete($course->video);
            }
            $data['video'] = null;
            $data['video_url'] = null;
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        // Delete image if exists
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }
        
        // Delete video if exists
        if ($course->video) {
            Storage::disk('public')->delete($course->video);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    public function toggleStatus(Course $course)
    {
        $statuses = ['draft', 'published', 'archived'];
        $currentIndex = array_search($course->status, $statuses);
        $nextStatus = $statuses[($currentIndex + 1) % count($statuses)];

        $course->update(['status' => $nextStatus]);

        return back()->with('success', "Course status changed to {$nextStatus} successfully.");
    }

    public function toggleFeatured(Course $course)
    {
        $course->update(['is_featured' => !$course->is_featured]);

        $status = $course->is_featured ? 'featured' : 'unfeatured';

        return back()->with('success', "Course {$status} successfully.");
    }

    public function togglePopular(Course $course)
    {
        $course->update(['is_popular' => !$course->is_popular]);

        $status = $course->is_popular ? 'marked as popular' : 'removed from popular';

        return back()->with('success', "Course {$status} successfully.");
    }

    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $courseIds = $request->course_ids;

        if (!$courseIds) {
            return back()->with('error', 'Please select at least one course.');
        }

        switch ($action) {
            case 'publish':
                Course::whereIn('id', $courseIds)->update(['status' => 'published']);
                $message = 'Selected courses published successfully.';
                break;
            case 'draft':
                Course::whereIn('id', $courseIds)->update(['status' => 'draft']);
                $message = 'Selected courses moved to draft successfully.';
                break;
            case 'archive':
                Course::whereIn('id', $courseIds)->update(['status' => 'archived']);
                $message = 'Selected courses archived successfully.';
                break;
            case 'delete':
                $courses = Course::whereIn('id', $courseIds)->get();
                foreach ($courses as $course) {
                    if ($course->image) {
                        Storage::disk('public')->delete($course->image);
                    }
                    $course->delete();
                }
                $message = 'Selected courses deleted successfully.';
                break;
            default:
                return back()->with('error', 'Invalid action.');
        }

        return back()->with('success', $message);
    }
}