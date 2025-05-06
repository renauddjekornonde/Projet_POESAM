<?php
// Ce script est complètement indépendant de Laravel et de ses mécanismes CSRF

// Démarrer la session
session_start();

// Nous commentons cette redirection pour éviter la boucle infinie
// Si l'utilisateur est déjà connecté, nous affichons simplement le formulaire
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

// Traitement du formulaire d'inscription
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($password_confirmation)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $password_confirmation) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $pdo = connectDB();
        
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "Cet email est déjà utilisé.";
        } else {
            try {
                // Commencer une transaction
                $pdo->beginTransaction();
                
                // Insérer dans la table users
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $name = $prenom . ' ' . $nom; // Combiner prénom et nom pour le champ name
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                $stmt->execute([$name, $email, $hashedPassword]);
                $userId = $pdo->lastInsertId();
                
                // Insérer dans la table victimes
                $stmt = $pdo->prepare("INSERT INTO victimes (nom, prenom, id_user, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                $stmt->execute([$nom, $prenom, $userId]);
                
                // Valider la transaction
                $pdo->commit();
                
                // Connecter automatiquement l'utilisateur après inscription
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $prenom . ' ' . $nom;
                $_SESSION['is_logged_in'] = true;
                
                // Rediriger vers la page home.blade.php via une route Laravel
                header("Location: /home");
                exit;
            } catch (Exception $e) {
                // Annuler la transaction en cas d'erreur
                $pdo->rollBack();
                $error = "Une erreur est survenue lors de l'inscription: " . $e->getMessage();
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
    <title>Inscription - Jigeen</title>
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
        

        
        .register-container {
            width: 100%;
            max-width: 600px;
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 15px 35px var(--shadow-color);
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        
        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px var(--shadow-color);
        }
        
        .register-container::before {
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
        
        .register-container::after {
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
        
        .register-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        .register-header .logo {
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
        
        .register-header p {
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
            height: 50px;
            border-radius: 50px;
            padding-left: 20px;
            padding-right: 20px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
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
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: var(--light-text);
            position: relative;
            padding-top: 15px;
        }
        
        .login-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 25%;
            width: 50%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--border-color), transparent);
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .login-link a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .login-link a:hover::after {
            width: 100%;
        }
        
        .login-link a:hover {
            color: var(--primary-dark);
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
        
        .form-text {
            font-size: 0.75rem;
            color: var(--light-text);
            padding-left: 10px;
            margin-top: 5px;
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
    </style>
</head>
<body>
    <a href="/" class="back-to-home"><i class="fas fa-home"></i> Retour à l'accueil</a>
        <div class="register-container">
            <div class="register-header">
                <span class="logo">Jigeen</span>
                <p>Créez votre compte pour accéder à un espace sécurisé</p>
            </div>
            
            <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
                <div class="mt-2">
                    <a href="direct-login.php" class="btn btn-sm btn-primary">Se connecter</a>
                </div>
            </div>
            <?php endif; ?>
            
            <form action="direct-register.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prenom" class="form-label">Prénom</label>
                            <div class="input-group">
                               
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom</label>
                            <div class="input-group">
                               
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-group">
                      
                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre adresse email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        
                        <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    <div class="form-text">Le mot de passe doit contenir au moins 8 caractères.</div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <div class="input-group">
                        
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmez votre mot de passe" required>
                        <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">S'inscrire <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
                
                <div class="login-link">
                    <p>Vous avez déjà un compte? <a href="direct-login.php">Se connecter</a></p>
                </div>
            </form>
        </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour afficher/masquer les mots de passe -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPassword = document.getElementById('password_confirmation');
            
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
            
            if (toggleConfirmPassword && confirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    // Changer le type de l'input
                    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPassword.setAttribute('type', type);
                    
                    // Changer l'icône
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
