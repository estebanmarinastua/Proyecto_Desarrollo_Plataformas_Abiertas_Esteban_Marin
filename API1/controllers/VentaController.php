<?php
require_once __DIR__ . '/../models/Venta.php';

class VentaController {
    private $venta;

    public function __construct($db) {
        $this->venta = new Venta($db);
    }

    public function getVentas() {
        return json_encode($this->venta->getAll());
    }

    public function createVenta($id_prenda, $fecha_venta, $cantidad) {
        if ($this->venta->create($id_prenda, $fecha_venta, $cantidad)) {
            return json_encode(['message' => 'Venta creada con éxito']);
        } else {
            return json_encode(['message' => 'Error al crear la venta']);
        }
    }
}
?>
