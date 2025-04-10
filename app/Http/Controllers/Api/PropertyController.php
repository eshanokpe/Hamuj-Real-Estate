<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\PropertyValuation;
use App\Models\Transaction;
// or
use function App\Helpers\getWalletBalance; 
 
class PropertyController extends Controller
{
    

    public function propertiesShow($id)
    {
        $users = Auth::user();
        $data['property'] = Property::findOrFail(($id));
        $data['user'] = User::where('id', $users->id)
                        ->where('email', $users->email)
                        ->first();
        $neighborhoods = Neighborhood::with(['property', 'category'])->get();
 
        $data['neighborhoods'] = $neighborhoods->groupBy(function ($item) {
            return $item->category->name ?? 'Uncategorized';
        }); 

        $data['propertyValuation'] = PropertyValuation::where('property_id', $data['property']->id)
        ->when(request('filter'), function ($query) {
             if ($year = request('filter')) {
                return $query->whereYear('created_at', $year);
            }
            return $query;
        })
        ->orderBy('created_at', 'asc') 
        ->get(); 

        if (request()->wantsJson()) {
            return response()->json([
                'property' => $data['property'],
                'valuation_summary' => $data['property']->valuationSummary,
                'neighborhoods' => $data['neighborhoods'],
                'propertyValuation' => $data['propertyValuation'],
            ]);
        }
    }
}