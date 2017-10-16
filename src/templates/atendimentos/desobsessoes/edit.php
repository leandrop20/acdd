<?php
use controllers\DesobsessoesController;

$desobsessoes = new DesobsessoesController();

const STATUS = array("Não Efetuada", "Efetuada", "Cancelada");

$data = $desobsessoes->result;
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
          <input name="id" class="form-control" id="searchID2" type="text" placeholder="Buscar por CIT">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('../trabalhadores', {'id':$('#searchID2').val()}, 'field2', 'modalTrabalhador');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName2" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('../trabalhadores', {'nome':$('#searchName2').val()}, 'field2', 'modalTrabalhador');">
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
	<h3>Editar Cadastro de Desobsessão</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Assistido</label>
   				<select name="id_assistido" class="form-control" id="field1" disabled>
   					<option value=""><?= $data->nomeAssistido; ?></option>
   				</select>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field2">Médium</label>
   				<div class="input-group">
            <select name="id_trabalhador" class="form-control" id="field2" required>
              <option value="<?= $data->data['id_trabalhador']; ?>" selected><?= $data->nomeTrabalhador; ?></option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalTrabalhador">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field3">Data da Desobsessão</label>
          <input name="data_desobsessao" type="text" class="form-control" id="field3" value="<?= date('d/m/Y', strtotime(str_replace('/', '-', $data->data['data_desobsessao']))); ?>" disabled>
 			</div>
 			<div class="form-group col-md-4">
 				<label for="field4">Observações</label>
 				<textarea name="obs" maxlength="300" class="form-control" id="field4" style="resize:none;" rows="5"><?= $data->data['obs']; ?></textarea>
 			</div>
 			<div class="form-group col-md-4">
   			<label for="field5">Status</label>
   			<div class="radio">
          <?php
          for ($i=0;$i<count(STATUS);$i++) {
            echo "<label class='radio-inline'><input type='radio' name='situacao' value='".$i."' ".($i==$data->data['situacao']?'checked':'').">".STATUS[$i]."</label>";
          }
          ?>
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