<?php
$db = new mysqli('localhost', 'root', '', 'biblioteka');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_sql = "DELETE FROM książki WHERE ID = ?";
    $stmt = $db->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: bazydanych.php?action=deleted");
    } else {
        echo "Błąd podczas usuwania książki.";
    }
} else {
    echo "Brak ID książki.";
}
?>
