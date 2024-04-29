<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'menu';
    protected $fillable = [
        'item_name',
        'item_image',
        'item_description',
        'item_category',
        'item_price',
        'category',
        'restaurant_id'
    ];

}
