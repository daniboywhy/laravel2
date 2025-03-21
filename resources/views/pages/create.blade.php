<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Criar Nova Página</h1>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Título -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Título:</label>
                <input type="text" name="title" class="w-full px-4 py-2 border rounded" value="{{ old('title') }}" required>
            </div>

            <!-- Introdução -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Introdução:</label>
                <textarea name="content" class="w-full px-4 py-2 border rounded" placeholder="Escreva uma breve introdução..." required>{{ old('content') }}</textarea>
            </div>

            <!-- Categoria -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Categoria:</label>
                <select name="category_id" id="categorySelect" class="w-full px-4 py-2 border rounded">
                    <option value="">Escolha uma categoria existente...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                    <option value="new">Criar nova categoria...</option>
                </select>
            </div>

            <!-- Campo para Criar Nova Categoria -->
            <div class="mb-4 hidden" id="newCategoryField">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nova Categoria:</label>
                <input type="text" name="new_category" id="newCategoryInput" class="w-full px-4 py-2 border rounded" placeholder="Digite o nome da nova categoria">
            </div>

            <!-- Seções Dinâmicas -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Seções:</label>
                <div id="sections">
                    @if(old('sections'))
                        @foreach(old('sections') as $index => $section)
                            <div class="section-item mb-2">
                                <input type="text" name="sections[{{ $index }}][title]" class="w-full px-4 py-2 border rounded"
                                       placeholder="Título da seção" value="{{ $section['title'] }}" required>
                                <textarea name="sections[{{ $index }}][content]" class="w-full px-4 py-2 border rounded mt-1"
                                          placeholder="Conteúdo da seção" required>{{ $section['content'] }}</textarea>
                            </div>
                        @endforeach
                    @else
                        <div class="section-item mb-2">
                            <input type="text" name="sections[0][title]" class="w-full px-4 py-2 border rounded"
                                   placeholder="Título da seção" required>
                            <textarea name="sections[0][content]" class="w-full px-4 py-2 border rounded mt-1"
                                      placeholder="Conteúdo da seção" required></textarea>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addSection()" class="bg-gray-800 text-white px-4 py-2 rounded mt-2">
                    Adicionar Seção
                </button>
            </div>

            <!-- Infobox -->
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">Infobox</h2>

                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imagem:</label>
                <input type="file" name="infobox_image" class="w-full text-white px-4 py-2 border rounded">

                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 mt-4">Campos da Infobox:</label>
                <div id="infobox-fields">
                    @if(old('infobox'))
                        @foreach(old('infobox') as $key => $field)
                            <div class="infobox-item mb-2">
                                <div class="flex space-x-2 mb-1">
                                    <input type="text" name="infobox[{{ $key }}][key]" class="w-1/3 px-4 py-2 border rounded" placeholder="Campo" value="{{ $field['key'] }}">
                                    <button type="button" class="px-2 py-1 bg-gray-800 text-white rounded add-value" onclick="addValueField(this)">+</button>
                                </div>
                                <div class="values-container">
                                    @foreach($field['value'] as $index => $value)
                                        <input type="text" name="infobox[{{ $key }}][value][]" class="w-2/3 px-4 py-2 border rounded" placeholder="Valor {{ $index + 1 }}" value="{{ $value }}">
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addInfoboxField()" class="bg-gray-800 text-white px-4 py-2 rounded mt-2">
                    Adicionar Campo
                </button>
            </div>

            <!-- Botão de Salvar -->
            <div>
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">
                    Criar Página
                </button>
            </div>
        </form>
    </div>

    <script>
        function addSection() {
            let sectionsDiv = document.getElementById('sections');
            let index = sectionsDiv.children.length;
            let sectionHTML = `
                <div class="section-item mb-2">
                    <input type="text" name="sections[${index}][title]" class="w-full px-4 py-2 border rounded" placeholder="Título da seção" required>
                    <textarea name="sections[${index}][content]" class="w-full px-4 py-2 border rounded mt-1" placeholder="Conteúdo da seção" required></textarea>
                </div>
            `;
            sectionsDiv.insertAdjacentHTML('beforeend', sectionHTML);
        }

        function addInfoboxField() {
            let fieldsDiv = document.getElementById('infobox-fields');
            let index = fieldsDiv.children.length;
            let fieldHTML = `
                <div class="infobox-item mb-2">
                    <div class="flex space-x-2 mb-1">
                        <input type="text" name="infobox[${index}][key]" class="w-1/3 px-4 py-2 border rounded" placeholder="Campo">
                        <button type="button" class="px-2 py-1 bg-green-500 text-white rounded add-value" onclick="addValueField(this)">+</button>
                    </div>
                    <div class="values-container">
                        <input type="text" name="infobox[${index}][value][]" class="w-2/3 px-4 py-2 border rounded" placeholder="Valor">
                    </div>
                </div>
            `;
            fieldsDiv.insertAdjacentHTML('beforeend', fieldHTML);
        }

        function addValueField(button) {
            let parentDiv = button.closest('.infobox-item').querySelector('.values-container');
            let inputField = document.createElement('input');
            inputField.type = "text";
            inputField.name = parentDiv.parentNode.querySelector('input[name^="infobox"]').name.replace('[key]', '[value][]');
            inputField.classList.add('w-2/3', 'px-4', 'py-2', 'border', 'rounded', 'mt-1');
            inputField.placeholder = "Novo Valor";

            parentDiv.appendChild(inputField);
        }

        // Exibir campo de nova categoria se "Criar nova categoria" for selecionado
        document.getElementById('categorySelect').addEventListener('change', function() {
            let newCategoryField = document.getElementById('newCategoryField');
            let newCategoryInput = document.getElementById('newCategoryInput');

            if (this.value === "new") {
                newCategoryField.classList.remove('hidden');
                newCategoryInput.setAttribute('required', 'required');
            } else {
                newCategoryField.classList.add('hidden');
                newCategoryInput.value = '';
                newCategoryInput.removeAttribute('required');
            }
        });
    </script>
</x-app-layout>
