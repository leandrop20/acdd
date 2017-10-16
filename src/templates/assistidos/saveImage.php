<?php
use controllers\AssistidosController;

$assistidos = new AssistidosController();

header('Content-Type: application/json');

echo json_encode($assistidos->result);
?>