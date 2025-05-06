@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-indigo-600">Jigeen</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <form action="{{ route('victime.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900">
                Tableau de bord
            </h2>
        </div>
    </header>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Card pour partager une histoire -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium text-gray-900">Partager votre histoire</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Partagez votre expérience pour aider d'autres personnes dans des situations similaires.
                                </p>
                                <div class="mt-4">
                                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Commencer à écrire
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card pour voir les ressources -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium text-gray-900">Ressources disponibles</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Accédez aux ressources et contacts des organisations partenaires.
                                </p>
                                <div class="mt-4">
                                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Voir les ressources
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card pour contacter une ONG -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium text-gray-900">Contacter une ONG</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Entrez en contact avec une organisation partenaire pour obtenir de l'aide.
                                </p>
                                <div class="mt-4">
                                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Voir les ONG
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
