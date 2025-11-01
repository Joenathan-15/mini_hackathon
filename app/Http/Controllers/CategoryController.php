<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');
        if ($query) {
            $categories = Category::where('name', 'like', '%' . $query . '%')->get();
            return response()->json([$categories]);
        }
        return response()->json([Category::all()]);
    }
}
