<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('query');

    // Busque categorias
    $categories = Category::where('name', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->get()
        ->map(function ($category) {
            return [
                'type' => 'category',
                'name' => $category->name,
                'description' => $category->description,
                'url' => route('categories.show', $category->slug),
            ];
        });

    // Busque páginas
    $pages = Page::where('title', 'like', "%$query%")
        ->orWhere('content', 'like', "%$query%")
        ->get()
        ->map(function ($page) {
            return [
                'type' => 'page',
                'title' => $page->title,
                'content' => Str::limit($page->content, 100),
                'url' => route('pages.show', $page->slug),
            ];
        });

    // Combine as categorias e páginas em uma única coleção
    $results = $categories->concat($pages);

    // Adicione paginação à coleção combinada
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10;
    $paginatedResults = new LengthAwarePaginator(
        $results->forPage($currentPage, $perPage),
        $results->count(),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
    );

    $paginatedResults->appends(['query' => $query]);

    return view('search.index', [
        'results' => $paginatedResults,
        'query' => $query,
    ]);
}
}
