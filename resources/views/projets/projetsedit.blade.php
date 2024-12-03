<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le projet :') }} {{ $projet->titre }}
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
                    <form method="POST" action="{{ route('projets.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Champ caché pour l'ID -->
                        <input type="hidden" name="id" value="{{ $projet->id }}">

                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 dark:text-gray-200">Titre</label>
                            <input 
                                type="text" 
                                name="titre" 
                                id="titre"
                                value="{{ old('titre', $projet->titre) }}" 
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
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('description', $projet->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_limite" class="block text-gray-700 dark:text-gray-200">Date Limite</label>
                            <input 
                                type="date" 
                                name="date_limite" 
                                id="date_limite"
                                value="{{ old('date_limite', \Carbon\Carbon::parse($projet->date_limite)->format('Y-m-d')) }}"

                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            >
                            @error('date_limite')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="statut" class="block text-sm font-medium text-white-700">Statut</label>
                            <select 
                                name="statut" 
                                id="statut" 
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="en cours" {{ $projet->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ $projet->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            </select>
                            @error('statut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Mettre à jour
                            </button>
                            <a href="{{ route('projets.show') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
