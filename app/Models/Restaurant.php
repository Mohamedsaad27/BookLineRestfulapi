<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $primaryKey = 'Restaurant_id';

    protected $fillable = [
        'Restaurant_Name',
        'image'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'restaurant_id', 'Restaurant_id');
    }
}

