<?php
use controllers\CiruRetornosController;

$ciruRetornos = new CiruRetornosController();

const STATUS = array("Não Efetuada", "Efetuada", "Cancelada");

$data = $ciruRetornos->result;
$idNums = "000000";
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
	<h3>Editar Retorno de Cirurgia</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-2">
   				<label for="field1">Cód. da Cirurgia</label>
   				<input name="id_cirurgia" type="text" class="form-control" id="field1" value="<?= substr($idNums, strlen($data->data['id']), 6).$data->data['id']; ?>" disabled>
 			</div>
			<div class="form-group col-md-4">
   				<label for="field2">Assistido</label>
   				<input name="id_assistido" type="text" class="form-control" id="field2" value="<?= $data->nomeAssistido; ?>" disabled>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field3">Médium</label>
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
 			<div class="form-group col-md-2">
   				<label for="field4">Data do Retorno</label>
          <input name="data_retorno" type="text" class="form-control" id="field4" value="<?= date('d/m/Y', strtotime(str_replace('/', '-', $data->data['data_retorno']))); ?>" disabled>
 			</div>
 			<div class="form-group col-md-4">
 				<label for="field5">Observações</label>
 				<textarea name="obs" maxlength="300" class="form-control" id="field5" style="resize:none;" rows="5"><?= $data->data['obs']; ?></textarea>
 			</div>
 			<div class="form-group col-md-4">
   			<label for="field6">Status</label>
   			<div class="radio">
        <?php for ($i=0;$i<count(STATUS);$i++) {
   				echo "<label class='radio-inline'><input type='radio' name='situacao' value='".$i."' ".($i==$data->data['situacao']?'checked':'').">".STATUS[$i]."</label>";
        } ?>
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