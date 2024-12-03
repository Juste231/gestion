<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier la tâche :') }} {{ $tache->titre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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

                    <!-- Formulaire d'édition -->
                    <form method="POST" action="{{ route('taches.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Champ caché pour l'ID -->
                        <input type="hidden" name="id" value="{{ $tache->id }}">

                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 dark:text-gray-200">Titre</label>
                            <input 
                                type="text" 
                                name="titre" 
                                id="titre"
                                value="{{ old('titre', $tache->titre) }}" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            >
                            @error('titre')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 dark:text-gray-200">Description</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('description', $tache->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="statut" class="block text-sm font-medium text-white-700">Statut</label>
                            <select 
                                name="statut" 
                                id="statut" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="non commencé" {{ $tache->statut == 'non commencé' ? 'selected' : '' }}>Non commencé</option>
                                <option value="en cours" {{ $tache->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ $tache->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            </select>
                            @error('statut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="priorite" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Priorité</label>
                            <select 
                                name="priorite" 
                                id="priorite" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="faible" {{ $tache->priorite == 'faible' ? 'selected' : '' }}>Faible</option>
                                <option value="moyenne" {{ $tache->priorite == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="élevée" {{ $tache->priorite == 'élevée' ? 'selected' : '' }}>Élevée</option>
                            </select>
                            @error('priorite')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="projet_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Projet</label>
                            <select 
                                name="projet_id" 
                                id="projet_id" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @foreach($projets as $projet)
                                    <option value="{{ $projet->id }}" {{ $projet->id == $tache->projet_id ? 'selected' : '' }}>{{ $projet->titre }}</option>
                                @endforeach
                            </select>
                            @error('projet_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="assigne_a" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Assigner à</label>
                            <select 
                                name="assigne_a" 
                                id="assigne_a" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">Non assigné</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $tache->assigne_a ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('assigne_a')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons de soumission et annulation -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Mettre à jour
                            </button>
                            <a href="{{ route('taches.show') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
