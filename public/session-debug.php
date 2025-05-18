<?php
// Script de débogage pour vérifier les sessions
session_start();

echo "<h1>Débogage des sessions</h1>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n\n";
echo "Contenu de la session:\n";
print_r($_SESSION);
echo "</pre>";

echo "<h2>Tests de session</h2>";
echo "<p>Essayons de définir une valeur de session:</p>";

$_SESSION['test_value'] = "Test à " . date('H:i:s');
echo "<p>Valeur définie: " . $_SESSION['test_value'] . "</p>";

echo "<p><a href='/'>Retour à l'accueil</a></p>";
echo "<p><a href='/home'>Aller au tableau de bord</a></p>";
echo "<p><a href='/direct-login.php'>Aller à la page de connexion</a></p>";
?>
