<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    // Mostrar llista dels comandes
    public function index()
    {
        $orders = Order::with('products')->get(); // Carga los pedidos con los productos relacionados
        return view('orders.index', compact('orders'));
    }

    // Mostrar el formulari per crear un nou comanda
    public function create()
    {
        $products = Product::all(); // Obtener todos los productos para seleccionar
        return view('orders.create', compact('products'));
    }

    // Guardar un nou comanda
    // Supongamos que tienes un Request con productos a agregar al pedido
    public function store(Request $request)
    {
        // Validar los productos
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Crear el pedido
        $order = Order::create([
            // Aquí puedes agregar otros campos como el total, etc.
        ]);

        $totalPrice = 0; // Inicializa el precio total

        // Adjuntar productos al pedido
        foreach ($request->products as $product) {
            // Obtén el producto de la base de datos
            $dbProduct = Product::findOrFail($product['id']);

            // Usa el precio de la base de datos
            $price = $dbProduct->price;

            // Calcula el precio total
            $totalPrice += $price * $product['quantity'];

            // Adjunta el producto al pedido
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $price,
            ]);
        }

        // Actualiza el pedido con el precio total
        $order->finalprice = $totalPrice; // Asegúrate de que tienes un campo total en la tabla de pedidos
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Pedido creado exitosamente.');
    }




    // Mostrar un comanda específic
    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // Mostrar el formulari per editar un comanda
    public function edit($id)
    {
        $order = Order::with('products')->findOrFail($id);
        $products = Product::all(); // Obtener todos los productos
        return view('orders.edit', compact('order', 'products'));
    }

    // Actualizar un comanda específic
    public function update(Request $request, $id)
{
    // Validar las demás entradas
    $request->validate([
        'products' => 'required|array',
        'products.*.id' => 'exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ]);

    $order = Order::findOrFail($id);

    // Actualizar los productos asociados
    $totalPrice = 0; // Inicializa el precio total
    $order->products()->detach(); // Desvincular productos antiguos

    foreach ($request->products as $product) {
        // Obtén el producto de la base de datos
        $dbProduct = Product::findOrFail($product['id']);

        // Usa el precio de la base de datos
        $price = $dbProduct->price;

        // Calcula el precio total
        $totalPrice += $price * $product['quantity'];

        // Adjunta el producto al pedido
        $order->products()->attach($product['id'], [
            'quantity' => $product['quantity'],
            'price' => $price,
        ]);
    }

    // Actualiza el pedido con el precio total
    $order->finalprice = $totalPrice; // Asegúrate de que tienes un campo total en la tabla de pedidos
    $order->save();

    return redirect()->route('orders.index')->with('success', 'Pedido actualizado exitosamente.');
}


    // Eliminar un comanda
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete(); // Eliminar el pedido

        return redirect()->route('orders.index')->with('success', 'Pedido eliminado exitosamente.');
    }
}
