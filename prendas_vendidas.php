<?php
$servername = "localhost";
$username = "root"; // Cambia esto si tienes otro usuario
$password = ""; // Tu contraseña
$dbname = "tienda_ropa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT P.nombre_prenda, SUM(V.cantidad) AS total_vendido, P.stock
        FROM Prendas P
        JOIN Ventas V ON P.id_prenda = V.id_prenda
        GROUP BY P.nombre_prenda, P.stock";

$result = $conn->query($sql);

echo "<h2>Prendas Vendidas y Stock Restante:</h2>";

if ($result->num_rows > 0) {
    echo "<table><tr><th>Nombre de la Prenda</th><th>Cantidad Vendida</th><th>Stock Restante</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['nombre_prenda'] . "</td><td>" . $row['total_vendido'] . "</td><td>" . $row['stock'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>
