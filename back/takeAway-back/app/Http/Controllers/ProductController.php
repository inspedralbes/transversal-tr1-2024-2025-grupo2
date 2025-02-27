<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    //funció per buscar productes
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('title', 'LIKE', '%' . $query . '%')->get();
    
        return response()->json($products);
    }
    


    // Mostra el formulari para crear un nou producte
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();

        return view('products.create', compact('categories', 'sizes'));
    }


    // Guardar un nou producte
    public function store(Request $request)
    {
        // Validar les dades
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'required|exists:sizes,id',
        ]);

        // Crear el producte
        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }


    // Mostrar un producto específic
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', ['product' => $product]); // Vista per mostrar el producte
    }


    // Mostrar el formulari per editar un producte
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();

        return view('products.edit', compact('product', 'categories', 'sizes'));
    }


    // Actualizar un producte específic
    public function update(Request $request, $id)
    {
        // Validar les dades
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'required|exists:sizes,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all()); // Actualiza el producte

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }


    // Eliminar un producte
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function getProducts() // funcion que devuelve los productos
    {
        $response = Product::with('size', 'category')->get();
        return response()->json($response);
    }
};
