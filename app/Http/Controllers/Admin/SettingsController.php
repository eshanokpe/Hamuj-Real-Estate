<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SettingsTrait;
use App\Models\About;
use App\Models\VisionMission;
use App\Models\ContactDetials;

class SettingsController extends Controller
{
    use SettingsTrait;
    public function index(){ 
        return view('admin.home.settings.index');
    }

    public function storeAboutUs(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);
        
        $imagePath = $this->uploadImageAboutUs($request, 'image', 'assets/images/about');
        
        About::create(
            array_merge(
            $validated, 
            [
                'image' => $imagePath,
            ]
            )
        );

        return redirect()->back()->with([
            'success' => 'About us created successfully.',
        ]);
    }

    public function updateAboutUs(Request $request, $id){
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);
        $aboutUs = About::findOrFail($id);
       
        $this->handleUpdateAboutUsImage($request, $aboutUs);
        $aboutUs->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);
 
        return redirect()->back()->with([
            'success' => 'About us updated successfully.',
        ]);
    } 

    public function indexVisionMission(){
        return view('admin.home.settings.visionMission.index');
    }

    public function storeVisionMission(Request $request){
        $validated = $request->validate([
            'vision' => 'required',
            'mission' => 'required',
        ]);
        VisionMission::create($validated);
        return redirect()->back()->with([
            'success' => 'Vision/Mission created successfully.',
        ]);
    }

    public function updateVisionMission(Request $request, $id){
        $validated = $request->validate([
            'vision' => 'required',
            'mission' => 'required',
        ]);
        $visionMission = VisionMission::findOrFail($id);
       
        $visionMission->update([
            'vision' => $validated['vision'],
            'mission' => $validated['mission'],
        ]);
 
        return redirect()->back()->with([
            'success' => 'Vision/Mission us updated successfully.',
        ]);
    }

    public function indexContact(){
        return view('admin.home.settings.contact.index');
    }
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string',
            'website_link' => 'string',
            'first_phone' => 'nullable|string',
            'second_phone' => '',
            'first_email' => 'nullable|email',
            'second_email' => '',
            'first_address' => 'nullable|string',
            'site_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('site_logo')) {
            $image = $request->file('site_logo');
            $siteLogo = uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('assets/images/logo'), $siteLogo);
            $validated['site_logo'] = 'assets/images/logo/' . $siteLogo;
        }
        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $footerLogo = uniqid().'.'. $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/logo'), $footerLogo);
            $validated['favicon'] = 'assets/images/logo/' . $footerLogo;
        }
       

        ContactDetials::create($validated);

        return redirect()->back()->with('success', 'Contact created successfully.');
    }
 
    public function updateContact(Request $request, $id)
    {
        $validated = $request->validate([
            'company_name' => 'required|string',
            'website_link' => 'string',
            'first_phone' => 'required|string',
            'second_phone' => '',
            'first_email' => 'required|email',
            'second_email' => '',
            'first_address' => 'required|string',
            'site_logo' => 'image|mimes:jpeg,png,jpg,gif|max:4048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif|max:4048',
        ]); 

        $contactUs = ContactDetials::findOrFail($id);

        if ($request->hasFile('site_logo')) {
            $image = $request->file('site_logo');
            $imageName = uniqid(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/logo'), $imageName);

            // Delete old site_logo file if exists
            if ($contactUs->site_logo) {
                $oldImagePath = public_path($contactUs->site_logo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $contactUs->site_logo = 'assets/images/logo/' . $imageName;
        }

        if ($request->hasFile('favicon')) {
            $imagefavicon = $request->file('favicon');
            $imageNameFavicon = uniqid(). '.' . $imagefavicon->getClientOriginalExtension();
            $imagefavicon->move(public_path('assets/images/logo'), $imageNameFavicon);

            // Delete old footer_logo file if exists
            if ($contactUs->favicon) {
                $oldImagePath = public_path($contactUs->favicon);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $contactUs->favicon = 'assets/images/logo/' . $imageNameFavicon;
        }

        $contactUs->company_name = $validated['company_name'];
        $contactUs->first_phone = $validated['first_phone'];
        $contactUs->second_phone = $validated['second_phone'];
        $contactUs->first_email = $validated['first_email'];
        $contactUs->second_email = $validated['second_email'];
        $contactUs->first_address = $validated['first_address'];

        $contactUs->save();

        return redirect()->back()->with('success', 'Contact us updated successfully.');
    }

    public function indexTerms(){
        return view('admin.home.settings.terms.index');
    }

    public function storeeTerms(Request $request){
        $validated = $request->validate([
            'vision' => 'required',
            'mission' => 'required',
        ]);
        VisionMission::create($validated);
        return redirect()->back()->with([
            'success' => 'Vision/Mission created successfully.',
        ]);
    }
}
