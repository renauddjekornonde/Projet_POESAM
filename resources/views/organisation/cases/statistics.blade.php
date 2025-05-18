@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'organisation'])

        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Statistiques des Cas</h1>
            </div>

            <!-- Cartes de statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total des cas</h5>
                            <h2 class="card-text" id="totalCases">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Cas en cours</h5>
                            <h2 class="card-text" id="inProgressCases">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Cas résolus</h5>
                            <h2 class="card-text" id="resolvedCases">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Cas en attente</h5>
                            <h2 class="card-text" id="pendingCases">0</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="row">
                <!-- Distribution des types de cas -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Distribution par type de cas</h5>
                            <canvas id="caseTypeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Évolution mensuelle -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Évolution mensuelle des cas</h5>
                            <canvas id="monthlyEvolutionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Matrice statut/type -->
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par statut et type</h5>
                            <canvas id="statusTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --primary-color: #8A2BE2;
        --secondary-color: #F8F9FA;
        --text-color: #333333;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }

    .card-title {
        color: var(--text-color);
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .card-text {
        color: var(--primary-color);
        font-weight: bold;
        margin-bottom: 0;
    }

    canvas {
        max-height: 300px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Charger les statistiques
    fetch('/organisation/cases/statistics/data')
        .then(response => response.json())
        .then(data => {
            // Mettre à jour les compteurs
            document.getElementById('totalCases').textContent = data.total;
            document.getElementById('inProgressCases').textContent = data.in_progress;
            document.getElementById('resolvedCases').textContent = data.resolved;
            document.getElementById('pendingCases').textContent = data.pending;

            // Graphique en camembert pour les types de cas
            const typeData = data.by_type;
            const typeCtx = document.getElementById('caseTypeChart').getContext('2d');
            new Chart(typeCtx, {
                type: 'pie',
                data: {
                    labels: typeData.map(item => item.type),
                    datasets: [{
                        data: typeData.map(item => item.count),
                        backgroundColor: [
                            '#8A2BE2',
                            '#9B59B6',
                            '#B39DDB',
                            '#D1C4E9'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Graphique d'évolution mensuelle
            const monthlyCtx = document.getElementById('monthlyEvolutionChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: data.monthly_evolution.map(item => item.month),
                    datasets: [{
                        label: 'Nombre de cas',
                        data: data.monthly_evolution.map(item => item.count),
                        borderColor: '#8A2BE2',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Graphique de la matrice statut/type
            const statusTypeData = data.status_type_matrix;
            const statusTypes = ['en_cours', 'résolu', 'en_attente'];
            const caseTypes = [...new Set(statusTypeData.map(item => item.type))];

            const statusTypeCtx = document.getElementById('statusTypeChart').getContext('2d');
            new Chart(statusTypeCtx, {
                type: 'bar',
                data: {
                    labels: caseTypes,
                    datasets: statusTypes.map((status, index) => ({
                        label: status,
                        data: caseTypes.map(type => {
                            const match = statusTypeData.find(item => item.type === type && item.status === status);
                            return match ? match.count : 0;
                        }),
                        backgroundColor: [
                            '#8A2BE2',
                            '#9B59B6',
                            '#B39DDB'
                        ][index]
                    }))
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement des statistiques:', error);
        });
});
</script>
@endsection
