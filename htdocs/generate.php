<?php
session_start(); // Démarrer une session

// Vérifier si l'utilisateur n'est pas connecté, le rediriger vers index.php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fonction pour récupérer le compteur de l'utilisateur à partir de la base de données
function get_user_counter($user_id) {
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

    // Récupérer le compteur de l'utilisateur
    $sql = "SELECT count FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["count"];
    } else {
        return 0;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application de messages</title>
    <style>
        body {
            background-color: #222222;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }

        h1 {
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            background-color: #ff6600;
            color: #ffffff;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff8533;
        }

        p {
            margin: 0;
        }

        p.counter {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Application de messages</h1>
        <form action="generate_message.php" method="post">
            <input type="hidden" name="user_id" value="1" />
            <button type="submit">Générer un message</button>
        </form>
        <form action="logout.php" method="post">
            <button type="submit">Se déconnecter</button>
        </form>
        <?php
        // Afficher le compteur pour l'utilisateur actuel
        $user_id = $_SESSION['user_id']; // L'ID de l'utilisateur actuel
        $counter = get_user_counter($user_id); // Fonction pour récupérer le compteur de l'utilisateur
        echo "<p class='counter'>Compteur : $counter</p>";
        ?>
    </div>
</body>
</html>