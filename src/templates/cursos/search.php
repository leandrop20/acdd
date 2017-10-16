<?php
use controllers\CursosController;

$cursos = new CursosController();

header('Content-Type: application/json');

echo json_encode($cursos->result);
?>