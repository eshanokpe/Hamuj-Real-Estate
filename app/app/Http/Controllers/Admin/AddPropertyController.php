<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PropertyType;

  
class AddPropertyController extends Controller
{ 
     
    public function propertyType(Request $request)
    {
        $propertyTypes = PropertyType::all();

        // If request is expecting JSON (e.g. from mobile app / API)
        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Property Types fetched successfully',
                'data' => $propertyTypes
            ], 200);
        }

        // Default: return Blade view for web
        return view('admin.home.addProperty.propertyType.index', compact('propertyTypes'));
    }


    public function creatPropertyType()
    {
        return view('admin.home.addProperty.propertyType.create');
    }

    public function storePropertyType(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:property_types,title',
            'subtitles' => 'nullable|array',
            'subtitles.*' => 'nullable|string|max:255',
        ]);

        PropertyType::create([
            'title' => $request->title,
            'subtitles' => $request->subtitles,
        ]);

        return redirect()->route('admin.property.type.index')
                         ->with('success', 'Property Type created successfully!');
    }

    // Show edit form
    public function editPropertyType($id)
    {
        $propertyType = PropertyType::findOrFail( decrypt($id));
        return view('admin.home.addProperty.propertyType.edit', compact('propertyType'));
    }

    // Update property type
    public function updatePropertyType(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitles' => 'nullable|array',
            'subtitles.*' => 'nullable|string|max:255',
        ]);

        $propertyType = PropertyType::findOrFail(decrypt($id));

        $propertyType->update([
            'title' => $request->title,
            'subtitles' => $request->subtitles, // stored as JSON (cast in model)
        ]);

        return redirect()->route('admin.property.type.index')
                        ->with('success', 'Property Type updated successfully!');
    }


    // Delete property type
    public function destroyPropertyType($id)
    {
        $propertyType = PropertyType::findOrFail(decrypt($id));
        $propertyType->delete();

        return redirect()->route('admin.property.type.index')
                         ->with('success', 'Property Type deleted successfully!');
    }
}