<?php
require_once('config.php');

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit();
}

// Vérifier si les dates de début et de fin sont fournies
if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    // Construire la requête SQL avec la condition WHERE pour filtrer les événements par plage horaire
    $sql = "SELECT * FROM events WHERE date BETWEEN :startDate AND :endDate";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
} else {
    // Requête SQL pour récupérer tous les événements si aucune plage horaire n'est spécifiée
    $sql = "SELECT * FROM events";
    $stmt = $db->prepare($sql);
}
//  Construire la requête SQL avec la conditionWHERE pour filtrer les événements par plage horaire
$sql = "SELECT  * FROM events WHERE date BETWEEN :startDate AND  :endDate ORDER BY date";
$stmt = $db->prepare($sql);
// Exécuter la requête SQL
$stmt->execute();

// Récupérer les événements depuis la base de données
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les événements au format JSON
header('Content-Type: application/json');
echo json_encode($events);
?>
