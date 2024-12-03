<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer un Projet') }}
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

                    <form action="{{ route('projets.store') }}" method="POST">
                        @csrf

                        <!-- Titre du projet -->
                        <div class="mb-4">
                            <label for="titre" class="block text-sm font-medium text-white-700">{{ __('Titre') }}</label>
                            <input type="text" id="titre" name="titre"
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200
                                @error('titre') border-red-500 @else border-gray-300 @enderror"
                                value="{{ old('titre') }}" required>
                            @error('titre')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-white-700">{{ __('Description') }}</label>
                            <textarea id="description" name="description"
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200
                                @error('description') border-red-500 @else border-gray-300 @enderror"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date limite -->
                        <div class="mb-4">
                            <label for="date_limite" class="block text-sm font-medium text-white-700">{{ __('Date limite') }}</label>
                            <input type="date" id="date_limite" name="date_limite"
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200
                                @error('date_limite') border-red-500 @else border-gray-300 @enderror"
                                value="{{ old('date_limite') }}" required>
                            @error('date_limite')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-4">
                            <label for="statut" class="block text-sm font-medium text-white-700">{{ __('Statut') }}</label>
                            <select id="statut" name="statut"
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200
                                @error('statut') border-red-500 @else border-gray-300 @enderror" required>
                                <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>{{ __('En cours') }}</option>
                                <option value="terminé" {{ old('statut') == 'terminé' ? 'selected' : '' }}>{{ __('Terminé') }}</option>
                                <option value="annulé" {{ old('statut') == 'annulé' ? 'selected' : '' }}>{{ __('Annulé') }}</option>
                            </select>
                            @error('statut')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Soumettre le formulaire -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                {{ __('Créer le projet') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
