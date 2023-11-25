<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countrys';
    protected $fillable = ['name', 'id_user'];
    public $timestamps = true;
}
