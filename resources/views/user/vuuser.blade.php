<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des Utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Message de succès -->
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Message d'erreur -->
                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Formulaire de recherche et de filtrage -->
                    <form method="GET" action="{{ route('users.index') }}" class="flex items-center justify-between mb-4">
                        <div class="flex space-x-4">
                            <!-- Recherche -->
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ old('search', $search) }}" 
                                    placeholder="Rechercher par nom ou email"
                                    class="w-full p-3 pl-9 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                >
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <!-- Bouton de soumission -->
                            <button 
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                                Filtrer
                            </button>

                            <!-- Bouton Créer -->
                            <a href="{{ route('users.create') }}" 
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                                Créer un utilisateur
                            </a>
                        </div>
                    </form>

                    <!-- Tableau des utilisateurs -->
                    @if($users->count())
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">ID</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Nom</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Email</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Rôle</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr class="border-t border-gray-300 dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ ++$key }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <span class="px-2 py-1 rounded-md 
                                                    {{ $user->role == 'admin' ? 'bg-blue-500 text-white' : '' }}
                                                    {{ $user->role == 'utilisateur' ? 'bg-gray-500 text-white' : '' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <div class="flex space-x-2">
                                                    <!-- Modifier -->
                                                    <form action="{{ route('users.updateRole') }}" method="POST" class="inline" onsubmit="return confirmUpdateRole('{{ $user->name }}', '{{ $user->role }}')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                                        <input type="hidden" name="current_role" value="{{ $user->role }}"> <!-- Rôle actuel de l'utilisateur -->
                                                    
                                                        <button type="submit" class="text-blue-500 hover:text-blue-700 ml-2">
                                                            <i class="fas fa-edit"></i> Modifier le rôle
                                                        </button>
                                                    </form>
                                                    
                                                    

                                                    <!-- Supprimer -->
                                                    <form action="{{ route('users.destroy') }}" method="POST" id="delete-form-{{ $user->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                                        <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmDeletion({{ $user->id }}, '{{ $user->name }}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-600 dark:text-gray-400 py-4">Aucun utilisateur trouvé.</p>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction de confirmation avant suppression
        function confirmDeletion(id, name) {
            if (confirm('Êtes-vous sûr de vouloir supprimer l\'utilisateur "' + name + '" ?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
                                                            

    function confirmUpdateRole(userName, currentRole) {
        const targetRole = currentRole === 'admin' ? 'user' : 'admin'; // Déterminer le rôle cible
        return confirm(`Êtes-vous sûr de vouloir changer le rôle de ${userName} de ${currentRole} à ${targetRole} ?`);
    }

    </script>

</x-app-layout>
