<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'slug',
    ];


    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
