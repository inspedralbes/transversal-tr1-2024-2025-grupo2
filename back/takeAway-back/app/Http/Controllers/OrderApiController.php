<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'quantity' => 0
        ]);

        $totalPrice = 0;

        foreach ($request->products as $product) {
            // Obtén el producto de la base de datos
            $dbProduct = Product::findOrFail($product['id']);

            $price = (float) $dbProduct->price;

            $totalPrice += $price * $product['quantity'];

            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $price,
            ]);
        }

        $order->update(['finalprice' => $totalPrice]);
        $order->save();

        return response()->json(['message' => 'Orden recibida']);
    }

}
