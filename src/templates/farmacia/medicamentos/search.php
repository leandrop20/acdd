<?php
use controllers\FarmMedicamentosController;

$FarmMedicamentos = new FarmMedicamentosController();

header('Content-Type: application/json');

echo json_encode($FarmMedicamentos->result);
?>