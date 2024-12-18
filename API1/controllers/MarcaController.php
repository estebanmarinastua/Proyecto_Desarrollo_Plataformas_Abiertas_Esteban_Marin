<?php
require_once __DIR__ . '/../models/Marca.php';

class MarcaController {
    private $marca;

    public function __construct($db) {
        $this->marca = new Marca($db);
    }

    public function getMarcas() {
        return json_encode($this->marca->getAll());
    }

    public function createMarca($nombre) {
        if ($this->marca->create($nombre)) {
            return json_encode(['message' => 'Marca creada con éxito']);
        } else {
            return json_encode(['message' => 'Error al crear la marca']);
        }
    }
}
?>
