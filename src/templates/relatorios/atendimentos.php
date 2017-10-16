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
            <h3>Relatório - Atendimentos</h3>
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
            <h4>Passes</h4>
        </div>
        <div class="table-responsive col-md-12">
            <span class="col-md-10">Total:</span>
            <span class="col-md-2"><?= $data->totalPasses; ?></span>
        </div>
        <?php
        $list = array(["Cirurgias", "ciru"], ["Retornos Cirurgia", "cire"], ["Desobsessões", "deso"], ["Retornos Desobsessão", "dere"]);
        for ($i = 0; $i < count($list); $i++) {
        ?>
            <div class="table-responsive col-md-12">
                <h4><?= $list[$i][0]; ?></h4>
            </div>
            <div class="table-responsive col-md-12">
                <span class="col-md-10">Total:</span>
                <span class="col-md-2"><?= $data->dataAll[$i]['total']; ?></span>
            </div>
            <div class="table-responsive col-md-12">
                <span class="col-md-10">Efetuadas:</span>
                <span class="col-md-2"><?= $data->dataAll[$i]['efetuadas']; ?></span>
            </div>
            <div class="table-responsive col-md-12">
                <span class="col-md-10">Não Efetuadas:</span>
                <span class="col-md-2"><?= $data->dataAll[$i]['naoEfe']; ?></span>
            </div>
            <div class="table-responsive col-md-12">
                <span class="col-md-10">Canceladas:</span>
                <span class="col-md-2"><?= $data->dataAll[$i]['cancel']; ?></span>
            </div>
        <?php } ?>
    <?php } ?>
    </div>
    <hr />
</div>