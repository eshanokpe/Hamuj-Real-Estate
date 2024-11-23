<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\Project;
use App\Models\DropdownItem;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Service;
use App\Models\Industries;
use App\Models\ContactForm;


class PagesController extends Controller
{
   
    
    public function index($slug)
    {
        $pages = [
            'home' => 'home.index',
            'about' => 'home.pages.about.about',
            'properties' => 'home.pages.properties.properties',
            'contact' => 'home.pages.contact',
            'blog' => 'home.pages.blog.blog',
            'faqs' => 'home.pages.faqs',
            'terms-of-use' => 'home.pages.terms',
            'privacy-policy' => 'home.pages.privacy-policy',
        ];
    
        if (array_key_exists($slug, $pages)) {
            return view($pages[$slug]);
        }
        if ($slug === 'events') {
            return redirect()->route('events.all');
        }

        return view('home.errors.404');
    }
    
   
  

}
