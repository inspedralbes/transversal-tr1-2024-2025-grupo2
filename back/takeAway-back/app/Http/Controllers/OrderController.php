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
    public function store(Request $request)
{
    // Validar los datos
    $request->validate([
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1'
    ]);

    // Crear la orden
    $order = Order::create([
        'totalproducts' => count($request->products), // Suponiendo que se cuentan los productos
        'finalprice' => array_reduce($request->products, function ($carry, $item) {
            // Calcular el precio total
            $product = Product::find($item['id']);
            return $carry + ($product->price * $item['quantity']);
        }, 0),
    ]);

    // Asociar productos a la orden
    foreach ($request->products as $product) {
        $order->products()->attach($product['id'], [
            'quantity' => $product['quantity'],
            'price' => Product::find($product['id'])->price // Obtener el precio del producto directamente
        ]);
    }

    return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
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
        // Validar les dades
        $request->validate([
            'totalproducts' => 'required|integer|min:1',
            'finalprice' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'totalproducts' => $request->totalproducts,
            'finalprice' => $request->finalprice,
        ]);

        // Actualizar los productos asociados
        $order->products()->detach(); // Desvincular productos antiguos
        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity'], 'price' => $product['price']]);
        }

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
