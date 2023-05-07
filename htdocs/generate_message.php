<?php
// Mettez en place la logique pour générer un message à partir d'un fichier de messages pré-écrits ici
$user_id = $_POST['user_id'];
$counter = get_user_counter($user_id); // Récupérer le compteur de l'utilisateur

// Lire les messages à partir du fichier
$messages = file("messages.txt", FILE_IGNORE_NEW_LINES);

// Vérifier si le compteur de l'utilisateur est à 0
if ($counter <= 0) {
    echo "<p>Plus de vies</p>";
} else {
    // Récupérer un message aléatoire parmi les messages disponibles
    $random_index = array_rand($messages);
    $message = $messages[$random_index];

    // Supprimer le message du tableau
    unset($messages[$random_index]);

    // Mettre à jour les messages dans le fichier
    $updated_messages = implode("\n", $messages);
    file_put_contents("messages.txt", $updated_messages);

    // Décrémenter le compteur de l'utilisateur
    $counter--;

    // Mettre à jour le compteur de l'utilisateur
    update_user_counter($user_id, $counter);

    // Afficher le message généré
    echo "<p>Message généré : $message</p>";
}

// Fonction pour mettre à jour le compteur de l'utilisateur (vous devez personnaliser cette fonction selon votre système de stockage des données)
function update_user_counter($user_id, $counter)
{
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

    // Mettre à jour le compteur de l'utilisateur dans la base de données
    $sql = "UPDATE users SET count = $counter WHERE id = $user_id";
    $conn->query($sql);

    // Fermer la connexion à la base de données
    $conn->close();
}

// Fonction pour récupérer le compteur de l'utilisateur (vous devez personnaliser cette fonction selon votre système de stockage des données)
function get_user_counter($user_id)
{
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

    // Récupérer le compteur de l'utilisateur depuis la base de données
    $sql = "SELECT count FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["count"];
    } else {
        return 0;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Redeem</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
