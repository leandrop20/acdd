<?php
use controllers\CursosController;

$cursos = new CursosController();

$data = $cursos->result->data;
?>
<div class="container">
	<h3>Editar Curso</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Nome</label>
   				<input name="nome" type="text" class="form-control" id="field1" value="<?= $data['nome']; ?>" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" required>
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