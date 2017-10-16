<?php
use controllers\CursAlunosController;

$cursAlunos = new CursAlunosController();

$data = $cursAlunos->result;
?>
<script src="<?= $prefixURL; ?>/assets/js/search.js"></script>
<!-- Modal search Assistido -->
<div class="modal fade" id="modalAssistido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buscar Assistido</h4>
      </div>
      <div class="modal-body">
        <div class="input-group h2">
          <input name="id" class="form-control" id="searchID" type="text" placeholder="Buscar por Cód.">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('../assistidos', {'id':$('#searchID').val()}, 'field1', 'modalAssistido');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('../assistidos', {'nome':$('#searchName').val()}, 'field1', 'modalAssistido');">
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
<!-- Modal search Assistido -->
<div class="container">
	<h3>Cadastrar Aluno</h3>
	<form method="POST">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Nome</label>
          <div class="input-group">
     				<select name="id_assistido" class="form-control" id="field1" required>
              <option value="" selected>-</option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalAssistido">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field2">Curso</label>
   				<select name="id_curso" class="form-control" id="field2" disabled>
   					<option value="<?= $data->idCurso; ?>" selected><?= $data->nomeCurso; ?></option>
   				</select>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field3">Grupo</label>
   				<select name="id_grupo" class="form-control" id="field3" disabled>
   					<option value="<?= $ID; ?>" selected><?= $data->nomeGrupo; ?></option>
   				</select>
          <input name="id_grupo"  type="hidden" value="<?= $ID; ?>">
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field4">Instrutor</label>
   				<select name="id_trabalhador" class="form-control" id="field4" disabled>
   				<option value="<?= $data->idTrabalhador; ?>" selected><?= $data->nomeTrabalhador; ?></option>
   				</select>
 			</div>
		</div>
		<hr />
		<div id="actions" class="row">
			<div class="col-md-12">
      			<button type="submit" class="btn btn-primary">Cadastrar</button>
      			<a href="../index/<?= $ID; ?>" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>