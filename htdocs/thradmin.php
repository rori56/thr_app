<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $count = $_POST['count'];

    // Mettre à jour la variable count pour le login spécifié
    update_user_count($login, $count);
}

// Fonction pour mettre à jour la variable count pour un login spécifié (vous devez personnaliser cette fonction selon votre système de stockage des données)
function update_user_count($login, $count)
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

    // Mettre à jour la variable count pour le login spécifié dans la base de données
    $sql = "UPDATE users SET count = $count WHERE login = '$login'";
    $conn->query($sql);

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le compte</title>
</head>
<body>
    <h2>Modifier le compte</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="login">Login :</label>
        <input type="text" name="login" id="login" required><br><br>

        <label for="count">Nouveau count :</label>
        <input type="number" name="count" id="count" required><br><br>

        <input type="submit" value="Modifier">
    </form>
</body>
</html>