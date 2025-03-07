<?php
$db = new mysqli('localhost', 'root', '', 'biblioteka');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT książki.ID, książki.Tytuł, książki.Autor, autorzy.Imię, autorzy.Nazwisko 
            FROM książki 
            LEFT JOIN autorzy ON autorzy.ID_autora = książki.Autor 
            WHERE książki.ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $title = $row['Tytuł'];
        $author_id = $row['Autor'];
    } else {
        echo "Nie znaleziono książki.";
        exit;
    }
} else {
    echo "Brak ID książki.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_title = $_POST['title'];
    $new_author_id = $_POST['author_id'];

    $update_sql = "UPDATE książki SET Tytuł = ?, Autor = ? WHERE ID = ?";
    $stmt = $db->prepare($update_sql);
    $stmt->bind_param("sii", $new_title, $new_author_id, $id);

    if ($stmt->execute()) {
        header("Location: bazydanych.php?action=edited");
    } else {
        echo "Błąd podczas aktualizacji.";
    }
}

$authors = $db->query("SELECT ID_autora, Imię, Nazwisko FROM autorzy ORDER BY Nazwisko");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj książkę</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Edytuj książkę</h1>
        <form action="edit.php?id=<?php echo $id; ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Tytuł książki:</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $title; ?>" required>
            </div>
            <div class="mb-3">
                <label for="author_id" class="form-label">Autor:</label>
                <select name="author_id" id="author_id" class="form-control" required>
                    <?php while ($author = $authors->fetch_assoc()) { ?>
                        <option value="<?php echo $author['ID_autora']; ?>" <?php echo ($author['ID_autora'] == $author_id) ? 'selected' : ''; ?>>
                            <?php echo $author['Imię'] . ' ' . $author['Nazwisko']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
</body>

</html>
