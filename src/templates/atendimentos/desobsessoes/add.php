<?php
use controllers\DesobsessoesController;

$desobsessoes = new DesobsessoesController();
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>/assets/js/search.js"></script>
<?php
const STATUS = array("Não Efetuada", "Efetuada", "Cancelada");
?>
<!-- Modal search Assistido -->
<div class="modal fade" id="modalAssistidos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buscar Assistido</h4>
      </div>
      <div class="modal-body">
        <div class="input-group h2">
          <input name="id" class="form-control" id="searchID" type="text" placeholder="Buscar por CIA">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('assistidos', {'id':$('#searchID').val()}, 'field1', 'modalAssistidos');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('assistidos', {'nome':$('#searchName').val()}, 'field1', 'modalAssistidos');">
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
            <button class="btn btn-primary" type="submit" onclick="search('trabalhadores', {'id':$('#searchID2').val()}, 'field2', 'modalTrabalhador');">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        <div class="input-group h2">
          <input name="nome" class="form-control" id="searchName2" type="text" placeholder="Buscar por Nome">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" onclick="search('trabalhadores', {'nome':$('#searchName2').val()}, 'field2', 'modalTrabalhador');">
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
	<h3>Cadastrar Desobsessão</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Assistido</label>
   				<div class="input-group">
            <select name="id_assistido" class="form-control" id="field1" required>
              <option value="" selected>-</option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalAssistidos">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field2">Médium</label>
   				<div class="input-group">
            <select name="id_trabalhador" class="form-control" id="field2" required>
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
   				<label for="field3">Data da Desobsessão</label>
                <div class="input-group date" id="datepicker">
                    <input name="data_desobsessao" type="text" class="form-control" id="field3" required>
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
 				<label for="field4">Observações</label>
 				<textarea name="obs" maxlength="300" class="form-control" id="field4" style="resize:none;" rows="5"></textarea>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field5">Status</label>
   				<div class="radio">
   					<label class="radio-inline"><input type="radio" name="situacao" value="0" checked><?= STATUS[0]; ?></label>
            <label class="radio-inline"><input type="radio" name="situacao" value="1"><?= STATUS[1]; ?></label>
					  <label class="radio-inline"><input type="radio" name="situacao" value="2"><?= STATUS[2]; ?></label>
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