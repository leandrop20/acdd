<?php
use controllers\FarmLotesController;

$farmLotes = new FarmLotesController();

header('Content-Type: application/json');

echo json_encode($farmLotes->result);
?>