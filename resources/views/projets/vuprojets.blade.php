<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des Projets') }}
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
                    <form method="GET" action="{{ route('projets.show') }}" class="flex items-center justify-between mb-4">
                        <div class="flex space-x-4">
                            <!-- Recherche -->
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="search"
                                    value="{{ request('search') }}" 
                                    placeholder="Rechercher un projet"
                                    class="w-full p-3 pl-9 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                >
                            </div>

                            <!-- Filtrage par statut -->
                            <select 
                                name="statut" 
                                class="p-3 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="" {{ request('statut') == '' ? 'selected' : '' }}>Tous les statuts</option>
                                <option value="en cours" {{ request('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>

                        <!-- Boutons de soumission et création -->
                        <div class="flex items-center  space-x-2">
                            <!-- Bouton Rechercher -->
                            <button 
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white  px-4 py-2 rounded-md">
                                Rechercher
                            </button>

                            <!-- Bouton Créer -->
                            <a href="{{ route('projets.create') }}"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                               Créer
                            </a>
                        </div>
                    </form>

                    <!-- Tableau des projets -->
                    @if($projets->count())
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">ID</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Titre</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Description</th> <!-- Description ajoutée -->
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Date Limite</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Statut</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projets as $key => $projet)
                                        <tr class="border-t border-gray-300 dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ ++$key }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $projet->titre }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ Str::limit($projet->description, 50) }}</td> <!-- Limite de la description -->
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $projet->date_limite }}</td>

                                            <!-- Formulaire pour changer le statut -->
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <form action="{{ route('projets.updateStatus') }}" method="POST" onsubmit="return confirmStatusChange('{{ $projet->titre }}', '{{ $projet->statut }}');">
                                                    @csrf
                                                    @method('PATCH')
                                                    
                                                    <input type="hidden" name="id" value="{{ $projet->id }}">
                                                    <input type="hidden" name="status" value="{{ $projet->statut == 'en cours' ? 'terminé' : 'en cours' }}">
                                                    
                                                    <button type="submit" class="p-2 rounded-full 
                                                        @if($projet->statut == 'en cours') bg-yellow-500 @elseif($projet->statut == 'terminé') bg-green-500 @else bg-gray-500 @endif text-white">
                                                        {{ ucfirst($projet->statut) }}
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200 flex space-x-2">
                                                @if($projet->statut !== 'terminé')
                                                <form action="{{ route('projets.edit') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $projet->id }}">
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md">
                                                        Modifier
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <form action="{{ route('projets.destroy') }}" method="POST" onsubmit="return confirmDelete('{{ $projet->titre }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $projet->id }}">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-600 dark:text-gray-400 py-4">Aucun projet trouvé.</p>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $projets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour confirmation -->
    <script>
        function confirmDelete(projetName) {
            return confirm('Êtes-vous sûr de vouloir supprimer le projet "' + projetName + '" ?');
        }

        function confirmStatusChange(projetName, currentStatus) {
            const newStatus = currentStatus === 'en cours' ? 'terminé' : 'en cours';
            const confirmation = confirm(`Voulez-vous vraiment modifier le statut du projet "${projetName}" à "${newStatus}" ?`);
            return confirmation;
        }
    </script>

</x-app-layout>
