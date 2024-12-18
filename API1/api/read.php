<?php
require_once '../config/database.php';
require_once '../controllers/PrendaController.php';

$database = new Database();
$db = $database->getConnection();

$controller = new PrendaController($db);
$records = $controller->read();

header('Content-Type: application/json');
echo json_encode($records);
?>
