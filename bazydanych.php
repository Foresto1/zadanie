<?php 
$conn = mysqli_connect("localhost" ,"root" ,"" ,"tabelka");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
$sql = "SELECT * FROM ksiazki WHERE author LIKE 'a%'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>wyszukiwanie wg. autora</h1>
    <form action="bazydanych.php" method="post">
        <div class="row">
        <label for="name" class="col form-label">Nazwisko autora:</label>
        <input type="text" name="name" id="name" class="col form-control">
        <input type="submit" value="Szukaj" class="col btn btn-primary">
        </div>
    </form>
    <?php
    $name = "%";
    if (isset($_POST['name'])) {
        $name = "%" . $_POST['name'] . "%";
    }
    
    $sql = "SELECT 
                książki.ID, 
                CONCAT(autorzy.Imię, ' ', autorzy.Nazwisko) AS autor, 
                książki.Tytuł AS tytuł 
            FROM książki 
            LEFT JOIN autorzy ON autorzy.ID_autora = książki.Autor 
            WHERE autorzy.Nazwisko LIKE '" . $name . "' 
            OR autorzy.Imię LIKE '" . $name . "'";

    $db = new mysqli('localhost', 'root', '', 'biblioteka');
    $result = $db->query($sql);
    echo '<table class="table">';
    echo "<tr><th>ID</th><th>Autor</th><th>Tytuł</th><th>Akcje</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $id = $row['ID'];
        $author = $row['autor'];
        $title = $row['tytuł'];
        echo "<tr>";
        echo "<td>$id</td><td>$author</td><td>$title</td>";
        $edit = "<button onclick=\"location.href='edit.php?id=$id'\">edytuj</button>";
        $delete = "<button onclick=\"location.href='delete.php?id=$id'\">usun</button>";
        echo "<td>$edit $delete</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
