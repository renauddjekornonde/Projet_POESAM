<?php
// Ce script est complètement indépendant de Laravel et de ses mécanismes CSRF

// Démarrer la session
session_start();

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

// Fonction pour vérifier si un token est valide
function getResetTokenData($token) {
    $resetFile = __DIR__ . '/../storage/reset_tokens.json';
    
    if (!file_exists($resetFile)) {
        return null;
    }
    
    $tokens = json_decode(file_get_contents($resetFile), true) ?: [];
    
    foreach ($tokens as $data) {
        if ($data['token'] === $token) {
            // Vérifier si le token n'a pas expiré (24h)
            $expiry = strtotime($data['expiry']);
            if ($expiry > time()) {
                return $data;
            }
        }
    }
    
    return null;
}

// Fonction pour supprimer un token
function removeResetToken($email) {
    $resetFile = __DIR__ . '/../storage/reset_tokens.json';
    
    if (!file_exists($resetFile)) {
        return;
    }
    
    $tokens = json_decode(file_get_contents($resetFile), true) ?: [];
    
    foreach ($tokens as $key => $data) {
        if ($data['email'] === $email) {
            unset($tokens[$key]);
        }
    }
    
    // Réindexer le tableau
    $tokens = array_values($tokens);
    
    // Sauvegarder les tokens
    file_put_contents($resetFile, json_encode($tokens));
}

// Vérifier si le token est valide
$token = $_GET['token'] ?? '';
$tokenValid = false;
$email = '';
$error = '';
$success = '';

if (!empty($token)) {
    $resetData = getResetTokenData($token);
    
    if ($resetData) {
        $tokenValid = true;
        $email = $resetData['email'];
    } else {
        $error = "Ce lien de réinitialisation est invalide ou a expiré. Veuillez demander un nouveau lien.";
    }
}

// Traitement du formulaire de réinitialisation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValid) {
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    
    if (empty($password)) {
        $error = "Veuillez entrer un mot de passe.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $password_confirmation) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $pdo = connectDB();
        
        // Mettre à jour le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $email]);
        
        // Supprimer le token de réinitialisation
        removeResetToken($email);
        
        $success = "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.";
        $tokenValid = false; // Ne plus afficher le formulaire
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        .reset-container {
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
        
        .reset-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px var(--shadow-color);
        }
        
        .reset-container::before {
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
        
        .reset-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 150px;
            height: 150px;
            background-color: var(--secondary-color);
            border-radius: 0 100% 0 0;
            z-index: 0;
        }
        
        .reset-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        .logo {
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
        
        .reset-header p {
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
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-color);
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .form-group:hover .form-label {
            color: var(--primary-color);
        }
        
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
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
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px var(--shadow-color);
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
        
        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        .form-text {
            color: var(--light-text);
            font-size: 13px;
            margin-top: 5px;
            padding-left: 10px;
        }
    </style>
</head>
<body>
    <a href="/" class="back-to-home"><i class="fas fa-home"></i> Retour à l'accueil</a>
    
    <div class="reset-container">
        <div class="reset-header">
            <span class="logo">Jigeen</span>
            <p>Créez un nouveau mot de passe</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
            <div class="mt-3">
                <a href="direct-login.php" class="btn btn-primary">Se connecter</a>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($tokenValid): ?>
        <form action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            
            <div class="form-group">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>
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
                <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe <i class="fas fa-check ms-1"></i></button>
            </div>
        </form>
        <?php elseif (!$success): ?>
        <div class="alert alert-danger">
            Ce lien de réinitialisation est invalide ou a expiré. Veuillez demander un nouveau lien.
            <div class="mt-3">
                <a href="forgot-password.php" class="btn btn-primary">Demander un nouveau lien</a>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="login-link">
            <p>Vous vous souvenez de votre mot de passe? <a href="direct-login.php">Se connecter</a></p>
        </div>
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
