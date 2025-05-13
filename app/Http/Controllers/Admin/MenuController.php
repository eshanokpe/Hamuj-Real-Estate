<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\ProjectMenu;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Support\Str;
use App\Http\Traits\AdminTrait;

class MenuController extends Controller
{
    use AdminTrait;
    public function creat(){
        return view('admin.menu.create');
    }

    public function index(){
        $menuItems = MenuItem::with('dropdownItems')->get();
        return view('admin.menu.index', compact('menuItems'));
    }
 
    public function store(Request $request){
        $this->validateMenu($request); 
        $name = $request->name; 
        $slug = Str::slug($request->name);
        $menuItem = new MenuItem();
        $menuItem->name = $name ;
        $menuItem->slug =  $slug;
        $menuItem->save();


        $menuItem['slug'] = Str::slug($request->name);
        if ($request->has('dropdown_items')) {
            $this->createDropdownItems($menuItem, $request->dropdown_items);
        }
        return redirect()->route('admin.menu.create')->with('success', 'Menu item created successfully!');
    }
 
    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail(decrypt($id));
        return view('admin.menu.edit', compact('menuItem'));
    }

    public function update(Request $request, $id)
    {
        $this->validateMenu($request);

        $menuItem = MenuItem::findOrFail($id);
        // Update the URL only if 'name' is provided
        if ($request->has('name')) {
            $menuItem->name = $request->name;
            $menuItem->slug = Str::slug($request->name);
        }
        $menuItem->save();
        
        $menuItem->dropdownItems()->delete();
        if ($request->has('dropdown_items')) {
            $this->createDropdownItems($menuItem, $request->dropdown_items);
        } 
        return redirect()->back()->with('success', 'Menu item updated successfully!');
    }
    
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail(decrypt($id));
        $menuItem->dropdownItems()->delete();
        $menuItem->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted successfully!');
    }

   

}
