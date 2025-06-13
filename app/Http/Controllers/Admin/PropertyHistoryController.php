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

        // Fetch the property and its most recent history
        $property = Property::findOrFail($validatedData['property_id']);
        $previous = $property->history()->latest()->first();

        // Clean and parse the updated price
        $updatedPrice = (float) str_replace(',', '', $validatedData['updated_price']);

        // Set previous price and year
        if ($previous) {
            $previousPriceValue = $previous->updated_price;
            $previousYear = Carbon::parse($previous->updated_year)->year;
        } else {
            $previousPriceValue = 0.00;
            $previousYear = now()->subYear()->year;
        }

        // Calculate the percentage increase safely
        $percentageIncrease = $previousPriceValue > 0
            ? (($updatedPrice - $previousPriceValue) / $previousPriceValue) * 100
            : 0;

        // Use the current year or override if provided (ensure it's an integer)
        $updatedYear = (int) $request->input('previous_year', now()->year);

        // Create the price update record
        PropertyPriceUpdate::create([
            'property_id' => $validatedData['property_id'],
            'previous_price' => $previousPriceValue,
            'previous_year' => $previousYear,
            'updated_price' => $updatedPrice,
            'percentage_increase' => $percentageIncrease,
            'updated_year' => $updatedYear,
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