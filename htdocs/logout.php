<?php
session_start(); // Démarrer une session

// Détruire toutes les données de la session
session_destroy();

// Rediriger vers index.php
header("Location: index.php");
exit();
?>
