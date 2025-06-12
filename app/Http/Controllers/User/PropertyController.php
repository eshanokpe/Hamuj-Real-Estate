<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Log;
use DB;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use App\Models\Offerprice;
use App\Models\PropertyValuation;
use App\Models\PropertyValuationSummary;
use App\Models\PropertyValuationPrediction;



 
class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }  
 
    public function index(Request $request){
        $user = Auth::user(); 
       
        $data['user'] = User::where('id', $user->id)->where('email', $user->email)->first();
        $data['properties'] = Property::with('valuationSummary')->latest()->paginate(10); 
 
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'user' => $data['user'],
                'properties' => $data['properties'],
            ]);
        } 
        return view('user.pages.properties.index',$data); 
    }
 
    public function indexAPI(){
        $user = Auth::user(); 
       
        try {
            $properties = Property::with('valuationSummary')->latest()->paginate(10); 
            
            return response()->json([
                'user' => $user, // Send the authenticated user object directly
                'properties' => $properties,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching properties in indexAPI: ' . $e->getMessage());
            return response()->json(['error' => 'Server error while fetching properties.', 'details' => $e->getMessage()], 500);
        }
    }

    public function buy(){
        $user = Auth::user();
        
        $data['buyProperty'] = Buy::select(
            'property_id', 
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property')
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id')  
        ->paginate(10);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' =>  $data['buyProperty']
            ]);
        } 

        return view('user.pages.properties.buy', $data); 
    } 

    public function offerPrice($id){
        $user = Auth::user();
        $data['user'] = User::where('id', $user->id)->where('email', $user->email)->first();

        $data['buy'] = Buy::with('property')->where('property_id', decrypt($id))->first();
        return view('user.pages.properties.offer_price', $data); 
    }

    public function offerPricePost(Request $request)
    {
       $validated = $request->validate([
            'buy_id' => 'required|exists:buys,id',
            'property_id' => 'required|exists:properties,id',
            'offer_price' => 'required|min:1',
        ]);

        $buyId = $request->input('buy_id');
        $propertyId = $request->input('property_id');
        $offerPrice = str_replace(',', '', $request->input('offer_price'));
        try{
            $property = Property::find($propertyId);
            if (!$property) {
                return redirect()->back()->with('error', 'Property not found.');
            }

            if ($offerPrice < $property->price) {
                return redirect()->back()->with('error', 'Your offer price must not be less than the property price.');
            }

            Offerprice::create([
                'property_id' => $propertyId,
                'buy_id' => $buyId,
                'amount' => $offerPrice,
            ]);

            // Redirect with a success message
            return redirect()->route('user.buy')->with('success', 'Your offer price has been submitted successfully.');
        }catch(Exception $e){
            return redirect()->route('user.buy')->with('error', 'Error'.$e->getMessage());
        }
    }

    public function add(){
        $user = Auth::user();
        $data['buyProperty'] = Buy::with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->where('user_email', 'buy')
        ->latest() 
        ->paginate(10);
        $data['user'] = User::where('id', $user->id)->first();

        return view('user.pages.properties.transfer.add',  $data); 
    } 

    public function valuation($id)
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
        $percentage_value = 0;
        if ($data['initialValueSum'] > 0) {
            $calculated_percentage = (($data['marketValueSum'] - $data['initialValueSum']) / $data['initialValueSum']) * 100;
            $percentage_value = ceil($calculated_percentage);
            // Correct -0.0 (negative zero) to 0.0 (positive zero)
            if ($percentage_value === -0.0) {
                $percentage_value = 0.0;
            }
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
                'price' => number_format((float)$valuation->market_value, 2, '.', ','),
            ];
        });
    
        $data['valuationData'] = $valuationData;
        return view('user.pages.properties.valuation', $data);
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

    public function propertyHistory($id){
        $propertyId = decrypt($id);  
        $data['property'] = Property::findOrFail($propertyId);
        return view('user.pages.properties.history', $data);
    }
}
