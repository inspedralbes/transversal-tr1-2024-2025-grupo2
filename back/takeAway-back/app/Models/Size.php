<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;


class Size extends Model
{
    use HasFactory;

    public function size()
    {
        return $this->hasMany(Product::class); // <- el metodo hasMany establece una relacion de uno a muchos 
    }
}
