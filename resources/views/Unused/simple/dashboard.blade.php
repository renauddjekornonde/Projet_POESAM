<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        .sidebar {
            background-color: #8a56e2;
            color: white;
            padding: 20px;
            border-radius: 10px;
            height: calc(100vh - 100px);
        }
        .sidebar h3 {
            margin-bottom: 30px;
            font-size: 22px;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 100px);
        }
        .welcome-banner {
            background-color: #f0ebfa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .welcome-banner h2 {
            color: #8a56e2;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <h3>Jigeen</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-home"></i> Accueil</a></li>
                        <li><a href="#"><i class="fas fa-user"></i> Mon profil</a></li>
                        <li><a href="#"><i class="fas fa-comment"></i> Messages</a></li>
                        <li><a href="#"><i class="fas fa-hands-helping"></i> Ressources</a></li>
                        <li><a href="#"><i class="fas fa-calendar"></i> Événements</a></li>
                        <li><a href="#"><i class="fas fa-cog"></i> Paramètres</a></li>
                        <li><a href="{{ url('/simple-logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content">
                    <div class="welcome-banner">
                        <h2>Bienvenue, {{ session('user_name') }} !</h2>
                        <p>Nous sommes heureux de vous revoir sur votre espace sécurisé.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-comment text-primary me-2"></i> Messages</h5>
                                    <p class="card-text">Vous avez 0 nouveaux messages.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Voir tous les messages</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-calendar text-primary me-2"></i> Événements</h5>
                                    <p class="card-text">Aucun événement à venir.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Voir le calendrier</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-hands-helping text-primary me-2"></i> Ressources</h5>
                                    <p class="card-text">Accédez à nos ressources d'aide et de soutien.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Explorer les ressources</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-user text-primary me-2"></i> Mon profil</h5>
                                    <p class="card-text">Mettez à jour vos informations personnelles.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Modifier mon profil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
