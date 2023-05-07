<?php
session_start(); // Démarrer une session

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page generate.php
if (isset($_SESSION['user_id'])) {
    header("Location: generate.php");
    exit();
}

// Établissement de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thr";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_utilisateur = $_POST['nom_utilisateur'];

    // Vérifier les informations de connexion
    $sql = "SELECT id FROM users WHERE login = '$nom_utilisateur'";

    // Exécuter la requête
    $resultat = $conn->query($sql);

    // Vérifier si les informations de connexion sont valides
    if ($resultat->num_rows === 1) {
        // Utilisateur authentifié avec succès
        $row = $resultat->fetch_assoc();
        $user_id = $row["id"];

        // Enregistrer l'ID de l'utilisateur dans la session
        $_SESSION['user_id'] = $user_id;

        // Rediriger vers la page generate.php
        header("Location: generate.php");
        exit();
    } else {
        // Informations de connexion invalides
        $erreur = "Nom d'utilisateur incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <img src="media/bonchance.png">
    <title>Page de connexion</title>
    <style>
        body {
            background-color: #222222;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        h1 {
            margin-top: 50px;
        }

        form {
            margin-top: 50px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #ff6600;
            color: #ffffff;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #ff8533;
        }

        p.error-message {
            color: #ff0000;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Page de connexion</h1>
    <?php if (isset($erreur)): ?>
        <p class="error-message"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="nom_utilisateur">Nom d'utilisateur:</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br>

        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
