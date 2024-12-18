<?php
require_once '../config/database.php';
require_once '../controllers/PrendaController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$database = new Database();
$db = $database->getConnection();

$controller = new PrendaController($db);

// Obtener los datos JSON enviados
$data = json_decode(file_get_contents('php://input'), true);

$response = [];

try {
    if (isset($data['id']) && $data['id'] !== null) {
        // Es una actualización
        $result = $controller->update(
            $data['id'], 
            $data['nombre_prenda'], 
            $data['id_marca'], 
            $data['precio'], 
            $data['stock']
        );
        
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Prenda actualizada correctamente'
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No se pudo actualizar la prenda'
            ];
        }
    } else {
        $response = [
            'success' => false,
            'error' => 'ID de prenda no proporcionado'
        ];
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

echo json_encode($response);
?>
