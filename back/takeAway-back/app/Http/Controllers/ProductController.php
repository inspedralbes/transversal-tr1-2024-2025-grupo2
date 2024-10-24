<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;

class ProductController extends Controller
{
    /* Mostrar llista dels productes 
    public function index()
    {
        $json = file_get_contents(public_path('data.json'));
        $productsArray = json_decode($json, true);

        if (isset($productsArray['products'])) {
            return view('getImage', ['products' => $productsArray['products']]);
        }

        return view('getImage', ['products' => []]);
    }
    */

    public function index()
    {
        $products = Product::all(); // Asegúrate de importar el modelo
        return view('products.index', compact('products'));
    }


    // Mostra el formulari para crear un nou producte
    public function create()
    {
        $categories = Category::all(); // Asegúrate de importar el modelo
        $sizes = Size::all(); // Asegúrate de importar el modelo

        return view('products.create', compact('categories', 'sizes'));
    }


    // Guardar un nuevo producto
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string|max:255', // O usa una regla para subir archivos
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'required|exists:sizes,id',
        ]);

        // Crear el producto
        Product::create($request->all()); // Asegúrate de que 'fillable' esté configurado en el modelo

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }


    // Mostrar un producto específico
    public function show($id)
    {
        $product = Product::findOrFail($id); // Encuentra el producto o devuelve 404
        return view('products.show', ['product' => $product]); // Vista para mostrar el producto
    }


    // Mostrar el formulario para editar un producto
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Asegúrate de importar el modelo
        $categories = Category::all();
        $sizes = Size::all();

        return view('products.edit', compact('product', 'categories', 'sizes'));
    }


    // Actualizar un producto específico
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'required|exists:sizes,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all()); // Actualiza el producto

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }


    // Eliminar un producto
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Elimina el producto

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }

}
