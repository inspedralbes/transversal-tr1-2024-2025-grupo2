<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories() // funcion que devuelve los productos
    {
        $response = Category::with('size','category')->get();
        return response()->json($response);
    }

    
}
