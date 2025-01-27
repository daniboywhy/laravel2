<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('pages')->get();
        $recentPages = Page::where('status', 'published')
                           ->orderBy('created_at', 'desc')
                           ->limit(6)
                           ->get();

        return view('home', compact('categories', 'recentPages'));
    }
}
