<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSection;
use App\Models\Category;
use App\Models\Infobox;
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

    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // Restringir edição apenas para Admins ou para o Autor da Página
        if (!auth()->user()->hasRole('admin') && auth()->id() !== $page->author_id) {
            abort(403, 'Você não tem permissão para editar esta página.');
        }

        $categories = Category::all();
        
        return view('pages.edit', compact('page', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if (!auth()->user()->hasRole('admin') && auth()->id() !== $page->author_id) {
            abort(403, 'Você não tem permissão para editar esta página.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.content' => 'required|string',
            'infobox_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'infobox' => 'nullable|array',
            'infobox.*.key' => 'required|string',
            'infobox.*.value' => 'required|array|min:1',
        ]);

        // Atualiza a página
        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
        ]);

        // Atualiza as seções (exclui antigas e adiciona novas)
        $page->sections()->delete();
        foreach ($validated['sections'] as $section) {
            $page->sections()->create([
                'title' => $section['title'],
                'content' => $section['content'],
            ]);
        }

        // Atualiza a infobox
        if ($request->hasFile('infobox_image')) {
            $imagePath = $request->file('infobox_image')->store('infoboxes', 'public');
            $page->infobox()->updateOrCreate([], ['image_path' => $imagePath]);
        }

        if (isset($validated['infobox'])) {
            $page->infobox()->updateOrCreate([], [
                'fields' => json_encode($validated['infobox'])
            ]);
        }

        return redirect()->route('pages.show', $page->slug)->with('success', 'Página atualizada com sucesso!');
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
            'infobox' => 'nullable|array',
            'infobox.*.key' => 'required_with:infobox.*.value|string|max:255',
            'infobox.*.value' => 'required|array|min:1', // Aceita múltiplos valores
            'infobox.*.value.*' => 'required|string|max:500', // Cada valor dentro do array deve ser string
            'infobox_image' => 'nullable|file|mimes:jpeg,png|max:2048',
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

        // Criar a Infobox (se houver dados)
        if ($request->hasFile('infobox_image') || !empty($validated['infobox'])) {
            $imagePath = $page->infobox->image_path ?? null; 
        
            if ($request->hasFile('infobox_image')) {
                $imagePath = $request->file('infobox_image')->store('infoboxes', 'public');
            }
        
            $page->infobox()->updateOrCreate(
                ['page_id' => $page->id], 
                [
                    'image_path' => $imagePath,
                    'fields' => json_encode($validated['infobox'])
                ]
            );
        }

        return redirect()->route('pages.show', $page->slug)->with('success', 'Página criada com sucesso!');
    }
}

