<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        
        Stripe::setApiKey(env('STRIPE_SECRET')); 

        $data = json_encode($request->items);

        try {
            // Crea una sesión de pago con los datos del carrito que se envían desde el frontend
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => array_map(function ($products) {
                    return [
                        'price_data' => [
                            'currency' => 'eur', 
                            'product_data' => [
                                'name' => $products['title'], // Nombre del producto
                            ],
                            'unit_amount' => $products['price'] * 100, // Precio en céntimos
                        ],
                        'quantity' => $products['quantity'],
                    ];
                }, $request->products),
                'mode' => 'payment',
                'success_url' => route('success')."?data=" . $data, // URL a la que redirigir después del pago
                'cancel_url' => route('cancel'), // URL a la que redirigir si el usuario cancela
            ]);    
            
            // Retorna la respuesta en JSON con el ID de la sesión
            return response()->json(['id' => $session->id ]);
        } catch (\Exception $e) {
            // En caso de error, retorna una respuesta de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
