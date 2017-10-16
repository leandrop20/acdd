<?php
use controllers\FarmSaidasController;

$farmSaidas = new FarmSaidasController();

$data = null;
if ($farmSaidas->result) {
  $data = $farmSaidas->result->data;
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
	<h3>Cadastrar Saída</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-3">
   				<label for="field1">Medicamento</label>
          <?php
          if ($ID) {
          ?>
   				<select name="id_medicamento" class="form-control" id="field1" required>
            <option value="<?= $ID; ?>" selected><?= $data['nome']; ?></option>
          </select>
          <?php
          } else if (!$ID && !$data) {
          ?>
          <div class="input-group">
            <select name="id_medicamento" class="form-control" id="field1" required onchange="searchLote('farmacia/lotes', {'id_medicamento':$('#field1 option:selected').val()}, 'field2')">
              <option value="">-</option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalMedicamentos">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          <?php
          } else {
          ?>
          <select name="id_medicamento" class="form-control" id="field1" required>
            <option value="<?= $data['id']; ?>"><?= $data['nome']; ?></option>
          </select>
          <?php
          }
          ?>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field2">Cód. do Lote</label>
          <?php
          if ($ID) { ?>
            <select name="id_lote" class="form-control" id="field2" required onchange="getQtdLote('../farmacia/lotes', {'id':$('#field2 option:selected').val()}, 'field3')">";
          <?php } else { ?>
            <select name="id_lote" class="form-control" id="field2" required onchange="getQtdLote('farmacia/lotes', {'id':$('#field2 option:selected').val()}, 'field3')">";
          <?php }
          ?>          
          <?php
          if (isset($_POST['id_lote'])) {
            echo "<option value='".$_POST['id_lote']."' selected>".$data['idLote']."</option>";
          } else {
            echo "<option value='' selected>-</option>";
          }
          ?>
          </select>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field3">Qtd.</label>
          <?php
          if (isset($_POST['id_lote'])) {
            echo "<input name='quantidade' type='number' min='1' max='".$_POST['quantidade']."' class='form-control' id='field3' required>";
          } else {
            echo "<input name='quantidade' type='number' min='1' max='0' class='form-control' id='field3' required>";
          }
          ?>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field4">Data da Saída</label>
   				<div class="input-group date" id="datepicker">
                    <input name="data_saida" type="text" class="form-control" id="field4" required>
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
            }
            ?>
    		</div>
		</div>
	</form>
</div>
<?php
if ($ID) {
  echo "<script>searchLote('lotes', {'id_medicamento':".$ID."}, 'field2')</script>";
}
?>