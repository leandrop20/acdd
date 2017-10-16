<?php
use controllers\TrabalhadoresController;

$trabalhadores = new TrabalhadoresController();
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>assets/js/maskaras.js"></script>
<?php
const SECTOR_TYPE = array("Administrativo", "Recepção", "Atendimento", "Farmacia", "Cursos", "Técnico");
?>
<div class="container">
	<h3>Cadastrar Trabalhador</h3>
	<form method="post">
		<hr />
		<div class="row">
			<div class="form-group col-md-5">
   				<label for="field1">Nome Completo</label>
   				<input name="nome" type="text" class="form-control" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" id="field1" required>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field2">Data de Nascimento</label>
                <div class="input-group date" id="datepicker">
                    <input name="nascimento" type="text" class="form-control" required>
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
 			<div class="form-group col-md-2">
   				<label for="field3">Telefone</label>
   				<input name="telefone" type="tel" class="form-control" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$" required>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field4">Celular</label>
   				<input name="celular" type="text" class="form-control" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4,5}-?\d{4}$">
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field5">Usuário</label>
   				<input name="usuario" type="text" class="form-control" pattern="[a-zA-Z0-9]{8}" title="apenas letras e números, mínimo 8 caracteres" maxlength="11" id="field5" required>
 			</div>
 			<div class="form-group col-md-3"> 
   				<label for="field6">Senha</label>
          <input name="senha" type="password" class="form-control" pattern=".{6,}" title="mínimo 6 caracteres" maxlength="10" id="field6" required>
 			</div>
      <div class="form-group col-md-3">
          <label for="field7">Confirmar Senha</label>
          <input type="password" class="form-control" onchange="checkPassword(this, 'field6')" pattern=".{6,}" title="mínimo 6 caracteres" maxlength="10" id="field7" required>
      </div>
 			<div class="form-group col-md-2">
   				<label for="field8">Setor</label>
   				<select name="setor" class="form-control" id="field8" required>
   					<option value="">-</option>
   					<?php
   					for ($i = 0; $i < count(SECTOR_TYPE); $i++) {
   					?>
   						<option value="<?= $i; ?>"><?= SECTOR_TYPE[$i]; ?></option>
   					<?php
   					}
   					?>
   				</select>
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field8">E-mail</label>
   				<input name="email" type="email" class="form-control" id="field8">
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