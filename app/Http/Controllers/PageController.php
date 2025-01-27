<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        // Busca a página pelo slug
        $page = Page::with(['sections', 'infobox'])->where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }
}
