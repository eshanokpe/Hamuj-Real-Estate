<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Auth;

class KycController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'phone_number' => 'required|string|max:20',
            'bvn' => 'required|string|size:11|unique:kyc_details,bvn',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:20',
            'id_type' => 'required|string|in:passport,driver_license,national_id,voter_id',
            'id_number' => 'required|string|max:50',
            'id_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload
        $imagePath = $request->file('id_image')->store('public/id_images');
        $imageUrl = Storage::url($imagePath);

        $kyc = KycDetail::create([
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'bvn' => $request->bvn,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'id_image_path' => $imageUrl,
        ]);

        return response()->json([
            'message' => 'KYC details submitted successfully',
            'data' => $kyc
        ], 201);
    }

    public function show()
    {
        $kyc = KycDetail::where('user_id', auth()->id())->first();
        
        if (!$kyc) {
            return response()->json(['message' => 'KYC details not found'], 404);
        }

        return response()->json($kyc);
    }
}