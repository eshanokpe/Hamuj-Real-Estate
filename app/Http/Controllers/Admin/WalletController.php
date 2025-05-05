<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    

    public function index()
    {
        $wallets = Wallet::with('user')->latest()->paginate(20);
        return view('admin.home.wallet.index', compact('wallets'));
    }
    

    public function edit($id)
    {
        $user = User::findOrFail(decrypt($id));
        return view('admin.home.user.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail(decrypt($id)); // not Post::findOrFail()
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, $id)
    {
       
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
            ]);

            //$user = User::findOrFail($id);
            $user = User::findOrFail(decrypt($id));


            $updateData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ];

            $user->update($updateData);

            return redirect()->route('admin.users')->with('success', 'User updated successfully.');

        
    }


}
