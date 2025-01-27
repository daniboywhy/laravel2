<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // Busca a categoria pelo slug e carrega as páginas relacionadas
        $category = Category::where('slug', $slug)->with('pages')->firstOrFail();

        return view('categories.show', compact('category'));
    }
}
