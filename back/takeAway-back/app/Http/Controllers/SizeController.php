<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function getSizes(){
        $response = Size::with('size')->get();
        return response()->json($response);
    }
}
