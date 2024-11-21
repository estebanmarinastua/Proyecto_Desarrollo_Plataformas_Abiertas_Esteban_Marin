<?php
$servername = "localhost";
$username = "root"; // Cambia esto si tienes otro usuario
$password = ""; // Tu contraseña
$dbname = "tienda_ropa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$fecha_venta = $_GET['fecha_venta'];

$sql = "SELECT P.nombre_prenda, V.fecha_venta, SUM(V.cantidad) AS total_vendido
        FROM Ventas V
        JOIN Prendas P ON V.id_prenda = P.id_prenda
        WHERE V.fecha_venta = ?
        GROUP BY P.nombre_prenda, V.fecha_venta";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha_venta);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Resultado de la consulta para la fecha: " . $fecha_venta . "</h2>";

if ($result->num_rows > 0) {
    echo "<table><tr><th>Nombre de la Prenda</th><th>Cantidad Vendida</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['nombre_prenda'] . "</td><td>" . $row['total_vendido'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron ventas para la fecha seleccionada.";
}

$conn->close();
?>
