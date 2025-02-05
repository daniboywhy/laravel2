<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
            {{ $page->title }}
        </h1>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <p class="text-lg text-gray-700 dark:text-gray-300">{{ $page->content }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Conteúdo Principal -->
            <div class="md:col-span-2">
                @foreach ($page->sections as $section)
                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 ">
                            {{ $section->title }}
                        </h2>
                        <div class="prose text-white dark:prose-invert max-w-none">
                            {!! $section->content !!}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Infobox -->
            @if ($page->infobox)
                <aside class="bg-blue-100 dark:bg-blue-900 rounded-lg shadow p-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                        Informações
                    </h2>

                    <!-- Exibir Foto -->
                    @if ($page->infobox->image_path)
                        <div class="flex justify-center mb-4">
                            <img src="{{ asset($page->infobox->image_path) }}" alt="Foto" class="text-white rounded-lg w-48">
                        </div>
                    @endif

                    <!-- Exibir Campos Dinâmicos -->
                    <div class="flex flex-col space-y-2">
                        @foreach ($page->infobox->fields as $field => $value)
                            <div class="text-white">
                                <strong>{{ $field }}:</strong> {{ $value }}
                            </div>
                        @endforeach
                    </div>
                </aside>
            @endif
        </div>
    </div>
</x-app-layout>
