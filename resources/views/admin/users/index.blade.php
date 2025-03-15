<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
            Gerenciamento de Usuários
        </h1>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white text-white dark:bg-gray-800 rounded-lg shadow p-6">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-900">
                        <th class="border border-gray-300 dark:border-gray-700 p-2 text-left">Nome</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-2 text-left">Email</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-2 text-center">Role</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border border-gray-300 dark:border-gray-700 p-2">{{ $user->name }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 p-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 text-center p-2">
                                {{ $user->getRoleNames()->join(', ') ?: 'Sem Role' }}
                            </td>
                            <td class="border border-gray-300 text-center dark:border-gray-700 p-2">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                                    @csrf
                                    <select style="width: 85px" name="role" class="border rounded p-2 text-black">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-white text-black px-4 py-2 rounded">Salvar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
