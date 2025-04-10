<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buy;

class BuyController extends Controller
{
    //
    public function index()
    {
        //$buys = Buy::all();
        $buys = Buy::latest()->paginate(10);
        return view('admin.home.buy.index', compact('buys'));
      
    }
    public function edit($id)
    {
        $buy = Buy::findOrFail(decrypt($id));
        return view('admin.home.buy.edit', compact('buy'));
    }

    public function destroy($id)
    {
        $buy = Buy::findOrFail(decrypt($id)); // not Post::findOrFail()
        $buy->delete();

        return redirect()->route('admin.buy.index')->with('success', 'Buy Property deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $buy = Buy::findOrFail($id);

        $updateData = [
            'status' => $request->status,
        ];

        $buy->update($updateData);

        return redirect()->route('admin.buy.index')->with('success', 'Buy Property updated successfully.');
    }

}
 