<?php
$servername = "localhost";
$username = "root"; // Cambia esto si tienes otro usuario
$password = ""; // Tu contraseña
$dbname = "tienda_ropa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT M.nombre
        FROM Marcas M
        JOIN Prendas P ON M.id_marca = P.id_marca
        JOIN Ventas V ON P.id_prenda = V.id_prenda";

$result = $conn->query($sql);

echo "<h2>Marcas que tienen al menos una venta:</h2>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['nombre'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No se encontraron marcas con ventas.";
}

$conn->close();
?>
