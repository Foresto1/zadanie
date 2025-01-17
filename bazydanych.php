<?php 
$conn = mysqli_connect("localhost" ,"root" ,"" ,"tabelka");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM ksiazki WHERE autor LIKE '%a'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela</title>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Autor</th>
            <th>Tytuł</th>
        </tr>
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['author'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "</tr>";
            }
            ?>
        
    </table>
    
</body>
</html>

