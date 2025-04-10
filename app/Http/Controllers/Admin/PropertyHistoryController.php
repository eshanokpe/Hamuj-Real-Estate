<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Neighborhood;
use App\Models\PropertyValuation;
use App\Models\PropertyPriceUpdate;
use App\Models\NeighborhoodCategory;
use App\Models\PropertyValuationSummary;
use App\Models\PropertyValuationPrediction;
use App\Notifications\PropertyValuationNotification;
use App\Notifications\PropertyValuationPredictionNotification;


class PropertyHistoryController extends Controller
{
     
    public function index($id)
    {  
        $propertyId = decrypt($id); 
        $data['property'] = Property::findOrFail($propertyId);
        $previousPrice = PropertyPriceUpdate::where('property_id', $propertyId)
            ->orderBy('created_at', 'desc')
            ->first();
        $data['previousPrice'] = $previousPrice;

        return view('admin.home.properties.propertyHistory.propertyHistory', $data);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'updated_price' => 'required|string|min:1',
        ]);

        // Fetch the property and previous price
        $property = Property::findOrFail($validatedData['property_id']);
        $previousPrice = $property->history()->latest()->first();

        if (!$previousPrice) {
            return redirect()->back()->withErrors(['previous_price' => 'No previous price available for this property.']);
        }

        // Calculate the percentage increase
        $updatedPrice = (float) str_replace(',', '', $validatedData['updated_price']);
        $percentageIncrease = (($updatedPrice - $previousPrice->previous_price) / $previousPrice->previous_price) * 100;
        $year = $request->input('updated_year', Carbon::now()->year);

        // $propertyHistory = PropertyPriceUpdate::create([
        //     'property_id' => $validatedData['property_id'],
        //     'previous_year' => $previousPrice->previous_year, // Assuming this is fetched from previous data
        //     'previous_price' => $previousPrice->previous_price,
        //     'updated_price' => $updatedPrice,
        //     'percentage_increase' => $percentageIncrease,
        //     'updated_year' => $year,
        // ]);
        PropertyPriceUpdate::create([
            'property_id' => $validatedData['property_id'],
            'previous_price' => $previousPrice->previous_price,
            'previous_year' => $previousPrice->previous_year,
            'updated_price' => $updatedPrice,
            'percentage_increase' => $percentageIncrease,
            'updated_year' => $year,
        ]);

        // Redirect back with success message
        return redirect()
            ->back()
            ->with('success', 'Property history updated successfully!');
    }

    public function destroy($id)
    {
        $propertyHistory = PropertyPriceUpdate::findOrFail(decrypt($id));
        $propertyHistory->delete();

        return redirect()
            ->back()
            ->with('success', 'Property history deleted successfully!');
    }

    public function edit($id)
    {
        $propertyHistory = PropertyPriceUpdate::findOrFail(decrypt($id));

        return view('admin.home.properties.propertyHistory.editPropertyHistory', compact('propertyHistory'));
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $validatedData = $request->validate([
            'updated_year' =>'required|string',
            'previous_price' => 'required|string',
            'updated_price' => 'required|string|min:1',
            'percentage_increase' => 'required|string',
        ]);

        $propertyHistory = PropertyPriceUpdate::findOrFail(decrypt($id));
        

        $updatedPrice = (float) str_replace(',', '', $validatedData['updated_price']);
        $previousPrice = (float) str_replace(['₦', ','], '', $validatedData['previous_price']);
        // dd($previousPrice);
        $year = $request->input('updated_year', $validatedData['updated_year']);

        $propertyHistory->update([
            'previous_price' => $previousPrice,
            // 'previous_year' => $propertyHistory->previous_year,
            'updated_price' => $updatedPrice,
            'percentage_increase' => $validatedData['percentage_increase'],
            'updated_year' => $year,
        ]);

        return redirect()
            ->route('admin.properties.propertyHistory', encrypt($propertyHistory->property_id))
            ->with('success', 'Property history updated successfully!');
    }
}