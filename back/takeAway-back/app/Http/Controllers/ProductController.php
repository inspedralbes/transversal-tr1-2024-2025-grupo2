<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
