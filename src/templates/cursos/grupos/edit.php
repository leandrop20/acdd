<?php
use controllers\CursGruposController;

$cursGroupos = new CursGruposController();

$data = $cursGroupos->result;
?>
<script src="<?= $prefixURL; ?>/assets/js/search.js"></script>
<!-- Modal search Medium -->
<div class="modal fade" id="modalTrabalhador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buscar Trabalhador</h4>
      </div>
      <div class="modal-body">
        <div class="input-group h2">
          <input name="id" class="form-control" id="searchID2" type="text" placeholder="Buscar por CIT">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="searchInstrutor('../trabalhadores', {'id':$('#searchID2').val()}, 'field3', 'modalTrabalhador');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName2" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="searchInstrutor('../trabalhadores', {'nome':$('#searchName2').val()}, 'field3', 'modalTrabalhador');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal search Medium -->
<div class="container">
	<h3>Editar Grupo</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Nome</label>
   				<input name="nome" type="text" class="form-control" id="field1" value="<?= $data->data['nome']; ?>" required>
 			</div>
 			<div class="form-group col-md-4">
 				<label for="field2">Curso</label>
        <select name="id_assistido" class="form-control" id="field2" disabled>
          <option value=""><?= $data->nomeCurso; ?></option>
        </select>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field3">Instrutor</label>
          <div class="input-group">
     				<select name="id_trabalhador" class="form-control" id="field3" required>
     					<option value="<?= $data->data['id_trabalhador']; ?>"><?= $data->nomeTrabalhador; ?></option>
     				</select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalTrabalhador">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
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