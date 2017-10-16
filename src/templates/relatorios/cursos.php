<?php
use controllers\RelatoriosController;

$relatorios = new RelatoriosController();

$data = $relatorios->result;
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<div class="container">
    <div id="top" class="row">
        <div class="col-md-4">
            <h3>Relatório - Cursos</h3>
        </div>
        <div class="col-md-5">
        	<div class="input-group h2">
                <form method="POST">
            		<div class="input-daterange input-group" id="datepicker">
            			<span class="input-group-addon">De: </span>
    				    <input type="text" class="form-control" name="start" required <?php if (isset($data->dataInit)) { echo "value='".$data->dataInit."'"; } ?> />
    				    <span class="input-group-addon">Até: </span>
    				    <input type="text" class="form-control" name="end" required <?php if (isset($data->dataEnd)) { echo "value='".$data->dataEnd."'"; } ?> />
    				    <span class="input-group-btn">
    				    	<button class="btn btn-primary" type="submit">Gerar</button>
                        </span>
    				</div>
                </form>
        	</div>
        	<script>
                $(function () {
                    $('.input-daterange').datepicker({
                        format: "dd/mm/yyyy",
                        language: "pt-BR",
                        todayHighlight: true,
                        autoclose: true
                        // daysOfWeekDisabled: [1, 2, 3, 4]
                    });
                });
            </script>
        </div>
    </div> <!-- /#top -->
    <hr />
    <div class="row">
    <?php
    if (count($_POST) > 0) {
    ?>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Total de Cursos:</span>
            <span class="col-md-2"><?= $data->totalCursos; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <h4>Grupos</h4>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Total:</span>
            <span class="col-md-2"><?= $data->totalGrupos; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Finalizados:</span>
            <span class="col-md-2"><?= $data->gruposFinalizados; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Em andamento:</span>
            <span class="col-md-2"><?= $data->gruposEmAndamento; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <h4>Aulas</h4>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Total:</span>
            <span class="col-md-2"><?= $data->totalAulas; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <h4>Alunos</h4>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Total:</span>
            <span class="col-md-2"><?= $data->totalAlunos; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Aprovados:</span>
            <span class="col-md-2"><?= $data->alunosAprovados; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Reprovados:</span>
            <span class="col-md-2"><?= $data->alunosReprovados; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Cursando:</span>
            <span class="col-md-2"><?= $data->alunosCursando; ?></span>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Desistentes:</span>
            <span class="col-md-2"><?= $data->alunosDesistentes; ?></span>
        </div>
    <?php
    }
    ?>
    </div>
    <hr />
</div>