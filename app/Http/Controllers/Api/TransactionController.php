<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    

    public function store(Request $request)
    {
        // 1. Validate the request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'email' => 'required|email|exists:users,email',
            'property_id' => 'required|integer|exists:properties,id',
            'property_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:card,wallet,transfer,bank',
            'reference' => 'required|string|max:255|unique:transactions,reference',
            'transaction_state' => 'required|string|in:pending,success,failed,reversed',
            'status' => 'required|string|in:pending,success,failed',
            'source' => 'required|string|in:web,mobile_app,pos,agent', // Made required
            'metadata' => 'nullable|array',
            'metadata.source_details' => 'nullable|string',
            'metadata.device_info' => 'nullable|string',
            'metadata.ip_address' => 'nullable|ip',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // 2. Check for duplicate transaction with lock
        if (Transaction::where('reference', $request->reference)->lockForUpdate()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction already processed',
                'reference' => $request->reference
            ], 409);
        }

        // 3. Prepare metadata
        $defaultMetadata = [
            'source' => $request->source,
            'created_at' => now()->toDateTimeString(),
            'ip_address' => $request->ip()
        ];

        $metadata = array_merge($defaultMetadata, $request->metadata ?? []);

        // 4. Create transaction
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'email' => $request->email,
            'property_id' => $request->property_id,
            'property_name' => $request->property_name,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'reference' => $request->reference,
            'transaction_state' => $request->transaction_state,
            'status' => $request->status,
            'description'=> 'card',
            'payment_method' => 'card',
            'source' => $request->source,
            'metadata' => $metadata, // Store as JSON
        ]);

        
        return response()->json([
            'status' => 'success',
            'message' => 'Transaction created successfully',
            'transaction_id' => $transaction->id,
            'reference' => $transaction->reference,
            'metadata' => $transaction->metadata
        ], 201);
    }

    

}