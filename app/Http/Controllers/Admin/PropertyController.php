<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home.property.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home.property.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'size' => 'required|string|max:255',
            'property_images' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'payment_plan' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'brochure' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'land_survey' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'video_link' => 'required|url|max:255',
            'status' => 'required|in:available,sold',
        ]);
        // Handle file uploads to public directory
        $propertyImagePath = $request->file('property_images')->move(public_path('assets/images/property'), time().'_'.$request->file('property_images')->getClientOriginalName());
        $paymentPlanPath = $request->file('payment_plan')->move(public_path('assets/images/property'), time().'_'.$request->file('payment_plan')->getClientOriginalName());
        $brochurePath = $request->file('brochure')->move(public_path('assets/images/property'), time().'_'.$request->file('brochure')->getClientOriginalName());
        $landSurveyPath = $request->file('land_survey')->move(public_path('assets/images/property'), time().'_'.$request->file('land_survey')->getClientOriginalName());
        Property::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'price' => $request->input('price'),
            'size' => $request->input('size'),
            'property_images' => 'assets/images/property/' . basename($propertyImagePath),
            'payment_plan' => 'assets/images/property/' . basename($paymentPlanPath),
            'brochure' => 'assets/images/property/' . basename($brochurePath),
            'land_survey' => 'assets/images/property/' . basename($landSurveyPath),
            'video_link' => $request->input('video_link'),
            'status' => $request->input('status'),
        ]);
        return redirect()->route('admin.properties.create')->with('success', 'Property uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::findOrFail( decrypt($id));
        return view('admin.home.property.edit', compact('property'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'size' => 'required|string|max:255',
            'property_images' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
            'payment_plan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'brochure' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'land_survey' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'video_link' => 'required|url|max:255',
            'status' => 'required|in:available,sold',
        ]);
        $property->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'price' => $request->input('price'),
            'size' => $request->input('size'),
            'video_link' => $request->input('video_link'),
            'status' => $request->input('status'),
        ]);
        if ($request->hasFile('property_images')) {
            // Delete old file if exists
            if ($property->property_images && file_exists(public_path($property->property_images))) {
                unlink(public_path($property->property_images));
            }
            // Save new file
            $propertyImagePath = $request->file('property_images')->move(public_path('assets/images/property'), time().'_'.$request->file('property_images')->getClientOriginalName());
            $property->property_images = 'assets/images/property/' . basename($propertyImagePath);
        }
    
        if ($request->hasFile('payment_plan')) {
            if ($property->payment_plan && file_exists(public_path($property->payment_plan))) {
                unlink(public_path($property->payment_plan));
            }
            $paymentPlanPath = $request->file('payment_plan')->move(public_path('assets/images/property'), time().'_'.$request->file('payment_plan')->getClientOriginalName());
            $property->payment_plan = 'assets/images/property/' . basename($paymentPlanPath);
        }
        if ($request->hasFile('brochure')) {
            if ($property->brochure && file_exists(public_path($property->brochure))) {
                unlink(public_path($property->brochure));
            }
            $brochurePath = $request->file('brochure')->move(public_path('assets/images/property'), time().'_'.$request->file('brochure')->getClientOriginalName());
            $property->brochure = 'assets/images/property/' . basename($brochurePath);
        }
    
        if ($request->hasFile('land_survey')) {
            if ($property->land_survey && file_exists(public_path($property->land_survey))) {
                unlink(public_path($property->land_survey));
            }
            $landSurveyPath = $request->file('land_survey')->move(public_path('assets/images/property'), time().'_'.$request->file('land_survey')->getClientOriginalName());
            $property->land_survey = 'assets/images/property/' . basename($landSurveyPath);
        }
        $property->save();

        return redirect()->back()->with('success', 'Property updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property= Property::findOrFail(decrypt($id));
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully.');
    }
}
