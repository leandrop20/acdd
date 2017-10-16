<?php
use controllers\TrabalhadoresController;

$trabalhadores = new TrabalhadoresController();
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?= $prefixURL; ?>assets/js/maskaras.js"></script>
<script src="<?= $prefixURL; ?>assets/js/webcam.js"></script>
<?php
const SECTOR_TYPE = array("Administrativo", "Recepção", "Atendimento", "Farmacia", "Cursos", "Técnico");

$data = $trabalhadores->result;
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
        <button id="btnSaveCapture" type="button" class="btn btn-primary" style="display:none;" onclick="saveCapture(<?= $ID ?>, 'trabalhadores')">Salvar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Webcam -->
<div class="container">
	<h3>Editar Cadastro do Trabalhador</h3>
	<form method="post">
		<hr />
		<div class="row">
      <div class="col-md-4">
        <?php
        $urlImage = "userDefault.png";
        if ($data['foto'] != "") { $urlImage = "profile/trabalhadores/".$data['foto']; }
        ?>
        <img class="img-thumbnail" alt="118x157" src="<?= $prefixURL; ?>/assets/images/<?= $urlImage; ?>" data-holder-rendered="true" style="width: 118px; height: 157px;">
        <a class="btn btn-circle-sm btn-primary btn-sm" href="#" onclick="$('#webcam-modal').modal('show');getAccessCam();" style="position:absolute; left:91px; bottom:8px;"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span></a>
      </div>
			<div class="form-group col-md-5">
   				<label for="field1">Nome Completo</label>
   				<input name="nome" type="text" class="form-control" id="field1" value="<?= $data['nome']; ?>" required>
 			</div>
 			<div class="form-group col-md-3">
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
 			<div class="form-group col-md-2">
   				<label for="field3">Telefone</label>
   				<input name="telefone" type="text" class="form-control" id="field3" value="<?= $data['telefone']; ?>" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$" required>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field4">Celular</label>
   				<input name="celular" type="text" class="form-control" id="field4" value="<?= $data['celular']; ?>" onkeyup="maskTel(this)" maxlength="15" pattern="^\(?\d{2}\)?[\s-]?[\s9]?\d{4,5}-?\d{4}$">
 			</div>
 			<div class="form-group col-md-4">
   				<label for="field5">Usuário</label>
   				<input type="text" class="form-control" id="field5" value="<?= $data['usuario']; ?>" disabled>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field8">Setor</label>
          <?php if ($auth->getAuth()->setor == 0) { ?>
   				<select name="setor" class="form-control" id="field6">
          <?php } else { ?>
          <select class="form-control" id="field6" disabled>
   				<?php
          }
   					for ($i = 0; $i < count(SECTOR_TYPE); $i++) {
   					?>
   						<option value="<?= $i; ?>" <?php if ($i == $data['setor']) { echo "selected"; } ?>><?= SECTOR_TYPE[$i]; ?></option>
   					<?php
   					}
   					?>
   				</select>
 			</div>
      <div class="form-group col-md-3" id="password">
          <label for="field7">Nova Senha</label>
          <input type="password" class="form-control" onchange="checkPasswordEdit(this, 'field8')" pattern=".{6,}" title="mínimo 6 caracteres" maxlength="10" id="field7">
      </div>
      <div class="form-group col-md-3" id="passwordConfirm">
          <label for="field8">Confirmar Senha</label>
          <input type="password" class="form-control" onchange="checkPassword(this, 'field7')" pattern=".{6,}" title="mínimo 6 caracteres" maxlength="10" id="field8">
      </div>
 			<div id="boxEmail" class="form-group col-md-4">
   				<label for="field9">E-mail</label>
   				<input name="email" type="email" class="form-control" id="field9" value="<?= $data['email']; ?>">
 			</div>
		</div>
		<hr />
		<div id="actions" class="row">
			<div class="col-md-12">
            <a id="btnPassword" class="btn btn-info" onclick="showPasswordEdit()"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Trocar Senha</a>
      			<button type="submit" class="btn btn-primary">Salvar Alterações</button>
      			<a href="../index" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>
<script>
function showPasswordEdit()
{
  $('#password').show();
  $('#field7').attr("required", true);
  $('#field7').attr("name", "senha");
  $('#passwordConfirm').show();
  $('#btnPassword').hide();
}
function hidePasswordEdit()
{
  $('#password').hide();
  $('#passwordConfirm').hide();
}
hidePasswordEdit();
</script>