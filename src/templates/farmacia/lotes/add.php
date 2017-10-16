<?php
use controllers\FarmLotesController;

$farmLotes = new FarmLotesController();

if ($farmLotes->result) {
  $data = $farmLotes->result->data;
}
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>/assets/js/search.js"></script>
<!-- Modal search Medicamento -->
<div class="modal fade" id="modalMedicamentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buscar Medicamento</h4>
      </div>
      <div class="modal-body">
        <div class="input-group h2">
          <input name="id" class="form-control" id="searchID" type="text" placeholder="Buscar por Código">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('farmacia/medicamentos', {'id':$('#searchID').val()}, 'field1', 'modalMedicamentos');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('farmacia/medicamentos', {'nome':$('#searchName').val()}, 'field1', 'modalMedicamentos');">
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
<!-- Modal search Medicamento -->
<div class="container">
	<h3>Cadastrar Lote</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-3">
   				<label for="field1">Medicamento</label>
          <?php if (isset($ID)){ ?>
       			<select name="id_medicamento" class="form-control" id="field1" required>
              <option value="<?= $ID; ?>" selected><?= $data['nome']; ?></option>
            </select>
          <?php } else { ?>
            <div class="input-group">
              <select name="id_medicamento" class="form-control" id="field1" required>
                <option value="" selected>-</option>
              </select>
              <span class="input-group-btn">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalMedicamentos">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
            </div>
          <?php } ?>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field2">Qtd.</label>
   				<input name="quantidade" type="text" maxlength="5" pattern="\d*[0-9]" title="Digite apenas números!" class="form-control" id="field2" required>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field3">Data de Validade</label>
   				<div class="input-group date" id="datepicker">
                    <input name="validade" type="text" class="form-control" id="field3" required>
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
            <?php if ($ID) {
      			  echo "<a href='../index' class='btn btn-default'>Cancelar</a>";
            } else {
              echo "<a href='index' class='btn btn-default'>Cancelar</a>";
            } ?>
    		</div>
		</div>
	</form>
</div>