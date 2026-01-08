<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FrontendController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function aboutus()
    {
        return view('frontend.aboutus');
    }

    public function igrcfp(){
        return view('frontend.aboutus');
    }

    public function structure(){
        return view('frontend.structure');
    }

    public function membership(){
        return view('frontend.membership');
    }


    public function event()
    {
        // Get all published events
        $events = Event::where('status', 'published')
                      ->orderBy('start_date', 'desc')
                      ->get();
        
        return view('frontend.events.index', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
                     ->where('status', 'published')
                     ->firstOrFail();
        
        // Get related events (same category or similar)
        $relatedEvents = Event::where('status', 'published')
                            ->where('id', '!=', $event->id)
                            ->where(function($query) use ($event) {
                                $query->where('location', $event->location)
                                      ->orWhere('venue', $event->venue);
                            })
                            ->orWhere(function($query) use ($event) {
                                // Events in the same time period (within 30 days)
                                $query->whereBetween('start_date', [
                                    $event->start_date->subDays(30),
                                    $event->start_date->addDays(30)
                                ]);
                            })
                            ->limit(3)
                            ->get();
        
        return view('frontend.events.show', compact('event', 'relatedEvents'));
    }

    public function blog(){
        return view('frontend.blog.index');
    }

    public function blogDetails(){
        return view('frontend.blog.details');
    }

    public function getInvolved(){
        return view('frontend.getInvolved');
    }
     
    public function contact(){
        return view('frontend.contact');
    }
 
    public function privacy(){
        return view('frontend.privacy');
    }  
    
    public function trainingCalender(){
        return view('frontend.trainingCalender');
    }
}