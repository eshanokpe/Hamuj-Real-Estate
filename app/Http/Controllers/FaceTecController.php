<?php
// app/Http/Controllers/FaceTecController.php

namespace App\Http\Controllers;

use App\Services\FaceTecService;
use Illuminate\Http\Request;

class FaceTecController extends Controller
{
    protected $facetec;

    public function __construct(FaceTecService $facetec)
    {
        $this->facetec = $facetec;
    }

    public function index()
    {
        return view('facetec.index');
    }


    public function createSession(Request $request)
    {
        $userId = auth()->id(); // or $request->user_id
        return response()->json($this->facetec->createSession($userId));
    }

    public function verifySession(Request $request)
    {
        $validated = $request->validate([
            'sessionId' => 'required',
            'faceScan' => 'required',
            'auditTrailImage' => 'required'
        ]);

        $result = $this->facetec->verifySession(
            $validated['sessionId'],
            $validated['faceScan'],
            $validated['auditTrailImage']
        );

        // Handle verification result
        if ($result['success'] && $result['livenessPassed']) {
            // Mark user as verified in your database
            return response()->json(['verified' => true]);
        }

        return response()->json(['verified' => false], 400);
    }
}