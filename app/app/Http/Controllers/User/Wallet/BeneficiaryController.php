<?php

namespace App\Http\Controllers\User\Wallet;
use Auth;
use Log;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Http;
use App\Notifications\WalletTransferNotification;

class BeneficiaryController extends Controller
{

    public function index()
    { 
        $beneficiaries = Beneficiary::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $beneficiaries
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'bank_code' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'recipient_code' => 'nullable|string|max:255',
        ]);

        // Check if beneficiary already exists
        $exists = Beneficiary::where('user_id', auth()->id())
            ->where('account_number', $validated['account_number'])
            ->where('bank_code', $validated['bank_code'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'info',
                'message' => 'This beneficiary already exists in your list'
            ]);
        }

        $beneficiary = Beneficiary::create(array_merge(
            $validated,
            ['user_id' => auth()->id()]
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'Beneficiary saved successfully',
            'data' => $beneficiary
        ]);
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'beneficiary_id' => 'required|integer|exists:beneficiaries,id,user_id,'.auth()->id()
        ]);

        try {
            $beneficiary = Beneficiary::where('user_id', auth()->id())
                ->where('id', $validated['beneficiary_id'])
                ->firstOrFail();

            $beneficiary->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Beneficiary deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting beneficiary: '.$e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete beneficiary'
            ], 500);
        }
    }
  
}