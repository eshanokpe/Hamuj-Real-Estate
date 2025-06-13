<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\PropertyValuation; 
use App\Models\Transaction;
use App\Models\PropertyValuationPrediction;
use function App\Helpers\getWalletBalance; 
 
class PropertyController extends Controller
{
    

    public function propertiesShow($id)
    { 
        $users = Auth::user();
        $data['property'] = Property::with(['priceUpdates', 'valuationSummary'])
        ->findOrFail($id);
        $data['user'] = User::where('id', $users->id)
                        ->where('email', $users->email)
                        ->first();
        $neighborhoods = Neighborhood::with(['property', 'category'])->get();
 
        $data['neighborhoods'] = $neighborhoods->groupBy(function ($item) {
            return $item->category->name ?? 'Uncategorized';
        }); 

        $data['propertyValuation'] = PropertyValuation::where('property_id', $data['property']->id)
      
        ->orderBy('created_at', 'asc') 
        ->get(); 

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
        $valuationData = $data['property']->priceUpdates->sortBy('created_at'); // Sort chronologically
 
        $chartData = $valuationData->map(function ($update) {
            return [
                'date' => $update->updated_year, // e.g., "2024-Dec-03"
                'price' => number_format((float)$update->updated_price, 2, '.', ','),
            ];
        })->values(); 

        $data['valuationData'] = $chartData; 
 
        if (request()->wantsJson()) { 
            return response()->json([
                'property' => $data['property'],
                'valuation_summary' => $data['property']->valuationSummary,
                'neighborhoods' => $data['neighborhoods'],
                'propertyValuation' => $data['propertyValuation'],
                'propertyValuationPrediction' => $data['propertyValuationPrediction'],
                'property_history' => $data['property']->priceUpdates,
                'valuationChatData' => $data['valuationData'],
              
            ]);
        }
    }
}