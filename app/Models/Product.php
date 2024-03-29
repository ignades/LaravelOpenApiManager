<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $table = 'products';

    protected $dates = [];

    protected $fillable = [
        'name',
        'description',
        'stock',
        'price'
    ];

}
