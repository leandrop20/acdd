<?php
use controllers\FarmMedicamentosController;

$farmMedicamentos = new FarmMedicamentosController();

$data = $farmMedicamentos->result->data;
?>
<div class="container">
	<h3>Editar Cadastro de Medicamento</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-5">
   				<label for="field1">Nome</label>
   				<input name="nome" type="text" pattern=".{3,}" title="Mínimo 3 caracteres" maxlength="100" class="form-control" id="field1" value="<?= $data['nome']; ?>" required>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field2">Qtd. mínima</label>
   				<input name="qtd_minima" type="text" maxlength="4" pattern="\d*[0-9]" title="Digite apenas números!" class="form-control" id="field2" value="<?= $data['qtd_minima']; ?>" required>
 			</div>
		</div>
		<hr />
		<div id="actions" class="row">
			<div class="col-md-12">
      			<button type="submit" class="btn btn-primary">Salvar Alterações</button>
      			<a href="../index" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>