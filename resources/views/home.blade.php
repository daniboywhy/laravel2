<x-app-layout>
    <!-- Header Slot -->
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
            Bem-vindo à Wiki
        </h1>
    </x-slot>

    <!-- Content Slot -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Categorias -->
        <div style="margin-bottom: 12px">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Categorias</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach($categories as $category)
                <li class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                    <a href="{{ route('categories.show', $category->slug) }}" class="text-lg font-bold text-blue-500 dark:text-blue-400">
                        {{ $category->name }}
                    </a>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $category->description }}</p>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Páginas Recentes -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Páginas Recentes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach($recentPages as $page)
                <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        <a href="{{ route('pages.show', $page->slug) }}">
                            {{ $page->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ Str::limit($page->content, 100) }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
