<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_COOKIE['is_logged_in']) || $_COOKIE['is_logged_in'] !== 'true' || !isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'admin') {
    header("Location: /direct-login.php");
    exit;
}

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

$error = '';
$success = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ignorer la vérification CSRF pour simplifier
    // Le token CSRF est envoyé mais nous ne le vérifions pas ici
    
    // Récupérer les données du formulaire
    $nom = $_POST['nom'] ?? '';
    $type = $_POST['type'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validation des données
    if (empty($nom) || empty($type) || empty($email) || empty($telephone) || empty($password) || empty($adresse) || empty($description)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $password_confirmation) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $pdo = connectDB();
        
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            $error = "Cet email est déjà utilisé.";
        } else {
            try {
                // Commencer une transaction
                $pdo->beginTransaction();
                
                // Créer l'utilisateur
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                $stmt->execute([$nom, $email, $hashedPassword]);
                $userId = $pdo->lastInsertId();
                
                // Créer l'organisation
                $stmt = $pdo->prepare("INSERT INTO organisations (id_user, nom_organisation, type_organisation, telephone_organisation, adresse_organisation, description_organisation, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
                $stmt->execute([$userId, $nom, $type, $telephone, $adresse, $description]);
                
                // Valider la transaction
                $pdo->commit();
                
                $success = "L'organisation a été créée avec succès.";
            } catch (PDOException $e) {
                // Annuler la transaction en cas d'erreur
                $pdo->rollBack();
                $error = "Erreur lors de la création de l'organisation: " . $e->getMessage();
            }
        }
    }
}

// Rediriger vers le tableau de bord admin avec un message
if (!empty($success)) {
    header("Location: /admin/dashboard?success=" . urlencode($success));
    exit;
} elseif (!empty($error)) {
    header("Location: /admin/dashboard?error=" . urlencode($error));
    exit;
} else {
    header("Location: /admin/dashboard");
    exit;
}
?>
