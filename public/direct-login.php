<?php
// Ce script est complètement indépendant de Laravel et de ses mécanismes CSRF

// Démarrer la session
session_start();

// Déconnexion
if (isset($_GET['logout'])) {
    // Supprimer la session PHP
    session_unset();
    session_destroy();
    
    // Supprimer les cookies de connexion
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_email', '', time() - 3600, '/');
    setcookie('user_name', '', time() - 3600, '/');
    setcookie('is_logged_in', '', time() - 3600, '/');
    
    // Rediriger vers la page d'accueil
    header("Location: /");
    exit;
}

// Nous commentons cette redirection pour éviter la boucle infinie
// Si l'utilisateur est déjà connecté, nous affichons simplement le formulaire
// ou nous pourrions rediriger vers une page statique
/*
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
    header("Location: /home");
    exit;
}
*/

// Fonction pour se connecter à la base de données
function connectDB() {
    // Configuration Docker
    $host = 'db'; // Le nom du service MySQL dans docker-compose.yml
    $db = 'poesam';
    $user = 'root';
    $pass = 'rootpass';
    $charset = 'utf8mb4';
    
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données: " . $e->getMessage());
    }
}

// Traitement du formulaire de connexion
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Vérifier si c'est l'admin
        if ($email === 'adminvdf@gmail.com' && $password === 'Sami.yusuf77') {
            // Authentification admin réussie
            $_SESSION['user_id'] = 'admin';
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = 'Administrateur';
            $_SESSION['user_type'] = 'admin';
            $_SESSION['is_logged_in'] = true;
            
            // Créer un cookie pour partager les informations avec Laravel
            setcookie('user_id', 'admin', 0, '/');
            setcookie('user_email', $email, 0, '/');
            setcookie('user_name', 'Administrateur', 0, '/');
            setcookie('user_type', 'admin', 0, '/');
            setcookie('is_logged_in', 'true', 0, '/');
            
            // Rediriger vers le tableau de bord admin
            header("Location: /admin/dashboard");
            exit;
        } else {
            $pdo = connectDB();
            
            // Vérifier les identifiants
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Vérifier le type d'utilisateur
                $user_type = '';
                $user_name = '';
                $redirect_to = '';
                
                // Vérifier si c'est une victime
                $stmt = $pdo->prepare("SELECT * FROM victimes WHERE id_user = ?");
                $stmt->execute([$user['id']]);
                $victime = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($victime) {
                    $user_type = 'victime';
                    $user_name = $victime['prenom'] . ' ' . $victime['nom'];
                    $redirect_to = '/home';
                } else {
                    // Vérifier si c'est une organisation
                    $stmt = $pdo->prepare("SELECT * FROM organisations WHERE id_user = ?");
                    $stmt->execute([$user['id']]);
                    $organisation = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($organisation) {
                        $user_type = 'organisation';
                        // Vérifier quelle colonne existe pour le nom de l'organisation
                        if (isset($organisation['nom_organisation'])) {
                            $user_name = $organisation['nom_organisation'];
                        } elseif (isset($organisation['nom'])) {
                            $user_name = $organisation['nom'];
                        } else {
                            // Utiliser le nom de l'utilisateur comme fallback
                            $user_name = $user['name'];
                        }
                        $redirect_to = '/organisation/dashboard';
                    } else {
                        $error = "Compte non associé à une victime ou une organisation.";
                    }
                }
                
                if (!empty($user_type)) {
                    // Authentification réussie
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user_name;
                    $_SESSION['user_type'] = $user_type;
                    $_SESSION['is_logged_in'] = true;
                    
                    // Créer un cookie pour partager les informations avec Laravel
                    setcookie('user_id', $user['id'], 0, '/');
                    setcookie('user_email', $user['email'], 0, '/');
                    setcookie('user_name', $user_name, 0, '/');
                    setcookie('user_type', $user_type, 0, '/');
                    setcookie('is_logged_in', 'true', 0, '/');
                    
                    // Rediriger vers le tableau de bord approprié
                    header("Location: " . $redirect_to);
                    exit;
                }
            } else {
                $error = "Identifiants incorrects.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #8a56e2;
            --primary-dark: #7042c2;
            --secondary-color: #f0ebfa;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-text: #6c757d;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --gradient-start: #8a56e2;
            --gradient-end: #6a3fcf;
            --shadow-color: rgba(138, 86, 226, 0.2);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 15px 35px var(--shadow-color);
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        
        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px var(--shadow-color);
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background-color: var(--secondary-color);
            border-radius: 0 0 0 100%;
            z-index: 0;
        }
        
        .login-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 120px;
            height: 120px;
            background-color: var(--secondary-color);
            border-radius: 0 100% 0 0;
            z-index: 0;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        .login-header .logo {
            font-size: 38px;
            font-weight: 700;
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            margin-bottom: 12px;
            letter-spacing: 1px;
        }
        
        .login-header p {
            color: var(--light-text);
            font-size: 16px;
            font-weight: 500;
            margin-top: 5px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .form-group:hover {
            transform: translateX(3px);
        }
        
        .form-control {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 15px;
            color: var(--text-color);
            background-color: var(--white);
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.01);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(138, 86, 226, 0.2);
            outline: none;
            transform: translateY(-2px);
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            padding-left: 5px;
        }
        
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon-wrapper {
            position: absolute;
            left: -40px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .form-group:hover .input-icon-wrapper {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-50%) scale(1.05);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
            cursor: pointer;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            width: 100%;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px var(--shadow-color);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px var(--shadow-color);
            background: linear-gradient(to right, var(--primary-dark), var(--gradient-start));
        }
        
        .alert {
            border-radius: 10px;
            position: relative;
            z-index: 1;
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: var(--light-text);
            position: relative;
            padding-top: 15px;
        }
        
        .register-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 25%;
            width: 50%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--border-color), transparent);
        }
        
        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .register-link a:hover {
            color: var(--primary-dark);
        }
        
        .forgot-password-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .forgot-password-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .forgot-password-link:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }
        
        .forgot-password-link:hover::after {
            width: 100%;
        }
        
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            z-index: 10;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .back-to-home i {
            margin-right: 8px;
        }
        
        .back-to-home:hover {
            background-color: var(--white);
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .back-to-home:hover {
            color: #7442d3;
        }
    </style>
</head>
<body>
    <a href="/" class="back-to-home"><i class="fas fa-home"></i> Retour à l'accueil</a>
    
    <?php if (isset($is_logged_in) && $is_logged_in): ?>
        <!-- Affichage du tableau de bord directement ici -->
        <div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 20px;">
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
            <div style="background-color: white; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px;">
                <h2 style="color: #8a56e2; margin-bottom: 20px;">Tableau de bord</h2>
                <p>Vous êtes maintenant connecté à votre espace sécurisé.</p>
                <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 30px;">
                    <div style="flex: 1; min-width: 250px; background-color: #f0ebfa; padding: 20px; border-radius: 10px;">
                        <h3 style="color: #8a56e2;">Informations personnelles</h3>
                        <p><strong>Nom:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                    </div>
                    <div style="flex: 1; min-width: 250px; background-color: #f0ebfa; padding: 20px; border-radius: 10px;">
                        <h3 style="color: #8a56e2;">Actions rapides</h3>
                        <ul style="padding-left: 20px;">
                            <li><a href="#" style="color: #8a56e2; text-decoration: none;">Modifier mon profil</a></li>
                            <li><a href="#" style="color: #8a56e2; text-decoration: none;">Consulter les ressources</a></li>
                            <li><a href="#" style="color: #8a56e2; text-decoration: none;">Contacter un conseiller</a></li>
                        </ul>
                    </div>
                </div>
                <div style="margin-top: 30px;">
                    <a href="direct-login.php?logout=1" class="btn btn-outline-primary">Déconnexion</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="login-container">
        <div class="login-header">
            <span class="logo">Jigeen</span>
            <p>Connectez-vous à votre espace sécurisé</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <form action="direct-login.php" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <div class="input-group">
                    
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                   
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Se connecter <i class="fas fa-arrow-right ms-1"></i></button>
            </div>
            
            <div class="text-end mb-3">
                <a href="forgot-password.php" class="forgot-password-link">Mot de passe oublié?</a>
            </div>
        </form>
        
        <div class="register-link">
            <p>Pas encore de compte? <a href="direct-register.php">S'inscrire</a></p>
        </div>
        </div>
    <?php endif; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour afficher/masquer le mot de passe -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    // Changer le type de l'input
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    
                    // Changer l'icône
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
