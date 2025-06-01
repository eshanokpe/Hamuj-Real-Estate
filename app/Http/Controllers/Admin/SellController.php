<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;

class SellController extends Controller
{
    public function index()
    {
        $sells = Sell::latest()->paginate(10);
        return view('admin.home.sell.index', compact('sells'));
      
    }
    public function edit($id)
    {
        $sell = Sell::findOrFail(decrypt($id));
        return view('admin.home.sell.edit', compact('sell'));
    }

    public function destroy($id)
    {
        $sell = Sell::findOrFail(decrypt($id)); // not Post::findOrFail()
        $sell->delete();

        return redirect()->route('admin.sell.index')->with('success', 'Sell Property deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $sell = Sell::findOrFail($id);

        $updateData = [
            'status' => $request->status,
        ];

        $sell->update($updateData);

        return redirect()->route('admin.sell.index')->with('success', 'Sell Property updated successfully.');
    }

}
