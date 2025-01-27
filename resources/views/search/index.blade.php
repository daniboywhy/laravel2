<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
            Resultados para: "{{ $query }}"
        </h1>
    </x-slot>

    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <!-- Resultados -->
        <div class="mb-8">
            @forelse($results as $result)
                <div class="mb-4 p-4 bg-white dark:bg-gray-800 rounded shadow">
                    @if($result['type'] === 'category')
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            <a href="{{ $result['url'] }}" class="text-blue-500 dark:text-blue-400 hover:underline">
                                {{ $result['name'] }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result['description'] }}</p>
                    @elseif($result['type'] === 'page')
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            <a href="{{ $result['url'] }}" class="text-blue-500 dark:text-blue-400 hover:underline">
                                {{ $result['title'] }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result['content'] }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">Nenhum resultado encontrado.</p>
            @endforelse
        </div>

        <!-- Links de Paginação -->
        <div class="mt-4">
            {{ $results->links() }}
        </div>
    </div>
</x-app-layout>
