<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user's enrolled courses
        $userCourses = collect([]);
        
        // if (Auth::check()) {
        //     $userCourses = Auth::user()->courses()
        //         ->with('user')
        //         ->orderBy('updated_at', 'desc')
        //         ->take(4)
        //         ->get();
        // }
        
        // Get featured courses for non-enrolled users
        $featuredCourses = Course::where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        // Calculate stats
        $stats = [
            'completed_courses' => $userCourses->where('progress_percentage', 100)->count(),
            'ongoing_courses' => $userCourses->where('progress_percentage', '>', 0)
                                            ->where('progress_percentage', '<', 100)
                                            ->count(),
            'total_hours' => $userCourses->sum(function($course) {
                return $course->completed_modules * 0.5; // 30 mins per module
            }),
        ];
        
        return view('learner.dashboard', compact('userCourses', 'featuredCourses', 'stats'));
    } 

    public function show(Course $course, Request $request)
    {
        // Simple controller that just passes the course to the view
        return view('learner.courses.show', ['course' => $course]);
    }
        

    public function profile()
    {
        return view('learner.profile');
    }

    public function sessions()
    {
        return view('learner.sessions');
    }

    public function tutors()
    {
        return view('learner.tutors');
    }

    public function courses()
    {
        return view('learner.courses');
    }

    public function progress()
    {
        return view('learner.progress');
    }

    public function settings()
    {
        return view('learner.settings');
    }
}