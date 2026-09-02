<?php
$conn = new mysqli('db', 'public', 'public', 'radservice');

if ($conn->connect_error) {
    die('DB-Verbindung fehlgeschlagen: ' . $conn->connect_error);
}

echo "<h1>RadService läuft!</h1>";
echo "<p>DB-Verbindung erfolgreich.</p>";

$result = $conn->query("SELECT * FROM bike_type");
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . htmlspecialchars($row['name']) . " – " . htmlspecialchars($row['base_price']) . " €</li>";
}
echo "</ul>";
