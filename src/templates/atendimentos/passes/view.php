<?php
use controllers\PassesController;

$passes = new PassesController();

const STATUS = array("Não Efetuado", "Efetuado");

$data = $passes->result;
$idNums = "000000";
?>
<div class="container">
	<h3>Passe Cód: <?= substr($idNums, strlen($data->data['id']), 6).$data->data['id']; ?></h3>
	<div class="row">
		<div class="col-md-4">
 			<p><strong>Assistido</strong></p>
 			<p><?= $data->nomeAssistido; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Médium</strong></p>
 			<p><?= $data->nomeTrabalhador; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Data do Passe</strong></p>
 			<p><?= date('d/m/Y', strtotime(str_replace('/', '-', $data->data['data_passe']))); ?></p>
		</div>
		<div class="col-md-4 col-sm-3">
 			<p><strong>Observações</strong></p>
 			<p><?= $data->data['obs']; ?></p>
		</div>
		<div class="col-md-4 col-sm-3">
 			<p><strong>Status</strong></p>
 			<p><?= STATUS[$data->data['situacao']]; ?></p>
		</div>
	</div>
	<hr />
	<div id="actions" class="row">
		<div class="col-md-12">
			<a href="../edit/<?= $data->data['id']; ?>" class="btn btn-primary">Editar</a>
	 		<a href="../index" class="btn btn-default">Fechar</a>
		</div>
	</div>
</div>