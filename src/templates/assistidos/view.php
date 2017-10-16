<?php
use controllers\AssistidosController;

$assistidos = new AssistidosController();

const CIVIL_STATUS = array("Solteiro","Casado","Divorciado","Viúvo");

$data = $assistidos->result->data;
$city = $assistidos->result->city;
$idNums = "000000";
?>
<div class="container">
	<h3>Assistido CIA: <?= substr($idNums, strlen($data['id']), 6).$data['id']; ?></h3>
	<div class="row">
		<div class="col-md-4">
		<?php
		$urlImage = "userDefault.png";
		if ($data['foto'] != "") { $urlImage = "profile/assistidos/".$data['foto']; }
		?>
		<img class="img-thumbnail" alt="118x157" src="<?= $prefixURL; ?>/assets/images/<?= $urlImage; ?>" data-holder-rendered="true" style="width: 118px; height: 157px;">
		</div>
		<div class="col-md-4">
 			<p><strong>Nome</strong></p>
 			<p><?= $data['nome']; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Data de Nascimento</strong></p>
 			<p><?= date('d/m/Y', strtotime(str_replace('/', '-', $data['nascimento']))); ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Estado Civil</strong></p>
 			<p><?= CIVIL_STATUS[$data['estado_civil']]; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Filhos</strong></p>
 			<p><?= $data['filhos']; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Nome da Mãe</strong></p>
 			<p><?= $data['nome_da_mae']; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Bairro</strong></p>
 			<p><?= $data['bairro']; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Cidade</strong></p>
 			<p><?= utf8_encode($city); ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Telefone</strong></p>
 			<p><?= $data['telefone']; ?></p>
		</div>
		<div class="col-md-4">
 			<p><strong>Celular</strong></p>
 			<p><?= $data['celular']; ?></p>
		</div>
		<div class="col-md-4">
			<p><strong>Cadastrado em</strong></p>
			<p><?= date('d/m/Y', strtotime(str_replace('/', '-', $data['data_cadastro']))); ?></p>
		</div>
	</div>
	<hr />
	<div id="actions" class="row">
		<div class="col-md-12">
			<a href="../edit/<?= $data['id']; ?>" class="btn btn-primary">Editar</a>
	 		<a href="../index" class="btn btn-default">Fechar</a>
	 		<a onclick="window.print()" class="btn btn-info">Imprimir CIA</a>
	 		<a href="../report/<?= $data['id']; ?>" class="btn btn-default">Relatório</a>
		</div>
	</div>
	<style>
	.card { width: 3.75in; height: 2.25in; border:1px solid #E8E8E8; font-family: Arial,Verdana; color:#6EA4D4; position: absolute; display: inline-block; visibility: hidden; }
	.card-border { margin:0.05in 0in 0in 0.05in; padding:0.05in 0in 0in 0.05in; width: 3.63in; height:2.13in; border:0.02in solid #80CBFF; border-radius:5px; }
	.card-img { width: 90px; height:90px; display: inline-block; }
	.card-title { width:240px; margin-left: 5px; vertical-align: top; text-align: center; font-size: 12px; font-weight: bold; color:#3D85C6; display: inline-block; }
	.card-title div { width: 240px; text-align: center; font-size: 11px; font-weight: normal; color: #6EA4D4; line-height: 1; }
	.card table { width: 336px; margin-top: 10px; line-height: 1.3; font-size: 12px; }
	@media print {
		body * { visibility: hidden;margin: 0; padding: 0; left:0; top:0; }
		#card, #card * { visibility: visible; float: none; }
		.card-border { margin: 0.03in; }
		.card table { margin-top: 5px; }
	}
	</style>
	<div id="card" class="card">
		<div class="card-border">
			<img class="card-img" src="<?= $prefixURL; ?>assets/images/logoLogin.png">
			<div class="card-title">
				Templo Ecumênico e Assistencial<br>"A Caminho de Deus"<br><br>
				<div>End: Est. de Arujá a Santa Isabel, km 49,5<br>SantaIsabel - SP<br>www.acaminhodedeus.org</div>
			</div>
			<table>
				<tr>
					<td colspan="3" style="text-align:right; font-weight: bold;">CIA: <?= substr($idNums, strlen($data['id']), 6).$data['id']; ?></td>
				</tr>
				<tr>
					<td colspan="3">Nome: <?= $data['nome']; ?></td>
				</tr>
				<tr>
					<td colspan="1">Est. Civil: <?= CIVIL_STATUS[$data['estado_civil']]; ?></td>
					<td colspan="2">Filhos: <?= $data['filhos']; ?></td>
				</tr>
				<tr>
					<td colspan="3">End.: <?= $data['bairro']; ?>, <?= utf8_encode($city); ?> - SP</td>
				</tr>
				<tr>
					<td colspan="3">Nome da Mãe: <?= $data['nome_da_mae']; ?></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;">Data de Cadastro: <?= date('d/m/Y', strtotime(str_replace('/', '-', $data['data_cadastro']))); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>