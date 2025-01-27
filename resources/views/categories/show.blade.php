<x-app-layout>
    <!-- Slot do Header -->
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
            {{ $category->name }}
        </h1>
    </x-slot>

    <!-- Conteúdo Principal -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Descrição da Categoria -->
        <div class="mb-6">
            <p class="text-lg text-gray-700 dark:text-gray-300">
                {{ $category->description }}
            </p>
        </div>

        <!-- Páginas Relacionadas -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Páginas</h2>
            <ul class="list-disc pl-5 space-y-2">
                @foreach($category->pages as $page)
                    <li>
                        <a href="{{ route('pages.show', $page->slug) }}" class="text-blue-500 dark:text-blue-400 hover:underline">
                            {{ $page->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
