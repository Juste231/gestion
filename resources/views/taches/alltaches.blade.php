
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


                    <!-- Formulaire de recherche et de filtrage -->
                    <form method="GET" action="{{ route('taches.index') }}" class="mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- Champ de recherche -->
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Rechercher..." 
                                value="{{ request('search') }}" 
                                class="w-full px-4 py-2 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200"
                            >

                            <!-- Filtre par statut -->
                            <select 
                                name="statut" 
                                class="px-4 py-2 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                                <option value="">Tous les statuts</option>
                                <option value="non commencé" {{ request('statut') == 'non commencé' ? 'selected' : '' }}>Non commencé</option>
                                <option value="en cours" {{ request('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            </select>

                            <!-- Bouton de recherche -->
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                Rechercher
                            </button>
                        </div>
                    </form>


                    <!-- Tableau des tâches -->
                    @if($taches->count())
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">#</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Titre</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Description</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Projet</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Utilisateur Assigné</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Statut</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Priorité</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taches as $key => $tache)
                                        <tr class="border-t border-gray-300 dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ ++$key }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $tache->tache_titre }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ Str::limit($tache->description, 50) }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $tache->projet_titre }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                {{ $tache->user_name ?? 'Non assigné' }}
                                            </td>
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
                                                    @if($tache->statut === 'non commencé')
                                                        <!-- Icône d'entrée pour changer en "en cours" -->
                                                        <form action="{{ route('taches.updateStatut') }}" method="POST" class="inline-block" id="statut-form-{{ $tache->tache_id }}-en-cours">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="id" value="{{ $tache->tache_id }}">
                                                            <input type="hidden" name="status" value="en cours">
                                                            <button type="button" class="text-yellow-500 hover:text-yellow-700" onclick="confirmStatusChange('en cours', '{{ $tache->tache_titre}}', 'statut-form-{{ $tache->tache_id }}-en-cours')">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Modifier -->
                                                        <form action="{{ route('taches.edit') }}" method="GET" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="tache_id" value="{{ $tache->tache_id }}">
                                                            <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Supprimer -->
                                                        <form action="{{ route('taches.destroy') }}" method="POST" id="delete-form-{{ $tache->tache_id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="tache_id" value="{{ $tache->tache_id }}">
                                                            <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmDeletion({{ $tache->tache_id }}, '{{ $tache->tache_titre }}')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Assigner un utilisateur -->
                                                        <form action="{{ route('taches.editassign') }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <input type="hidden" name="tache_id" value="{{ $tache->tache_id }}">
                                                            <button type="submit" class="text-green-500 hover:text-green-700">
                                                                <i class="fas fa-user-plus"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($tache->statut === 'en cours')
                                                        <!-- Icône de check pour changer en "terminé" -->
                                                        <form action="{{ route('taches.updateStatut') }}" method="POST" class="inline-block" id="statut-form-{{ $tache->tache_id }}-termine">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="id" value="{{ $tache->tache_id }}">
                                                            <input type="hidden" name="status" value="terminé">
                                                            <button type="button" class="text-green-500 hover:text-green-700" onclick="confirmStatusChange('terminé', '{{ $tache->tache_titre }}', 'statut-form-{{ $tache->tache_id }}-termine')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Modifier -->
                                                        <form action="{{ route('taches.edit') }}" method="GET" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="tache_id" value="{{ $tache->tache_id }}">
                                                            <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Supprimer -->
                                                        <form action="{{ route('taches.destroy') }}" method="POST" id="delete-form-{{ $tache->tache_id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="tache_id" value="{{ $tache->tache_id }}">
                                                            <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmDeletion({{ $tache->tache_id }}, '{{ $tache->tache_titre }}')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($tache->statut === 'terminé')
                                                        <!-- Texte "Terminé" -->
                                                        <span class="text-green-500 font-bold">Terminé</span>
                                                    @endif
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

        function confirmStatusChange(newStatus, taskTitle, formId) {
            const confirmation = confirm(`Êtes-vous sûr de vouloir changer le statut de la tâche "${taskTitle}" en "${newStatus}" ?`);
            if (confirmation) {
                // Soumettre le formulaire en cas de confirmation
                document.getElementById(formId).submit();
            }
        }
    </script>
</x-app-layout>
