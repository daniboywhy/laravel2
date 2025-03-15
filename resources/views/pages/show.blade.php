<x-app-layout>
    <x-slot name="header">
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
            {{ $page->title }}
        </h1>
        
    </x-slot>

    <div class="container mt-4 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <p class="text-lg text-gray-700 dark:text-gray-300">{{ $page->content }}</p>
        </div>
        <div class="gap-8">
             <!-- Infobox -->
             @if ($page->infobox)
                <aside style="float: right"class="bg-blue-100 dark:bg-blue-900 rounded-lg shadow p-4">
                <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
            <!-- Título da Infobox -->
            <tr>
                <th colspan="2" class="text-white bg-gray-200 dark:bg-gray-700 text-center text-lg font-bold p-2">
                    {{ $page->title }}
                </th>
            </tr>

            <!-- Exibir Imagem -->
            @if ($page->infobox->image_path)
                <tr>
                    <td colspan="2" class="text-center p-2">
                        <img src="{{ asset('storage/' . $page->infobox->image_path) }}" 
                             alt="Imagem" 
                             class="w-48 mx-auto rounded-lg shadow">
                    </td>
                </tr>
            @endif

            <!-- Exibir Campos da Infobox -->
            @php
                $fields = json_decode($page->infobox->fields, true);
            @endphp

            @if (!empty($fields) && is_array($fields))
                <tr>
                    <th colspan="2" class="text-white bg-gray-200 dark:bg-gray-700 text-center text-sm font-bold p-2">
                        Informações
                    </th>
                </tr>

                @foreach ($fields as $item)
                    @if(is_array($item) && isset($item['key']) && isset($item['value']))
                        <tr class="text-white border-t border-gray-300 dark:border-gray-700">
                            <td class="font-semibold p-2 w-1/3 text-left">{{ ucfirst($item['key']) }}</td>
                            <td class="p-2 w-2/3 text-left">
                                @if(is_array($item['value']))
                                    @foreach($item['value'] as $val)
                                        {{ $val }} <br>
                                    @endforeach
                                @else
                                    {{ $item['value'] }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </table>

                 </aside>
            @endif
            <!-- Conteúdo Principal -->
            <div>
                @foreach ($page->sections as $section)
                    <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 inline-block border-b-2 border-gray-300 dark:border-gray-700 pb-2 mb-2">
                        {{ $section->title }}
                    </h2>

                        <div class="prose text-white dark:prose-invert max-w-none">
                            {!! $section->content !!}
                        </div>
                    </div>
                @endforeach
            </div>
            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->id() === $page->author_id))
                <a href="{{ route('pages.edit', $page->slug) }}" 
                    class="bg-gray-800 text-white px-4 py-2">
                    Editar Página
                </a>
            @endif

           
        </div>
    </div>
</x-app-layout>