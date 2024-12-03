<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tableau de Bord') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Projets -->
                <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-white">Projets</h3>
                    <div class="flex justify-between">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $totalProjets }}</div>
                            <div class="text-sm text-gray-400">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $projetsCours }}</div>
                            <div class="text-sm text-gray-400">En cours</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $projetsTerm }}</div>
                            <div class="text-sm text-gray-400">Terminés</div>
                        </div>
                    </div>
                </div>

                <!-- Tâches -->
                <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-white">Tâches</h3>
                    <div class="flex justify-between">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $totalTaches }}</div>
                            <div class="text-sm text-gray-400">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $tachesCours }}</div>
                            <div class="text-sm text-gray-400">En cours</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $tachesTerm }}</div>
                            <div class="text-sm text-gray-400">Terminées</div>
                        </div>
                    </div>
                </div>

                <!-- Graphique ou Statistiques supplémentaires -->
                <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-white">Progression</h3>
                    <div class="flex items-center justify-center">
                        @php
                            $totalProjetsEtTaches = $totalProjets + $totalTaches;
                            $pourcentageProjetsTermines = $totalProjetsEtTaches > 0 ?
                                (($projetsTerm + $tachesTerm) / $totalProjetsEtTaches) * 100 : 0;
                        @endphp
                        <div class="radial-progress text-white text-2xl"
                             style="--value:{{ round($pourcentageProjetsTermines) }}; --size:4rem; --thickness: 10px;">
                            {{ round($pourcentageProjetsTermines) }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections Récentes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Projets Récents -->
                <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-white">Projets Récents</h3>
                    @foreach($projetsRecents as $projet)
                        <div class="border-b border-gray-700 py-2 last:border-b-0">
                            <div class="flex justify-between">
                                <span class="text-white">{{ $projet->titre }}</span>
                                <span class="text-sm text-gray-400">{{ $projet->statut }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tâches Récentes -->
                <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-white">Tâches Récentes</h3>
                    @foreach($tachesRecentes as $tache)
                        <div class="border-b border-gray-700 py-2 last:border-b-0">
                            <div class="flex justify-between">
                                <span class="text-white">{{ $tache->titre }}</span>
                                <span class="text-sm text-gray-400">{{ $tache->statut }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
