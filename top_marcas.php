<?php
$servername = "localhost";
$username = "root"; // Cambia esto si tienes otro usuario
$password = ""; // Tu contraseña
$dbname = "tienda_ropa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT M.nombre, SUM(V.cantidad) AS total_vendido
        FROM Marcas M
        JOIN Prendas P ON M.id_marca = P.id_marca
        JOIN Ventas V ON P.id_prenda = V.id_prenda
        GROUP BY M.nombre
        ORDER BY total_vendido DESC
        LIMIT 5";

$result = $conn->query($sql);

echo "<h2>Top 5 Marcas Más Vendidas:</h2>";

if ($result->num_rows > 0) {
    echo "<table><tr><th>Marca</th><th>Total Vendido</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['nombre'] . "</td><td>" . $row['total_vendido'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron marcas más vendidas.";
}

$conn->close();
?>
