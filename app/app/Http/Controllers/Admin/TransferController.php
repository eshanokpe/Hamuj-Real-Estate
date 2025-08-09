<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use Carbon\Carbon;

class TransferController extends Controller
{
    //
    public function index()
    {
        $transfers = Transfer::latest()->paginate(20);
        return view('admin.home.transfer.index', compact('transfers'));
      
    }
    public function edit($id)
    {
        $transfer = Transfer::findOrFail(decrypt($id));
        return view('admin.home.transfer.edit', compact('transfer'));
    }

    public function destroy($id)
    {
        $transfer = Transfer::findOrFail(decrypt($id)); // not Post::findOrFail()
        $transfer->delete();

        return redirect()->route('admin.transfer.index')->with('success', 'Transfer Property deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required',
            'confirmation_status' => 'required',
            'confirmation_date' => 'required',
            'confirmed_by' => 'required',
        ]);

        $date = $request->confirmation_date;
        $currentTime = now()->format('H:i:s'); // Current system time
        $confirmation_date = Carbon::parse($date . ' ' . $currentTime);

        $transfer = Transfer::findOrFail($id);

        $updateData = [
            'status' => $request->status,
            'confirmation_status' => $request->confirmation_status,
            'confirmation_date' => $confirmation_date,
            'confirmed_by' => $request->confirmed_by,
            'rejection_reason' => $request->rejection_reason,
        ];

        $transfer->update($updateData);

        return redirect()->route('admin.transfer.index')->with('success', 'Transfer Property updated successfully.');
    }

}