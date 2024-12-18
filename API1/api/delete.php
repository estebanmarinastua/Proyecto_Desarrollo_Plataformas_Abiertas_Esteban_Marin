<?php
require_once '../config/database.php';
require_once '../controllers/PrendaController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$database = new Database();
$db = $database->getConnection();

$controller = new PrendaController($db);

$response = [];

try {
    // Obtener el ID de la prenda a eliminar
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($id) {
        $result = $controller->delete($id);
        
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Prenda eliminada correctamente'
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No se pudo eliminar la prenda'
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
