<?php
use controllers\CursGruposController;

$cursGroupos = new CursGruposController();
?>
<script src="<?= $prefixURL; ?>/assets/js/search.js"></script>
<!-- Modal search Curso -->
<div class="modal fade" id="modalCursos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buscar Curso</h4>
      </div>
      <div class="modal-body">
        <div class="input-group h2">
          <input name="id" class="form-control" id="searchID" type="text" placeholder="Buscar por Cód.">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('cursos', {'id':$('#searchID').val()}, 'field2', 'modalCursos');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('cursos', {'nome':$('#searchName').val()}, 'field2', 'modalCursos');">
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
<!-- Modal search Curso -->
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
            <button class="btn btn-primary" type="submit" onclick="searchInstrutor('trabalhadores', {'id':$('#searchID2').val()}, 'field3', 'modalTrabalhador');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName2" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="searchInstrutor('trabalhadores', {'nome':$('#searchName2').val()}, 'field3', 'modalTrabalhador');">
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
	<h3>Cadastrar Grupo</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Nome</label>
   				<input name="nome" type="text" class="form-control" id="field1" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" required>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field2">Curso</label>
          <div class="input-group">
     				<select name="id_curso" class="form-control" id="field2" required>
     					<option value="">-</option>
     				</select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalCursos">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field3">Instrutor</label>
          <div class="input-group">
     				<select name="id_trabalhador" class="form-control" id="field3" required>
     					<option value="">-</option>
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
      			<button type="submit" class="btn btn-primary">Cadastrar</button>
      			<a href="index" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>