<?php
use controllers\AssistidosController;

$assistidos = new AssistidosController();

$data = $assistidos->result;
?>
<div class="container">
    <div id="top" class="row">
        <div class="col-md-6">
            <h3>Relatório - <?= $data->nome; ?></h3>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Presenças:</span>
            <span class="col-md-2"><?= $data->totalPresencas; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Passes:</span>
            <span class="col-md-2"><?= $data->totalPasses; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Cirurgias:</span>
            <span class="col-md-2"><?= $data->totalCirurgias; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Retornos Cirurgias:</span>
            <span class="col-md-2"><?= $data->totalCiruRetornos; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Desobsessões:</span>
            <span class="col-md-2"><?= $data->totalDesob; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Retornos Desobsessões:</span>
            <span class="col-md-2"><?= $data->totalDesoRetornos; ?></span>
        </div>
    </div>
</div>