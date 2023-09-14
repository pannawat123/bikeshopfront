<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product'; // ชื่อตาราง

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}