<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\Neighborhood;
use App\Models\PropertyValuation; 
use App\Models\PropertyPriceUpdate;
use App\Models\NeighborhoodCategory;
use App\Models\TransactionUpdateLog;
use App\Models\PropertyValuationSummary;
use App\Models\PropertyValuationPrediction;
use App\Notifications\PropertyValuationNotification;
use App\Notifications\PropertyValuationPredictionNotification;

  
class PropertyController extends Controller
{ 
     
    public function index()
    { 
        $properties = Property::all();
        return view('admin.home.properties.index', compact('properties'));
      
    }

    public function create()
    { 
        $states = [
            "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", 
            "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", 
            "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", 
            "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", 
            "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara", "FCT"
        ];
        return view('admin.home.properties.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'lunch_price' => 'required|numeric',
            'price' => 'required|numeric',
            'percentage_increase' => 'required|numeric',
            'size' => 'required|string|max:255',
            'gazette_number' => 'required|string|max:50',
            'tenure_free' => 'required|string|max:50',
            'property_images' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'land_survey' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'contract_deed' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'video_link' => 'required|url|max:255',
            'google_map' => 'nullable|url',
            'status' => 'required|in:available,sold',
            'year' => 'required|numeric',
        ]);
 
        // Handle file uploads
        $propertyImagePath = $request->file('property_images')->store('property_images', 'public');
        $landSurveyPath = $request->file('land_survey')->store('land_surveys', 'public');
        $contractDeedPath = $request->file('contract_deed')->store('contract_deeds', 'public');
    
        $lunchPrice = $request->input('lunch_price');
        $currentPrice = $request->input('price');
        $priceIncrease = $lunchPrice > 0 ? (($currentPrice - $lunchPrice) / $lunchPrice) * 100 : 0;

        Property::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'lunch_price' => $lunchPrice,
            'price' => $currentPrice,
            'percentage_increase' => $priceIncrease,
            'gazette_number' => $request->input('gazette_number'),
            'tenure_free' => $request->input('tenure_free'),
            'size' => $request->input('size'),
            'available_size' => $request->input('size'),
            'property_images' => $propertyImagePath,
            'land_survey' => $landSurveyPath,
            'contract_deed' => $contractDeedPath,
            'video_link' => $request->input('video_link'),
            'google_map' => $request->input('google_map'),
            'year' => $request->input('year'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.properties.index')->with('success', 'Property created successfully.');
    }
  


    public function update(Request $request, $id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);

        // Validate the request (aligned with store method)
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'lunch_price' => 'required|numeric',
            'price' => 'required|numeric',
            'size' => 'required|string|max:255',
            'gazette_number' => 'required|string|max:50',
            'tenure_free' => 'required|string|max:50',
            'property_images' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
            'payment_plan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'brochure' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'land_survey' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'contract_deed' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5048',
            'video_link' => 'nullable|url|max:255',
            'google_map' => 'nullable|url',
            'status' => 'required|in:available,sold',
            'updated_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $year = $request->input('updated_year', Carbon::now()->year);
        $lunchPrice = $request->input('lunch_price');
        $newPrice = $request->input('price');
        $previousPrice = $property->price;
        $previousPercentageIncrease = $property->percentage_increase;
        $previousYear = $property->year;

        $percentageIncrease = $lunchPrice > 0 ? (($newPrice - $lunchPrice) / $lunchPrice) * 100 : 0;
       
        // Calculate price ratio for updating transactions
        $priceRatio = $previousPrice > 0 ? $newPrice / $previousPrice : 1;
        
        // Log the price update (only if price changed)
        if ($previousPrice != $newPrice) {
            PropertyPriceUpdate::create([
                'property_id' => $property->id,
                'previous_price' => $previousPrice,
                'previous_percentage_increase' => $previousPercentageIncrease,
                'previous_year' => $previousYear,
                'updated_price' => $newPrice,
                'percentage_increase' => $percentageIncrease,
                'updated_year' => $year
            ]);
            // Update all transactions for this property with new amounts
            $this->updatePropertyTransactions($property->id, $priceRatio, $newPrice);
        }

        // Prepare update data
        $updateData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'lunch_price' => $lunchPrice,
            'price' => $newPrice,
            'percentage_increase' => $percentageIncrease,
            'gazette_number' => $request->input('gazette_number'),
            'tenure_free' => $request->input('tenure_free'),
            'size' => $request->input('size'),
            'available_size' => $request->input('size'),
            'video_link' => $request->input('video_link'),
            'google_map' => $request->input('google_map'),
            'status' => $request->input('status'),
            'year' => $year,
        ];

        // Handle file uploads
        $updateData = $this->handleFileUpdate($request, $property, 'property_images', $updateData);
        $updateData = $this->handleFileUpdate($request, $property, 'payment_plan', $updateData);
        $updateData = $this->handleFileUpdate($request, $property, 'brochure', $updateData);
        $updateData = $this->handleFileUpdate($request, $property, 'land_survey', $updateData);
        $updateData = $this->handleFileUpdate($request, $property, 'contract_deed', $updateData);

        $property->update($updateData);

        return redirect()->back()->with('success', 'Property updated successfully.');
    }

    /**
     * Update all transactions for a property when price changes
     */
    private function updatePropertyTransactions($propertyId, $priceRatio, $newPrice)
    {
        // Get all transactions for this property
        $transactions = Transaction::where('property_id', $propertyId)->get();

        foreach ($transactions as $transaction) {
            // Calculate new amount based on price ratio
            $newAmount = $transaction->amount * $priceRatio;
             
            // Update the transaction amount
            $transaction->update([
                'amount' => $newAmount,
                'updated_at' => now()
            ]);

            // Optional: Log the transaction update for audit trail
            TransactionUpdateLog::create([
                'transaction_id' => $transaction->id,
                'previous_amount' => $transaction->getOriginal('amount'),
                'new_amount' => $newAmount,
                'price_ratio' => $priceRatio,
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Helper method for file updates
     */
    private function handleFileUpdate(Request $request, $property, $field, $updateData)
    {
        if ($request->hasFile($field)) {
            // Delete old file if exists
            if ($property->$field && file_exists(public_path($property->$field))) {
                unlink(public_path($property->$field));
            }
             
            $folder = str_replace('_', '', $field) . 's'; // Convert 'property_images' to 'propertyimages'
            $filePath = $request->file($field)->move(
                public_path('assets/images/' . $folder),
                time() . '_' . $request->file($field)->getClientOriginalName()
            );
            
            $updateData[$field] = 'assets/images/' . $folder . '/' . basename($filePath);
        }
        
        return $updateData;
    }

     public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $property = Property::findOrFail( decrypt($id));
        $state = [
            "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", 
            "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", 
            "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", 
            "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", 
            "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara", "FCT"
        ];
        return view('admin.home.properties.edit', compact('property', 'state'));
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
             if ($year = request('filter')) {
                return $query->whereYear('created_at', $year);
            }
            return $query;
        })
        ->orderBy('created_at', 'asc')  
        ->get(); 

        $data['initialValueSum'] = PropertyValuationSummary::where('property_id', $propertyId)->value('initial_value_sum') ?? 0;
       
        $data['valueSum'] = $this->calculateValuationSums($data['propertyValuation']);
        $data['marketValueSum'] = $data['valueSum']['marketValueSum'];
        
        // Calculate cumulative market_value sums
        $cumulativeMarketSum = 0;
        $data['comparisonData'] = $data['propertyValuation']->map(function ($valuation) use (&$cumulativeMarketSum) {
            $cumulativeMarketSum += $valuation->market_value;
            
            return [
                'date' => $valuation->created_at->format('Y-m-d'), // Format for ApexCharts
                'market_value' => $cumulativeMarketSum, // Cumulative sum
                'initial_value_sum' => $valuation->initial_value ?? 0, // Adjust if needed
            ];
        });

        // Get the latest market_value (last record)
        $latestMarketValue = $data['propertyValuation']->last()->market_value ?? 0;
        
        // dd($data['comparisonData']); 
        $percentage_value = 0;
        if ($data['initialValueSum'] > 0) {
            $percentage_value = ceil((($data['marketValueSum'] - $data['initialValueSum']) / $data['initialValueSum']) * 100);
        }
        $data['percentageIncrease'] = $percentage_value;

        $data['propertyValuationPrediction'] = PropertyValuationPrediction::where('property_id', $data['property']->id)
        ->when(request('filter'), function ($query) {
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
        return view('admin.home.properties.evaluation.evaluate', $data);
    }

    public function valuationUpdate(Request $request, $id){
    
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'valuation_type' => 'required|string|max:255',
            'current_price' => 'required|string|min:0',
            'market_value' => 'required|string|min:0',
            'percentage_increase' => 'required|string|min:0',
        ]);

        $propertyValuations = PropertyValuation::where('property_id', $request->property_id)
        ->where('id', $id)
        ->get();

        $valueSum = $this->calculateValuationSums($propertyValuations, $id);
    
        $currentPrice = preg_replace('/[₦,]/', '', $request->current_price);
        $marketValue = preg_replace('/[₦,]/', '', $request->market_value);

        $percentageIncrease = 0;
        if ($currentPrice > 0) {
            $percentageIncrease = ceil((($marketValue - $currentPrice) / $currentPrice) * 100);
        }
       
        $data['propertyValuation'] = PropertyValuation::where('property_id', $request->property_id)
        ->when(request('filter'), function ($query) {
             if ($year = request('filter')) {
                return $query->whereYear('created_at', $year);
            }
            return $query;
        })
        ->orderBy('created_at', 'asc') 
        ->get(); 
        $initialMarketValue = $data['propertyValuation']->sum('market_value');
        $propertyValuationSummary = PropertyValuationSummary::firstOrNew([
            'property_id' => $request->property_id,
        ]);
        $propertyValuationSummary->initial_value_sum = $initialMarketValue;
        $propertyValuationSummary->save();  

       
        $propertyValuation = PropertyValuation::findOrFail($id);
        $propertyValuation->update([
            'property_id' => $request->property_id,
            'valuation_type' => $request->valuation_type,
            'current_price' => $currentPrice,
            'market_value' => $marketValue,
            'percentage_increase' => $percentageIncrease,
        ]);
        //PropertyValuationSummary
        $updatedPropertyValuation = PropertyValuation::where('property_id', $request->property_id)
        ->when(request('filter'), function ($query) {
             if ($year = request('filter')) {
                return $query->whereYear('created_at', $year);
            }
            return $query;
        })
        ->orderBy('created_at', 'asc') 
        ->get(); 
        $currentMarketValue = $updatedPropertyValuation->sum('market_value');
        $propertyValuationSummary = PropertyValuationSummary::firstOrNew([
            'property_id' => $request->property_id,
        ]); 
        $percentage_value = 0;
        if ($initialMarketValue > 0) {
            $percentage_value = ceil((($currentMarketValue - $initialMarketValue) / $initialMarketValue) * 100);
        }
        $propertyValuationSummary->current_value_sum = $currentMarketValue;
        $propertyValuationSummary->percentage_value = $percentage_value;
        $propertyValuationSummary->save();  
        
        // Update the Property price
        $property = Property::findOrFail($request->property_id);
        $lunchPrice = $property->lunch_price;
        $priceIncrease = $lunchPrice > 0 ? (($marketValue - $lunchPrice) / $lunchPrice) * 100 : 0;

        $property->price = $marketValue; 
        $property->percentage_increase = $priceIncrease; 
        $property->save();  

        $user = User::where('email', 'eshanokpe@gmail.com')->first();
        if ($user) {
            $user->notify(new PropertyValuationNotification($property, $percentageIncrease));
        }

        // $users = User::all();
        // foreach ($users as $user) { 
        //     $user->notify(new PropertyValuationNotification($property, $percentageIncrease));
        // }
        
        return redirect()->route('admin.properties.evaluate', encrypt($property->id))
        ->with('success', 'Properties Valuation updated successfully!');
    }

    private function calculateValuationSums($propertyValuations)
    {
        // Calculate the total market value sum
        $marketValueSum = $propertyValuations->sum('market_value');

        // Calculate the initial value sum, excluding the most recent valuation
        $initialValueSum = $propertyValuations
            ->sortByDesc('created_at') 
            ->skip(1)                 
            ->sum('market_value');   

        // Calculate the percentage increase
        $percentageIncrease = $initialValueSum > 0
            ? (($marketValueSum - $initialValueSum) / $initialValueSum) * 100
            : 0;

        // Return the results as an array
        return [
            'marketValueSum' => $marketValueSum,
            'percentageIncrease' => round($percentageIncrease, 2), // Rounded to 2 decimal places
        ];
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
        
        $propertyValuation = PropertyValuation::create([
            'property_id' => $request->property_id,
            'valuation_type' => $request->valuation_type,
            'current_price' => $currentPrice,
            'market_value' => $marketValue,
            'percentage_increase' => $percentageIncrease,
        ]);
        PropertyValuationSummary::create([
            'property_id' => $request->property_id,
            'property_valuation_id' => $propertyValuation->id,
            'initial_value_sum' => $currentPrice
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

    public function valuationPredictionStore(Request $request)
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
        
        $propertyValuationPrediction = PropertyValuationPrediction::create([
            'property_id' => $request->property_id,
            'future_date' => $request->valuation_type,
            'current_price' => $currentPrice,
            'future_market_value' => $marketValue,
            'percentage_increase' => $percentageIncrease,
        ]);
 
        
        $property = Property::findOrFail($request->property_id);
        $lunchPrice = $property->lunch_price;
        $priceIncrease = $lunchPrice > 0 ? (($marketValue - $lunchPrice) / $lunchPrice) * 100 : 0;


        $users = User::all();
        foreach ($users as $user) { 
            $user->notify(new PropertyValuationPredictionNotification($property, $priceIncrease, $marketValue, $propertyValuationPrediction));
        }

        return redirect()->back()->with('success', 'Valuation Prediction added successfully.');
    }

    public function valuationEdit($id){
        $propertyId = decrypt($id); 
        $data['propertyValuation'] = PropertyValuation::findOrFail($propertyId);
        $data['property'] = Property::findOrFail($data['propertyValuation']->property_id);
   
        return view('admin.home.properties.evaluation.edit-evaluation', $data);
    }

    public function valuationPredictionEdit($id){
        $propertyId = decrypt($id); 
        $data['propertyValuationPrediction'] = PropertyValuationPrediction::findOrFail($propertyId);
        $data['property'] = Property::findOrFail($data['propertyValuationPrediction']->property_id);
        return view('admin.home.properties.evaluation.edit-evaluation-prediction', $data);
    }


    public function valuationPredictionUpdate(Request $request, $id){
     
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'future_date' => 'required|string|max:255',
            'current_price' => 'required|string|min:0',
            'future_market_value' => 'required|string|min:0',
            'percentage_increase' => 'required|string|min:0',
        ]);

        // Parse numeric values from currency format if necessary
        $currentPrice = preg_replace('/[₦,]/', '', $request->current_price);
        $marketValue = preg_replace('/[₦,]/', '', $request->future_market_value);

        $percentageIncrease = 0;
        if ($currentPrice > 0) {
            $percentageIncrease = ceil((($marketValue - $currentPrice) / $currentPrice) * 100);
        }
        $propertyValuationPrediction = PropertyValuationPrediction::findOrFail($id);
        $propertyValuationPrediction->update([
            'property_id' => $request->property_id,
            'future_date' => $request->future_date,
            'current_price' => $currentPrice,
            'future_market_value' => $marketValue,
            'percentage_increase' => $percentageIncrease,
        ]);


        return redirect()->back()->with('success', 'Properties Valuation Prediction updated successfully!');
    }

    public function valuationDelete($id){
        $propertyValuation = PropertyValuation::findOrFail(decrypt($id));
        $propertyValuation->delete();
        return redirect()->back()->with('success', 'Property Valuation deleted successfully.');
    }

    public function valuationPredictionDelete($id){
        $propertyValuationPrediction = PropertyValuationPrediction::findOrFail(decrypt($id));
        $propertyValuationPrediction->delete();
        return redirect()->back()->with('success', 'Property Valuation Prediction deleted successfully.');
    }

    public function neighborhood($id)
    {
        
        $propertyId = decrypt($id);
        $data['property'] = Property::findOrFail($propertyId);
        $data['categories'] = NeighborhoodCategory::all();
        $data['neighborhoods'] = Neighborhood::with(['property', 'category'])->get();
       
        return view('admin.home.properties.neighborhood.neighborhood', $data);
    }

    public function storeNeighborhood(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'neighborhood_category_id' => 'required|exists:neighborhood_categories,id',
            'neighborhood_name' => 'required|string|max:255',
            'distance' => 'nullable|string|max:255',
        ]);
    
        Neighborhood::create([
            'property_id' => $request->property_id,
            'neighborhood_category_id' => $request->neighborhood_category_id,
            'neighborhood_name' => $request->neighborhood_name,
            'distance' => $request->distance,
        ]);
    
        return redirect()->back()->with('success', 'Neighborhood saved successfully!');
    }

    public function editNeighborhood($id)
    {

        $data['neighborhood'] = Neighborhood::findOrFail(decrypt($id));
        $data['categories'] = NeighborhoodCategory::all(); // Retrieve all categories for the dropdown
        $data['neighborhoods'] = Neighborhood::with(['property', 'category'])->get();
        // dd();
        $data['property'] = Property::findOrFail($data['neighborhood']->property_id);

        return view('admin.home.properties.neighborhood.edit-neighborhood', $data);
    }

    public function updateNeighborhood(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'neighborhood_category_id' => 'required|exists:neighborhood_categories,id',
            'neighborhood_name' => 'required|string|max:255',
            'distance' => 'nullable|string|max:255',
        ]);

        $neighborhoodDetail = Neighborhood::findOrFail($id);
        $neighborhoodDetail->update([
            'property_id' => $request->property_id,
            'neighborhood_category_id' => $request->neighborhood_category_id,
            'neighborhood_name' => $request->neighborhood_name,
            'distance' => $request->distance,
        ]);

        return redirect()->back()->with('success', 'Neighborhood details updated successfully!');
    }

    public function neighborhoodCategory(){
        $data['categories'] = NeighborhoodCategory::all();
        $data['editNeighborhoodCategory'] = null;
        return view('admin.home.properties.neighborhood.neighborhoodCategory', $data);
    }

    public function neighborhoodCategoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        NeighborhoodCategory::create([
            'name' => $request->name,
        ]);
    
        return redirect()->back()->with('success', 'Neighborhood Category saved successfully!');
    }

    public function neighborhoodCategoryEdit($id){
        $data['editNeighborhoodCategory'] = NeighborhoodCategory::findOrFail(decrypt($id));
        $data['categories'] = NeighborhoodCategory::all();
        return view('admin.home.properties.neighborhood.neighborhoodCategory', $data);
    }

    public function neighborhoodCategoryDelete($id){
        $neighborhoodCategory= NeighborhoodCategory::findOrFail(decrypt($id));
        $neighborhoodCategory->delete();
        return redirect()->back()->with('success', 'Neighborhood Category deleted successfully.');
    }

    public function neighborhoodCategoryUpdate(Request $request, $id)
    {
        $request->validate([
            'neighborhood_category_id' => 'required|exists:neighborhood_categories,id',
            'name' => 'required|string|max:255',
        ]);

        $neighborhoodDetail = NeighborhoodCategory::findOrFail($id);
        $neighborhoodDetail->update([
            'property_id' => $request->property_id,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Neighborhood Category updated successfully!');
    }
}
