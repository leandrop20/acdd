<?php
use controllers\CiruRetornosController;

$ciruRetornos = new CiruRetornosController();
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>/assets/js/search.js"></script>
<?php
const STATUS = array("Não Efetuada", "Efetuada", "Cancelada");

$data = $ciruRetornos->result;
$idNums = "000000";
?>
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
          <input name="id" class="form-control" id="searchID" type="text" placeholder="Buscar por CIT">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('../../trabalhadores', {'id':$('#searchID').val()}, 'field3', 'modalTrabalhador');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('../../trabalhadores', {'nome':$('#searchName').val()}, 'field3', 'modalTrabalhador');">
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
	<h3>Cadastrar Retorno de Cirurgia</h3>
	<form method="post">
		<hr />
		<div class="row">
      <div class="form-group col-md-2">
          <label for="field1">Cód. da Cirurgia</label>
          <select class="form-control" id="field1" disabled>
            <option value="<?= $data->data['id']; ?>"><?= substr($idNums, strlen($data->data['id']), 6).$data->data['id']; ?></option>
          </select>
          <input name="id_cirurgia" type="hidden" value="<?= $data->data['id']; ?>">
      </div>
			<div class="form-group col-md-4">
   				<label for="field2">Assistido</label>
          <select class="form-control" id="field2" disabled>
            <option value="<?= $data->data['id_assistido']; ?>"><?= $data->nomeAssistido; ?></option>
          </select>
          <input name="id_assistido" type="hidden" value="<?= $data->data['id_assistido']; ?>">
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field3">Médium</label>
   				<div class="input-group">
            <select name="id_trabalhador" class="form-control" id="field3" required>
              <option value="" selected>-</option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalTrabalhador">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field4">Data do Retorno</label>
                <div class="input-group date" id="datepicker">
                    <input name="data_retorno" type="text" class="form-control" id="field4" required>
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
 			<div class="form-group col-md-4">
 				<label for="field5">Observações</label>
 				<textarea name="obs" maxlength="300" class="form-control" id="field5" style="resize:none;" rows="5"></textarea>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field6">Status</label>
   				<div class="radio">
            <?php for ($i=0;$i<count(STATUS);$i++) {
   					  echo "<label class='radio-inline'><input type='radio' name='situacao' value='".$i."' ".($i==0?'checked':'').">".STATUS[$i]."</label>";
            } ?>
				</div>
 			</div>
		</div>
		<hr />
		<div id="actions" class="row">
			<div class="col-md-12">
      			<button type="submit" class="btn btn-primary">Cadastrar</button>
      			<a href="../index" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>