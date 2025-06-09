<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\Consultant;
use App\Models\Project; 
use App\Models\DropdownItem;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Service;
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
            $properties = Property::inRandomOrder()->take(6)->get();
            if ($properties->isEmpty()) {
                return redirect()->route('home')->with('error', 'Property not found.');
            }

            foreach ($properties as $property) {
                $transaction = null;
                if (Auth::check()) {
                    $transaction = $property->transaction()->where('user_id', Auth::id())->first();
                }
                $property->transaction = $transaction;
            } 
            if($slug == "properties"){
                $properties = Property::inRandomOrder()->paginate(6);
            }
            return view($pages[$slug],compact('properties'));
        } 
         // Handle referral links
         if (strpos($slug, 'referral/') == 0) {
            $referralCode = explode('/', $slug);
            $referralDetails = User::where('referral_code', $referralCode)->first();
            if ($referralDetails) {
                return view('home.index', compact('referralDetails'));
            } else { 
                return view('home.errors.404');
            }
        }

        return view('home.errors.404');
    }
    
   
  

}
