<?php
use controllers\TrabalhadoresController;

$trabalhadores = new TrabalhadoresController();

header('Content-Type: application/json');

echo json_encode($trabalhadores->result);
?>