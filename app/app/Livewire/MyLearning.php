<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class MyLearning extends Component
{
    public $limit = 4;
    
    public function render()
    {
        $courses = collect([]);
        $stats = [
            'completed_courses' => 0,
            'ongoing_courses' => 0,
            'total_hours' => 0,
            'certificates' => 0,
        ];
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get user's enrolled courses with pivot data
            $courses = $user->courses()
                ->withPivot('progress', 'completed_modules', 'enrolled_at', 'completed_at')
                ->orderBy('course_user.updated_at', 'desc')
                ->take($this->limit)
                ->get();
            
            // Calculate real stats
            $stats['completed_courses'] = $courses->where('pivot.completed_at', '!=', null)->count();
            $stats['ongoing_courses'] = $courses->where('pivot.completed_at', null)->count();
            
            // Calculate hours (assuming 30 mins per completed module)
            $stats['total_hours'] = round($courses->sum(function($course) {
                return $course->pivot->completed_modules * 0.5;
            }));
            
            $stats['certificates'] = $stats['completed_courses'];
        }
        
        return view('livewire.my-learning', [
            'courses' => $courses,
            'stats' => $stats,
        ]);
    }
    
    // Optional: Add enrollment method
    public function enroll($courseId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        if (!$user->isEnrolledIn($courseId)) {
            $user->enrollInCourse($courseId);
            session()->flash('message', 'Successfully enrolled in course!');
        }
        
        // Refresh component
        $this->emit('courseEnrolled');
    }
}