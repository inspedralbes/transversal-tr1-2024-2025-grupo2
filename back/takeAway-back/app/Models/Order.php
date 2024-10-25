<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'totalproducts',
        'finalprice',
        // Si decides agregar 'user_id' más adelante, inclúyelo aquí
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity', 'price'); // Cambia 'quantity' y 'price' según sea necesario
    }
}
