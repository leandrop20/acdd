<?php
use controllers\CursAulasController;

$cursAulas = new CursAulasController();

$data = $cursAulas->result;
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<div class="container">
	<h3>Cadastrar Aula</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-3">
   				<label for="field1">Grupo</label>
   				<select name="id_grupo" class="form-control" id="field1" disabled>
            <option value="<?= $data->idGrupo; ?>" selected><?= $data->nomeGrupo; ?></option>
          </select>
          <input name="id_grupo" value="<?= $data->idGrupo; ?>" type="hidden">
 			</div>
 			<div class="form-group col-md-5">
   				<label for="field2">Nome</label>
   				<input name="nome" maxlength="65" type="text" pattern=".{2,}" title="mínimo 2 characteres" class="form-control" id="field2" required>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field3">Data da Aula</label>
                <div class="input-group date" id="datepicker">
                    <input name="data" type="text" class="form-control" id="field3" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <script>
                	$(function () {
                		$('#datepicker').datepicker({
                			format: "dd/mm/yyyy",
                			language: "pt-BR",
                			todayHighlight: true,
                			autoclose: true
                			// daysOfWeekDisabled: [1, 2, 3, 4]
                		});
            		});
                </script>
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