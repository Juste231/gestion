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

                    <!-- Formulaire de recherche et filtrage -->
                    <form method="GET" action="{{ route('projets.index') }}" class="mb-4 flex space-x-2">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher (titre, description, propriétaire)" 
                            value="{{ request('search') }}" 
                            class="flex-grow px-3 py-2 border dark:bg-gray-700 dark:border-gray-600 rounded-md">

                        <select name="statut" class="px-3 py-2 border dark:bg-gray-700 dark:border-gray-600 rounded-md">
                            <option value="">Tous les statuts</option>
                            <option value="en cours" {{ request('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Filtrer
                        </button>
                    </form>

                    <!-- Tableau des projets -->
                    @if($projets->count())
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">#</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Titre</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Description</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Date Limite</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Créateur</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Statut</th>
                                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projets as $key => $projet)
                                        <tr class="border-t border-gray-300 dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $projet->titre }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ Str::limit($projet->description, 50) }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ \Carbon\Carbon::parse($projet->date_limite)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $projet->proprietaire }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                                <span class="px-2 py-1 rounded-md
                                                    {{ $projet->statut == 'en cours' ? 'bg-blue-500 text-white' : '' }}
                                                    {{ $projet->statut == 'terminé' ? 'bg-green-500 text-white' : '' }}">
                                                    {{ ucfirst($projet->statut) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200 flex space-x-2">
                                                @if($projet->statut === 'terminé')
                                                    <!-- Affichage du texte "Terminé" lorsque le projet est terminé -->
                                                    <span class="text-green-500 font-bold">Terminé</span>
                                                @else
                                                    <!-- Bouton Éditer -->
                                                    <form action="{{ route('projets.edit') }}" method="GET">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $projet->id }}">
                                                        <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </form>
                                            
                                                    <!-- Formulaire pour changer le statut -->
                                                    <form action="{{ route('projets.updateStatus') }}" method="POST" onsubmit="return confirmStatusChange('{{ $projet->titre }}', '{{ $projet->statut }}');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="id" value="{{ $projet->id }}">
                                                        <input type="hidden" name="status" value="{{ $projet->statut == 'en cours' ? 'terminé' : 'en cours' }}">
                                                        <button type="submit" class="text-green-500 hover:text-green-700">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                            
                                                    <!-- Formulaire pour supprimer -->
                                                    <form action="{{ route('projets.destroy') }}" method="POST" onsubmit="return confirmDelete('{{ $projet->titre }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $projet->id }}">
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
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
                        {{ $projets->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

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

