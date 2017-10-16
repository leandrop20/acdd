<?php
use controllers\CursAlunosController;

$cursAlunos = new CursAlunosController();

$data = $cursAlunos->result;

const STATUS_CURSE = array("Reprovado", "Aprovado", "Desistente", "Cursando");
?>
<div class="container">
	<h3>Editar Aluno</h3>
	<form method="POST">
		<hr />
		<div class="row">
			<div class="form-group col-md-4">
   				<label for="field1">Nome</label>
   				<select id="id_assistido" class="form-control" id="field1" disabled>
                  <option value="<?= $data['id_assistido']; ?>" selected><?= $data['nomeAssistido']; ?></option>
               </select>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field2">Curso</label>
   				<select name="id_curso" class="form-control" id="field2" disabled>
                  <option value="<?= $data['idCurso']; ?>"><?= $data['nomeCurso']; ?></option>
               </select>
 			</div>
 			<div class="form-group col-md-2">
   				<label for="field3">Grupo</label>
   				<select class="form-control" id="field3" disabled>
                  <option value="<?= $data['id_grupo']; ?>"><?= $data['nomeGrupo']; ?></option>
               </select>
               <input name="id_grupo" type="hidden" value="<?= $data['id_grupo']; ?>">
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field4">Instrutor</label>
   				<select name="id_trabalhador" class="form-control" id="field4" disabled>
               <option value="<?= $data['idTrabalhador']; ?>" selected><?= $data['nomeTrabalhador']; ?></option>
               </select>
 			</div>
 			<div class="form-group col-md-3">
   				<label for="field5">Situação</label>
               <select name="situacao" class="form-control" id="field5">
                  <?php
                  for ($i = 0; $i < count(STATUS_CURSE); $i++) {
                     echo "<option value='".$i."' ".($i == $data['situacao']?'selected':'').">".STATUS_CURSE[$i]."</option>";
                  }
                  ?>
               </select>
 			</div>
		</div>
		<hr />
		<div id="actions" class="row">
			<div class="col-md-12">
      			<button type="submit" class="btn btn-primary">Salvar Alterações</button>
      			<a href="../index/<?= $data['id_grupo']; ?>" class="btn btn-default">Cancelar</a>
    		</div>
		</div>
	</form>
</div>