<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
trait AdminTrait
{
    private function validateMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dropdown_items.*' => 'nullable|string|max:255',
        ]);
    }

    private function createDropdownItems($menuItem, $dropdownItems)
    {
        foreach ($dropdownItems as $dropdownItem) {
            $url = Str::slug($dropdownItem);
            $menuItem->dropdownItems()->create(['name' => $dropdownItem, 'slug' => $url]);
        }
    }
     
    private function validateSlider(Request $request, $isNew = true)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'additional_text' => 'required|string|max:255',
            'button_url' => 'required',
            'button_text' => 'required',
            'image' => ($isNew ? 'required|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,gif',
        ];
        $request->validate($rules);
    }

    private function uploadImageSlider($image)
    {
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('sliderImages'), $imageName);
        return 'sliderImages/' . $imageName;
    }

}