<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->paginate(20);
        return view('admin.home.user.index', compact('users'));
    } 

    public function toggleActive(User $user)
    {
        $user->active = !$user->active; // Toggle the boolean value
        $user->save();

        $statusMessage = $user->active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "User {$statusMessage} successfully.");
    }

    public function edit($id)
    {
        $user = User::findOrFail(decrypt($id));
        return view('admin.home.user.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail(decrypt($id)); 
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
