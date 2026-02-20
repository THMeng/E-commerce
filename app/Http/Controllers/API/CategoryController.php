<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listCategory(){
        $category = Categories::all();
        return response()->json([
            'category'  => $category
        ]);
    }
}
