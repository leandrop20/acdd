<?php
use controllers\AssistidosController;

$assistidos = new AssistidosController();
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>assets/js/maskaras.js"></script>
<script src="<?= $prefixURL; ?>assets/js/webcam.js"></script>
<?php
const CIVIL_STATUS = array("Solteiro","Casado","Divorciado","Viúvo");

$data = $assistidos->result->data;
if (count($_POST) == 0) {$cities = $assistidos->result->cities; }
?>
<!-- Modal Webcam -->
<div id="webcam-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Capturar imagem</h4>
      </div>
      <div id="bodyCapture" class="modal-body" style="justify-content: center; display:flex;">
        <video id="video" width="118" height="157" autoplay></video>
        <canvas id="canvas" width="118" height="157"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button id="btnCapture" type="button" class="btn btn-info" onclick="capture();" style="display:none;">Capturar</button>
        <button id="btnSaveCapture" type="button" class="btn btn-primary" style="display:none;" onclick="saveCapture(<?= $ID ?>, 'assistidos')">Salvar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Webcam -->
<div class="container">
	<h3>Editar Cadastro de Assistido</h3>
	<form method="post">
		<hr />
		<div class="row">
      <div class="col-md-4">
        <?php
        $urlImage = "userDefault.png";
        if ($data['foto'] != "") { $urlImage = "profile/assistidos/".$data['foto']; }
        ?>
        <img class="img-thumbnail" alt="118x157" src="<?= $prefixURL; ?>/assets/images/<?= $urlImage; ?>" data-holder-rendered="true" style="width: 118px; height: 157px;">
        <a class="btn btn-circle-sm btn-primary btn-sm" href="#" onclick="$('#webcam-modal').modal('show');getAccessCam();" style="position:absolute; left:91px; bottom:8px;"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span></a>
      </div>
			<div class="form-group col-md-5">
   				<label for="field1">Nome Completo</label>
   				<input name="nome" type="text" class="form-control" id="field1" value="<?= $data['nome'] ?>" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" required>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field2">Data de Nascimento</label>
                <div class="input-group date" id="datepicker">
                    <input name="nascimento" type="text" class="form-control" value="<?= date('d/m/Y', strtotime(str_replace('/', '-', $data['nascimento']))); ?>" required>
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
   					<?php
   					for ($i = 0; $i < count(CIVIL_STATUS); $i++) {
   					?>
   						<option value="<?= $i; ?>" <?php if ($i == $data['estado_civil']) { echo "selected"; } ?>><?= CIVIL_STATUS[$i]; ?></option>
   					<?php
   					}
   					?>
   				</select>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field4">Filhos</label>
   				<select name="filhos" class="form-control" id="field4" required>
   					<?php
   					for ($i = 0; $i < 16; $i++) {
   					?>
   						<option value="<?= $i; ?>" <?php if ($i == $data['filhos']) { echo "selected"; } ?>><?= $i; ?></option>
   					<?php
   					}
   					?>
   				</select>
 			</div>
 			<div class="form-group col-md-5">
   				<label for="field5">Nome da Mãe</label>
   				<input name="nome_da_mae" type="text" class="form-control" id="field5" value="<?= $data['nome_da_mae'] ?>" pattern=".{6,}" title="mínimo 6 caracters" maxlength="65" required>
 			</div>
      <div class="form-group col-md-3">
          <label for="field7">Cidade</label>
          <select name="id_cidade" class="form-control" id="field7" required>
            <?php
            for ($i = 0;$i<count($cities);$i++) {
              echo "<option value='".$cities[$i]['id']."' ".(($cities[$i]['id'] == $data['id_cidade']) ? "selected" : "" ).">".utf8_encode($cities[$i]['nome'])."</option>";
            }
            ?>
          </select>
      </div>
 			<div class="form-group col-md-4">
   				<label for="field6">Bairro</label>
   				<input name="bairro" type="text" class="form-control" id="field6" value="<?= $data['bairro']; ?>" pattern=".{6,}" title="mínimo 6 caracters" maxlength="50" required>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field8">Telefone</label>
   				<input name="telefone" type="text" class="form-control" id="field8" value="<?= $data['telefone'] ?>" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$">
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field9">Celular</label>
   				<input name="celular" type="text" class="form-control" id="field9" value="<?= $data['celular'] ?>" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4,5}-?\d{4}$">
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