<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = ['name', 'price', 'category', 'brand', 'sale', 'sale-value', 'company', 'photo', 'detail', 'id_user'];
    public $timestamps = true;
}
