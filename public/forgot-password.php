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

// Fonction pour générer un token unique
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

// Fonction pour stocker un token de réinitialisation
function storeResetToken($email, $token, $expiry) {
    $resetData = [
        'email' => $email,
        'token' => $token,
        'expiry' => $expiry
    ];
    
    $resetFile = __DIR__ . '/../storage/reset_tokens.json';
    $directory = dirname($resetFile);
    
    // Créer le répertoire s'il n'existe pas
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    
    // Lire les tokens existants
    $tokens = [];
    if (file_exists($resetFile)) {
        $tokens = json_decode(file_get_contents($resetFile), true) ?: [];
    }
    
    // Supprimer l'ancien token pour cet email s'il existe
    foreach ($tokens as $key => $data) {
        if ($data['email'] === $email) {
            unset($tokens[$key]);
        }
    }
    
    // Ajouter le nouveau token
    $tokens[] = $resetData;
    
    // Sauvegarder les tokens
    file_put_contents($resetFile, json_encode($tokens));
    
    return true;
}

// Fonction pour simuler l'envoi d'un email (pour développement)
function sendResetEmail($email, $token) {
    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password.php?token=" . $token;
    
    // Pour le développement, nous affichons simplement le lien
    echo "<div class='alert alert-info'>En environnement de production, un email serait envoyé à {$email} avec le lien de réinitialisation.<br>Pour le développement, utilisez ce lien: <a href='{$resetLink}'>{$resetLink}</a></div>";
    
    return true;
    
    // Code pour l'envoi réel d'email (décommenté en production)
    /*
    $subject = "Réinitialisation de votre mot de passe - Jigeen";
    
    $message = "
    <html>
    <head>
        <title>Réinitialisation de votre mot de passe</title>
    </head>
    <body>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;'>
            <div style='background-color: #8a56e2; padding: 20px; text-align: center; color: white; border-radius: 10px 10px 0 0;'>
                <h1>Jigeen</h1>
                <p>Réinitialisation de votre mot de passe</p>
            </div>
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 0 0 10px 10px; border: 1px solid #e9ecef; border-top: none;'>
                <p>Bonjour,</p>
                <p>Vous avez demandé la réinitialisation de votre mot de passe. Veuillez cliquer sur le lien ci-dessous pour créer un nouveau mot de passe :</p>
                <p style='text-align: center;'>
                    <a href='{$resetLink}' style='display: inline-block; background-color: #8a56e2; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Réinitialiser mon mot de passe</a>
                </p>
                <p>Ce lien est valable pendant 24 heures. Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email.</p>
                <p>Cordialement,<br>L'équipe Jigeen</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // En-têtes pour l'email HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Jigeen <no-reply@jigeen.com>" . "\r\n";
    
    // Envoi de l'email
    return mail($email, $subject, $message, $headers);
    */
}

// Traitement du formulaire
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (empty($email)) {
        $error = "Veuillez entrer votre adresse email.";
    } else {
        $pdo = connectDB();
        
        // Vérifier si l'email existe dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Générer un token unique
            $token = generateToken();
            $expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            // Stocker le token dans un fichier
            if (storeResetToken($email, $token, $expiry)) {
                // Envoyer l'email de réinitialisation (ou afficher le lien en développement)
                sendResetEmail($email, $token);
                $success = "Un lien de réinitialisation a été généré pour votre adresse email.";
            } else {
                $error = "Une erreur s'est produite lors de la création du token de réinitialisation. Veuillez réessayer.";
            }
        } else {
            // Pour des raisons de sécurité, ne pas indiquer si l'email existe ou non
            $success = "Si cette adresse email est associée à un compte, un lien de réinitialisation sera généré.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Jigeen</title>
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
        
        .forgot-container {
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
        
        .forgot-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px var(--shadow-color);
        }
        
        .forgot-container::before {
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
        
        .forgot-container::after {
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
        
        .forgot-header {
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
        
        .forgot-header p {
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
    </style>
</head>
<body>
    <a href="/" class="back-to-home"><i class="fas fa-home"></i> Retour à l'accueil</a>
    
    <div class="forgot-container">
        <div class="forgot-header">
            <span class="logo">Jigeen</span>
            <p>Réinitialisation de votre mot de passe</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <p class="mb-4">Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
        
        <form action="forgot-password.php" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation <i class="fas fa-paper-plane ms-1"></i></button>
            </div>
        </form>
        <?php endif; ?>
        
        <div class="login-link">
            <p>Vous vous souvenez de votre mot de passe? <a href="direct-login.php">Se connecter</a></p>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
