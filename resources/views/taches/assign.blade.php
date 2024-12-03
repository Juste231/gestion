<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier l\'assignation de la tâche') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Message de succès ou d'erreur -->
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

                    <!-- Affichage des informations de la tâche -->
                    <div class="mb-6 p-4 text-gray-700 dark:text-gray-300 rounded-md">
                        <h3 class="font-semibold text-lg">Nom de la tache : {{ $tache->titre }}</h3>

                        <!-- Affichage de l'utilisateur assigné -->
                        <p class="font-semibold text-lg">
                            <strong>Utilisateur assigné actuellement :</strong> 
                            @if($tache->user_name)
                                {{ $tache->user_name }}
                            @else
                                <span class="italic text-gray-400">Aucun utilisateur assigné</span>
                            @endif
                        </p>
                    </div>

                    <!-- Formulaire pour modifier l'assignation -->
                    <form action="{{ route('taches.updateassign') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Sélection de l'utilisateur à assigner -->
                        <div class="mt-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigner un utilisateur</label>
                            <select name="user_id" id="user_id" class="w-full p-3 mt-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="">Choisir un utilisateur</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $tache->assigne_a ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="tache_id" value="{{ $tache->id }}">

                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Modifier
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
