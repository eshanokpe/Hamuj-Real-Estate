<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Neighborhood;
use App\Models\Property;
// or
use function App\Helpers\getWalletBalance; 
 
class TransferPropertyController extends Controller
{
  

    public function transferDetails($id){ 
        $user = Auth::user();  
       
        $data['property'] = Property::with(['buys' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->with('valuationSummary')
        ->where('id', $id)
        ->firstOrFail(); 

        if (request()->wantsJson()) {
            // Return JSON response for mobile
            return response()->json([
                'success' => true,
                'data' => $data['property'],
            ]);
        } 

    }
}