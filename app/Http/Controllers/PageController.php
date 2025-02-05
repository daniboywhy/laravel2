<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSection;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function show($slug)
    {
        // Busca a página pelo slug
        $page = Page::with(['sections', 'infobox'])->where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->category_id === "new") {
            $request->merge(['category_id' => null]);
        }

        if ($request->filled('new_category') === false) {
            $request->merge(['new_category' => null]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.content' => 'required|string',
        ]);

        if (!empty($validated['new_category'])) {
            $existingCategory = Category::where('name', $validated['new_category'])->first();

            if ($existingCategory) {
                return back()->withErrors(['new_category' => 'Esta categoria já existe. Escolha uma existente ou digite um nome diferente.'])->withInput();
            }
            $category = Category::create([
                'name' => $validated['new_category'],
                'slug' => Str::slug($validated['new_category']),
            ]);
            $validated['category_id'] = $category->id;
        }

        // Se ainda não tivermos uma categoria válida, retorna erro
        if (empty($validated['category_id'])) {
            return back()->withErrors(['category_id' => 'Por favor, selecione ou crie uma categoria.'])->withInput();
        }

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'author_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        foreach ($validated['sections'] as $section) {
            PageSection::create([
                'page_id' => $page->id,
                'title' => $section['title'],
                'content' => $section['content'],
            ]);
        }

        return redirect()->route('pages.show', $page->slug)->with('success', 'Página criada com sucesso!');
    }
}

