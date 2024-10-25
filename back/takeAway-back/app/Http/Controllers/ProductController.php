<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {

        $json = file_get_contents(public_path('data.json'));
        $productsArray = json_decode($json, true);

        if (isset($productsArray['products'])) {
            return view('getImage', ['products' => $productsArray['products']]);
        }

        return view('getImage', ['products' => []]);
    }

    public function getProducts() // funcion que devuelve los productos
    {
        $response = Product::with('size','category')->get();
        return response()->json($response);
    }
}
