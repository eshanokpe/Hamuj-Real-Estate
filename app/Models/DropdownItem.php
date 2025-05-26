<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropdownItem extends Model
{
    use HasFactory;
    protected $fillable = ['menu_item_id', 'name', 'slug'];

    // Define relationship to MenuItem
    public function menuItem()
    { 
        return $this->belongsTo(MenuItem::class);
    }
}
