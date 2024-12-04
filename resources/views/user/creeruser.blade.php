<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer un nouvel utilisateur') }}
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
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulaire de création d'utilisateur -->
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Nom') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nom de l'utilisateur">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Email de l'utilisateur">
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Mot de passe') }}</label>
                            <input type="password" name="password" id="password" required class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Mot de passe">
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Confirmer le mot de passe') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Confirmer le mot de passe">
                        </div>

                        <!-- Rôle -->
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Rôle') }}</label>
                            <select name="role" id="role" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="admin">Admin</option>
                                <option value="user">Utilisateur</option>
                            </select>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('users.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 px-4 py-2">{{ __('Retour') }}</a>

                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                                {{ __('Créer l\'utilisateur') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
