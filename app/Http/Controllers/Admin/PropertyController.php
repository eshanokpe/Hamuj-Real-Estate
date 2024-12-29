<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyValuation;
use App\Models\PropertyPriceUpdate;
use App\Notifications\PropertyValuationNotification;

class PropertyController extends Controller
{
     
    public function index()
    {
        $properties = Property::all();
        return view('admin.home.properties.index', compact('properties'));
    }

    public function create()
    {
        $city = [
            "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", 
            "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", 
            "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", 
            "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", 
            "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara", "FCT"
        ];
        return view('admin.home.properties.create', compact('city'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'lunch_price' => 'required|numeric',
            'price' => 'required|numeric',
            'percentage_increase' => 'required|numeric',
            'size' => 'required|string|max:255',
            'gazette_number' => 'required|string|max:50',
            'tenure_free' => 'required|string|max:50',
            'property_images' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'payment_plan' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'brochure' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'contract_deed' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'land_survey' => 'required|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'video_link' => 'required|url|max:255',
            'google_map' => 'required|url',
            'status' => 'required|in:available,sold',
        ]);
        // Handle file uploads to public directory
        $propertyImagePath = $request->file('property_images')->move(public_path('assets/images/property'), time().'_'.$request->file('property_images')->getClientOriginalName());
        $paymentPlanPath = $request->file('payment_plan')->move(public_path('assets/images/property'), time().'_'.$request->file('payment_plan')->getClientOriginalName());
        $brochurePath = $request->file('brochure')->move(public_path('assets/images/property'), time().'_'.$request->file('brochure')->getClientOriginalName());
        $landSurveyPath = $request->file('land_survey')->move(public_path('assets/images/property'), time().'_'.$request->file('land_survey')->getClientOriginalName());
        $contractDeedPath = $request->file('contract_deed')->move(public_path('assets/images/property'), time().'_'.$request->file('contract_deed')->getClientOriginalName());
       
        $lunchPrice = $request->input('lunch_price');
        $currentPrice = $request->input('price');

        $priceIncrease = $lunchPrice > 0 ? (($currentPrice - $lunchPrice) / $lunchPrice) * 100 : 0;

        Property::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'lunch_price' => $request->input('lunch_price'),
            'price' => $request->input('price'),
            'percentage_increase' => $priceIncrease,
            'gazette_number' => $request->input('gazette_number'),
            'tenure_free' => $request->input('tenure_free'),
            'size' => $request->input('size'),
            'available_size' => $request->input('size'),
            'property_images' => 'assets/images/property/' . basename($propertyImagePath),
            'payment_plan' => 'assets/images/property/' . basename($paymentPlanPath),
            'brochure' => 'assets/images/property/' . basename($brochurePath),
            'land_survey' => 'assets/images/property/' . basename($landSurveyPath),
            'contract_deed' => 'assets/images/property/' . basename($contractDeedPath),
            'video_link' => $request->input('video_link'),
            'google_map' => $request->input('google_map'),
            'year' => $request->input('year'),
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

   
    public function edit($id)
    {
        $property = Property::findOrFail( decrypt($id));
        $city = [
            "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", 
            "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", 
            "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", 
            "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", 
            "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara", "FCT"
        ];
        return view('admin.home.properties.edit', compact('property', 'city'));
    }
    
    public function update(Request $request, $id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'lunch_price' => 'required|numeric',
            'price' => 'required|numeric',
            'size' => 'required|string|max:255',
            'gazette_number' => 'required|string|max:50',
            'tenure_free'=> 'required|string|max:50',
            'property_images' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
            'payment_plan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'brochure' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'land_survey' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'contract_deed' => 'nullable|file|image|mimes:jpeg,pdf,png,jpg|max:5048',
            'video_link' => 'required|url|max:255',
            'google_map' => 'required|url',
            'status' => 'required|in:available,sold',
        ]);
        $year = $request->input('updated_year', Carbon::now()->year);
        $lunchPrice = $request->input('lunch_price');
        $newPrice = $request->input('price');
        $previousPrice = $property->price;
        $previousPercentageIncrease = $property->percentage_increase;
        $previousYear = $property->year;

        $percentageIncrease = $lunchPrice > 0 ? (($newPrice - $lunchPrice) / $lunchPrice) * 100 : 0;

        // Log the price update
        PropertyPriceUpdate::create([
            'property_id' => $property->id,
            'previous_price' => $previousPrice,
            'previous_percentage_increase' => $previousPercentageIncrease,
            'previous_year' => $previousYear,
            'updated_price' => $newPrice,
            'percentage_increase' => $percentageIncrease,
            'updated_year' => $year,
        ]);

        $property->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'city' => $request->input('city'),
            'country' => $request->input('country'), 
            'lunch_price' => $request->input('lunch_price'),
            'price' => $newPrice,
            'percentage_increase' => $percentageIncrease,
            'gazette_number' => $request->input('gazette_number'),
            'tenure_free' => $request->input('tenure_free'),
            'size' => $request->input('size'),
            'available_size' => $request->input('size'),
            'video_link' => $request->input('video_link'),
            'google_map' => $request->input('google_map'),
            'status' => $request->input('status'),
        ]);
        if ($request->hasFile('property_images')) {
            if ($property->property_images && file_exists(public_path($property->property_images))) {
                unlink(public_path($property->property_images));
            }
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
        if ($request->hasFile('contract_deed')) {
            if ($property->contract_deed && file_exists(public_path($property->contract_deed))) {
                unlink(public_path($property->contract_deed));
            }
            $contractDeedPath = $request->file('contract_deed')->move(public_path('assets/images/property'), time().'_'.$request->file('contract_deed')->getClientOriginalName());
            $property->contract_deed = 'assets/images/property/' . basename($contractDeedPath);
        }
        
        $property->save();

        return redirect()->back()->with('success', 'Property updated successfully.');
    }
    
    public function destroy($id)
    {
        $property= Property::findOrFail(decrypt($id));
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully.');
    }

    public function evaluate($id)
    {
        $propertyId = decrypt($id); 
        $data['property'] = Property::findOrFail($propertyId);
        $data['propertyValuation'] = PropertyValuation::where('property_id', $data['property']->id)
        ->when(request('filter'), function ($query) {
            // Filter by selected year
            if ($year = request('filter')) {
                return $query->whereYear('created_at', $year);
            }
            return $query;
        })
        ->orderBy('created_at', 'asc') 
        ->get();

        // Prepare the data for the chart
        $valuationData = $data['propertyValuation']->map(function ($valuation) {
            return [
                'date' => $valuation->created_at->format('M, d'), 
                'price' => $valuation->market_value,
            ];
        });

        $data['valuationData'] = $valuationData;
        // dd($data['valuationData']);
        return view('admin.home.properties.evaluate', $data);
    }


    public function valuationStore(Request $request)
    {
      
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'valuation_type' => 'required|string|max:255',
            'current_price' => 'required|string|min:0',
            'market_value' => 'required|string|min:0',
            'percentage_increase' => 'required|string|min:0',
        ]);
        // Parse numeric values from currency format if necessary
        $currentPrice = preg_replace('/[₦,]/', '', $request->current_price);
        $marketValue = preg_replace('/[₦,]/', '', $request->market_value);

        $percentageIncrease = 0;
        if ($currentPrice > 0) {
            $percentageIncrease = ceil((($marketValue - $currentPrice) / $currentPrice) * 100);
        }
        // dd($percentageIncrease);

        PropertyValuation::create([
            'property_id' => $request->property_id,
            'valuation_type' => $request->valuation_type,
            'current_price' => $currentPrice,
            'market_value' => $marketValue,
            'percentage_increase' => $percentageIncrease,
        ]);

        // Update the Property price
        $property = Property::findOrFail($request->property_id);
        $lunchPrice = $property->lunch_price;
        $priceIncrease = $lunchPrice > 0 ? (($marketValue - $lunchPrice) / $lunchPrice) * 100 : 0;


        $property->price = $marketValue; 
        $property->percentage_increase = $priceIncrease; 
        $property->save(); 

        // Send notification to all users
        $users = User::all();
        foreach ($users as $user) { 
            $user->notify(new PropertyValuationNotification($property, $priceIncrease));
        }

        return redirect()->back()->with('success', 'Valuation added successfully.');
    }

    public function valuationEdit($id){
        $propertyId = decrypt($id); 
        $data['property'] = PropertyValuation::findOrFail($propertyId);
        dd( $data['property']);
    }

}
