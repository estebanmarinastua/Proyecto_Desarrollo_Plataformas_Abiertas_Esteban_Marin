<?php
require_once '../models/Prenda.php';

class PrendaController {
    private $prendaModel;

    public function __construct($db) {
        $this->prendaModel = new Prenda($db);
    }

    public function create($nombre_prenda, $id_marca, $precio, $stock) {
        // Llama al método create del modelo Prenda
        return $this->prendaModel->create($nombre_prenda, $id_marca, $precio, $stock);
    }

    public function read() {
        // Llama al método getAll del modelo Prenda
        return $this->prendaModel->getAll();
    }

    public function update($id, $nombre_prenda, $id_marca, $precio, $stock) {
        // Llama al método update del modelo Prenda
        return $this->prendaModel->update($id, $nombre_prenda, $id_marca, $precio, $stock);
    }

    public function delete($id) {
        // Asegúrate de que el método delete en el modelo Prenda esté preparado para recibir un ID
        return $this->prendaModel->delete($id);
    }

    public function getPrendas() {
        // Devuelve las prendas en formato JSON
        return json_encode($this->prendaModel->getAll());
    }
}
?>
