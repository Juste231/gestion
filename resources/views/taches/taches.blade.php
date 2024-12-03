<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer une Tâche') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('taches.store') }}">
                        @csrf

                        <!-- Titre -->
                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                {{ __('Titre') }}
                            </label>
                            <input type="text" name="titre" id="titre" class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ old('titre') }}" required>
                            @error('titre')
                                <div class="text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                {{ __('Description') }}
                            </label>
                            <textarea name="description" id="description" rows="4" class="resize-none w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Priorité -->
                        <div class="mb-4">
                            <label for="priorite" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                {{ __('Priorité') }}
                            </label>
                            <select name="priorite" id="priorite" class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>{{ __('Faible') }}</option>
                                <option value="moyen" {{ old('priorite') == 'moyen' ? 'selected' : '' }}>{{ __('Moyen') }}</option>
                                <option value="urgent" {{ old('priorite') == 'urgent' ? 'selected' : '' }}>{{ __('Urgent') }}</option>
                            </select>
                            @error('priorite')
                                <div class="text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Projet -->
                        <div class="mb-4">
                            <label for="projet_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                {{ __('Projet') }}
                            </label>
                            <select name="projet_id" id="projet_id" class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                <option value="">{{ __('Sélectionner un projet') }}</option>
                                @foreach($projets as $projet)
                                    <option value="{{ $projet->id }}" {{ old('projet_id') == $projet->id ? 'selected' : '' }}>{{ $projet->titre }}</option>
                                @endforeach
                            </select>
                            @error('projet_id')
                                <div class="text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assigné à -->
                        <div class="mb-4">
                            <label for="assigne_a" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                {{ __('Assigné à') }}
                            </label>
                            <select name="assigne_a" id="assigne_a" class="w-full p-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" >
                                <option value="">{{ __('Sélectionner un utilisateur') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigne_a') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('assigne_a')
                                <div class="text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                {{ __('Créer la Tâche') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
