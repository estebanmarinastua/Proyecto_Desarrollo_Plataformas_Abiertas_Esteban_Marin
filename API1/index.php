<?php
// Incluir la configuración de la base de datos
require_once __DIR__ . '/config/database.php';

// Incluir los controladores
require_once __DIR__ . '/controllers/MarcaController.php';
require_once __DIR__ . '/controllers/PrendaController.php';
require_once __DIR__ . '/controllers/VentaController.php';

// Establecer el tipo de contenido a JSON
header('Content-Type: application/json');

// Crear instancias de los controladores
$marcaController = new MarcaController($pdo);
$prendaController = new PrendaController($pdo);
$ventaController = new VentaController($pdo);

// Obtener el método de la solicitud
$request_method = $_SERVER['REQUEST_METHOD'];

// Función para manejar las respuestas
function sendResponse($statusCode, $message) {
    http_response_code($statusCode);
    echo json_encode(['message' => $message]);
    exit;
}

// Manejar la solicitud según el método
switch ($request_method) {
    case 'GET':
        handleGetRequest();
        break;

    case 'POST':
        handlePostRequest();
        break;

    case 'DELETE':
        handleDeleteRequest();
        break;

    default:
        sendResponse(405, 'Método no permitido');
        break;
}

function handleGetRequest() {
    global $marcaController, $prendaController, $ventaController;

    if (isset($_GET['entity'])) {
        switch ($_GET['entity']) {
            case 'marcas':
                echo $marcaController->getMarcas();
                break;
            case 'prendas':
                echo $prendaController->getPrendas();
                break;
            case 'ventas':
                echo $ventaController->getVentas();
                break;
            default:
                sendResponse(400, 'Entidad no válida');
                break;
        }
    } else {
        sendResponse(400, 'Entidad no especificada');
    }
}

function handlePostRequest() {
    global $marcaController, $prendaController, $ventaController;

    if (isset($_GET['entity'])) {
        $input = json_decode(file_get_contents('php://input'), true); // Leer datos JSON
        switch ($_GET['entity']) {
            case 'marcas':
                $nombre = $input['nombre'] ?? '';
                if (empty($nombre)) {
                    sendResponse(400, 'El nombre de la marca es obligatorio');
                }
                echo $marcaController->createMarca($nombre);
                break;
            case 'prendas':
                $nombre_prenda = $input['nombre_prenda'] ?? '';
                $id_marca = $input['id_marca'] ?? 0;
                $precio = $input['precio'] ?? 0.0;
                $stock = $input['stock'] ?? 0;
                if (empty($nombre_prenda) || $id_marca <= 0 || $precio <= 0 || $stock < 0) {
                    sendResponse(400, 'Faltan parámetros obligatorios o son inválidos');
                }
                echo $prendaController->createPrenda($nombre_prenda, $id_marca, $precio, $stock);
                break;
            case 'ventas':
                $id_prenda = $input['id_prenda'] ?? 0;
                $fecha_venta = $input['fecha_venta'] ?? '';
                $cantidad = $input['cantidad'] ?? 0;
                if ($id_prenda <= 0 || empty($fecha_venta) || $cantidad <= 0) {
                    sendResponse(400, 'Datos de la venta inválidos');
                }
                echo $ventaController->createVenta($id_prenda, $fecha_venta, $cantidad);
                break;
            default:
                sendResponse(400, 'Entidad no válida');
                break;
        }
    } else {
        sendResponse(400, 'Entidad no especificada');
    }
}

function handleDeleteRequest() {
    global $marcaController, $prendaController, $ventaController;

    if (isset($_GET['entity'], $_GET['id'])) {
        $id = intval($_GET['id']); // Asegurarse de que el ID sea un entero válido
        switch ($_GET['entity']) {
            case 'marcas':
                echo $marcaController->deleteMarca($id);
                break;
            case 'prendas':
                echo $prendaController->delete($id);
                break;
            case 'ventas':
                echo $ventaController->delete($id);
                break;
            default:
                sendResponse(400, 'Entidad no válida');
                break;
        }
    } else {
        sendResponse(400, 'Entidad o ID no especificado');
    }
}
?>

