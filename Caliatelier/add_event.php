<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un événement</title>
</head>
<body>
    <h2>Ajouter un événement</h2>
    <form method="post" action="add_event.php">
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="location">Lieu :</label>
            <input type="text" id="location" name="location" required>
        </div>
        <div>
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div>
            <label for="time">Horaire :</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div>
            <label for="image">Image (URL) :</label>
            <input type="text" id="image" name="image">
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
<?php
require_once('config.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs du formulaire
    $title = $_POST["title"];
    $location = $_POST["location"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $image = $_POST["image"];
    $description = $_POST["description"];

    // Requête d'insertion des données dans la base de données
    $sql = "INSERT INTO events (title, location, date, time, image, description)
            VALUES ('$title', '$location', '$date', '$time', '$image', '$description')";

    if ($conn->query($sql) === TRUE) {
        // Affichage du message de confirmation
        $message = "Le formulaire a été soumis avec succès !";
        echo "<p>" . $message . "</p>";
    } else {
        // Affichage de l'erreur en cas d'échec de l'insertion
        echo "Erreur lors de l'insertion des données : " . $conn->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
