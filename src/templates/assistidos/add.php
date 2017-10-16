<?php
use controllers\AssistidosController;

$assistidos = new AssistidosController();
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>assets/js/maskaras.js"></script>
<?php
const CIVIL_STATUS = array("Solteiro","Casado","Divorciado","Viúvo");

$data = $assistidos->result;
?>
<div class="container">
	<h3>Cadastrar Assistido</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-5">
   				<label for="field1">Nome Completo</label>
   				<input name="nome" type="text" class="form-control" id="field1" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" required>
 			</div>
      <div class="form-group col-md-2">
          <label for="field1">Número da Ficha</label>
          <input name="ficha" type="text" class="form-control" id="field1" pattern="\d*[0-9]" title="Digite apenas números!" maxlength="6">
      </div>
 			<div class="form-group col-md-2">
   				<label for="field2">Data de Nascimento</label>
                <div class="input-group date" id="datepicker">
                    <input name="nascimento" type="text" class="form-control" id="field2" required>
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
 			<div class="form-group col-md-3">
   				<label for="field3">Estado Civil</label>
   				<select name="estado_civil" class="form-control" id="field3" required>
   					<option value="">-</option>
   					<?php
   					for ($i = 0; $i < count(CIVIL_STATUS); $i++) {
   					?>
   						<option value="<?= $i; ?>"><?= CIVIL_STATUS[$i]; ?></option>
   					<?php
   					}
   					?>
   				</select>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field4">Filhos</label>
   				<select name="filhos" class="form-control" id="field4" required>
   					<option value="">-</option>
   					<?php
   					for ($i = 0; $i < 16; $i++) {
   					?>
   						<option value="<?= ($i); ?>"><?= ($i); ?></option>
   					<?php
   					}
   					?>
   				</select>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field5">Nome da Mãe</label>
   				<input name="nome_da_mae" type="text" class="form-control" id="field5" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" required>
 			</div>
      <div class="form-group col-md-3">
          <label for="field7">Cidade</label>
          <select name="id_cidade" class="form-control" id="field7" required>
            <option value="">-</option>
            <?php
            for ($i = 0; $i < $data->num; $i++) {
              echo "<option value='".$data->data[$i]['id']."'>".utf8_encode($data->data[$i]['nome'])."</option>";
            }
            ?>
          </select>
      </div>
 			<div class="form-group col-md-3">
   				<label for="field6">Bairro</label>
   				<input name="bairro" type="text" class="form-control" id="field6" pattern=".{6,}" title="mínimo 6 caracters" maxlength="50" required>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field8">Telefone</label>
   				<input name="telefone" type="text" class="form-control" id="field8" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$">
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field9">Celular</label>
   				<input name="celular" type="text" class="form-control" id="field9" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4,5}-?\d{4}$">
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