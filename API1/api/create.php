<?php
include_once '../config/database.php';
include_once '../models/Prenda.php';

$database = new Database();
$db = $database->getConnection();

// Crea una nueva instancia de la clase Prenda
$prenda = new Prenda($db);

// Obtén los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Verifica que los datos necesarios estén presentes
if (isset($data->nombre_prenda) && isset($data->id_marca) && isset($data->precio) && isset($data->stock)) {
    
    // Llama al método create con los parámetros necesarios
    try {
        // Usamos el método create de la clase Prenda (se asume que es un método que recibe estos parámetros)
        if ($prenda->create($data->nombre_prenda, $data->id_marca, $data->precio, $data->stock)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "No se pudo crear la prenda."]);
        }
    } catch (Exception $e) {
        // Si ocurre algún error al interactuar con la base de datos, se captura la excepción
        echo json_encode(["success" => false, "error" => "Error en el servidor: " . $e->getMessage()]);
    }
    
} else {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
}
?>

