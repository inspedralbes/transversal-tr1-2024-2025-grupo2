<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        
        // Configura la clave secreta de Stripe
        Stripe::setApiKey(env('STRIPE_SECRET')); // Asegúrate de que STRIPE_SECRET esté en tu archivo .env

        try {
            // Crea una sesión de pago con los datos del carrito que se envían desde el frontend
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => array_map(function ($item) {
                    return [
                        'price_data' => [
                            'currency' => 'eur', // Cambia la moneda según tus necesidades
                            'product_data' => [
                                'name' => $item['name'], // Nombre del producto
                            ],
                            'unit_amount' => $item['price'] * 100, // Precio en céntimos
                        ],
                        'quantity' => $item['quantity'],
                    ];
                }, $request->items), // Asegúrate de que el frontend envía un array 'items' con 'name', 'price', y 'quantity'
                'mode' => 'payment',
                'success_url' => route('success'), // URL a la que redirigir después del pago
                'cancel_url' => route('cancel'), // URL a la que redirigir si el usuario cancela
            ]);

            // Retorna la respuesta en JSON con el ID de la sesión
            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            // En caso de error, retorna una respuesta de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
