<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des Tâches') }}
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
                    <form method="GET" action="{{ route('taches.show') }}" class="flex items-center justify-between mb-4">
                        <div class="flex space-x-4">
                            <!-- Recherche -->
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="search"
                                    value="{{ request('search') }}" 
                                    placeholder="Rechercher une tâche"
                                    class="w-full p-3 pl-9 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                >
                            </div>

                            <!-- Filtrage par statut -->
                            <select 
                                name="statut" 
                                class="p-3 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="" {{ request('statut') == '' ? 'selected' : '' }}>Tous les statuts</option>
                                <option value="non commencé" {{ request('statut') == 'non commencé' ? 'selected' : '' }}>Non commencé</option>
                                <option value="en cours" {{ request('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            </select>

                            <!-- Filtrage par priorité -->
                            <select 
                                name="priorite" 
                                class="p-3 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="" {{ request('priorite') == '' ? 'selected' : '' }}>Toutes les priorités</option>
                                <option value="faible" {{ request('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                                <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="élevée" {{ request('priorite') == 'élevée' ? 'selected' : '' }}>Élevée</option>
                            </select>
                        </div>

                        <div class="flex space-x-4">
                            <!-- Bouton de soumission -->
                            <button 
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                                Filtrer
                            </button>

                            <!-- Bouton Créer -->
                            <a href="{{ route('taches.create') }}" 
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                                Créer une tâche
                            </a>
                        </div>
                    </form>

                    <!-- Tableau des tâches -->
                    @if($taches->count())
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">ID</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Titre</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Description</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Projet</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Statut</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Priorité</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taches as $key =>$tache)
                                        <tr class="border-t border-gray-300 dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ ++$key }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $tache->titre }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ Str::limit($tache->description, 50) }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $tache->projet_titre }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <span class="px-2 py-1 rounded-md 
                                                    {{ $tache->statut == 'non commencé' ? 'bg-gray-300 text-gray-800' : '' }}
                                                    {{ $tache->statut == 'en cours' ? 'bg-blue-500 text-white' : '' }}
                                                    {{ $tache->statut == 'terminé' ? 'bg-green-500 text-white' : '' }}">
                                                    {{ ucfirst($tache->statut) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <span class="px-2 py-1 rounded-md 
                                                    {{ $tache->priorite == 'faible' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                                    {{ $tache->priorite == 'moyenne' ? 'bg-orange-200 text-orange-800' : '' }}
                                                    {{ $tache->priorite == 'élevée' ? 'bg-red-500 text-white' : '' }}">
                                                    {{ ucfirst($tache->priorite) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <div class="flex space-x-2">
                                                    <!-- Modifier -->
                                                    <form action="{{ route('taches.edit') }}" method="GET" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="tache_id" value="{{ $tache->id }}">
                                                        <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Supprimer -->
                                                    <form action="{{ route('taches.destroy') }}" method="POST" id="delete-form-{{ $tache->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="tache_id" value="{{ $tache->id }}">
                                                        <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmDeletion({{ $tache->id }}, '{{ $tache->titre }}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Assigner -->
                                                    <a href="" 
                                                       class="text-green-500 hover:text-green-700">
                                                        <i class="fas fa-user-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-600 dark:text-gray-400 py-4">Aucune tâche trouvée.</p>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $taches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDeletion(tacheId, tacheTitre) {
            const confirmation = confirm('Êtes-vous sûr de vouloir supprimer la tâche : ' + tacheTitre + ' ?');
            
            if (confirmation) {
                // Soumettre le formulaire en cas de confirmation
                document.getElementById('delete-form-' + tacheId).submit();
            }
        }
    </script>

</x-app-layout>
