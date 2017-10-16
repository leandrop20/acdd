<?php
use controllers\FarmLotesController;

$farmLotes = new FarmLotesController();

$data = $farmLotes->result->data;
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<div class="container">
	<h3>Editar Lote</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-3">
   				<label for="field1">Medicamento</label>
   				<input name="id_medicamento" type="text" class="form-control" id="field1" value="<?= $data['nomeMedicamento'] ?>" disabled>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field2">Qtd.</label>
   				<input name="quantidade" type="text" class="form-control" id="field2" value="<?= $data['quantidade']; ?>" disabled>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field3">Data de Validade</label>
   				<div class="input-group date" id="datepicker">
                    <input name="validade" type="text" class="form-control" id="field3" value="<?= date('d/m/Y', strtotime(str_replace('/', '-', $data['validade']))); ?>" required>
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
      			<button type="submit" class="btn btn-primary">Salvar Alterações</button>
      			<a href="../index" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>