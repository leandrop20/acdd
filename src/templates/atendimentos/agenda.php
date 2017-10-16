<?php
use controllers\AgendaController;

$agenda = new AgendaController();

$data = $agenda->result;

$idNums = "000000";
const TYPES = [["Cirurgias", "dataCirurgias"], ["Retornos Cirurgias", "dataCiruRetornos"], ["Desobsessões", "dataDesobs"], ["Retornos Desobsessões", "dataDesoRetornos"]];
const MONTHS = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
?>
<link rel="stylesheet" href="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?= $prefixURL; ?>assets/css/print.css" media="print">
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $prefixURL; ?>plugins/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<div class="container">
    <div id="top" class="row">
        <div class="col-md-5">
            <h3>Agenda</h3>
        </div>
        <div class="col-md-5">
        	<div class="input-group h2">
                <form method="POST">
            		<div class="input-group date" id="datepicker">
    				    <input type="text" class="form-control" name="data" required <?php if (isset($data->data)) { echo "value='".$data->data."'"; } ?> />
    				    <span class="input-group-btn">
    				    	<button class="btn btn-primary" type="submit">Ok</button>
    				    </span>
    				</div>
                </form>
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
        <div class="col-md-2">
        <?php
    	if (count($_POST) > 0) {
    	?>
        	<a onclick="window.print()" class="btn btn-primary pull-right h2"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</a>
        <?php } ?>
    	</div>
    </div> <!-- /#top -->
    <hr />
    <?php
    if (count($_POST) > 0) {
    ?>
    <div id="printable" class="row">
    	<div class="table-responsive col-md-12" style="text-align:center;">
    		<?php $date = explode("/", $data->data); ?>
    		<h5 style="border:none;">Agenda de atendimentos para <?= $date[0]." de ".MONTHS[$date[1]-1]." de ".$date[2]; ?></h5>
    	</div>
    	<div id="table" class="table-responsive col-md-12">
	    <?php
	    for ($i=0;$i<count(TYPES);$i++) {
	    ?>
    		<table class="table table-striped" cellspacing="0" cellpadding="0">
    			<thead>
    				<tr>
    					<th style="text-align:center" class="alert-info" colspan="12"><?= TYPES[$i][0]; ?></th>
    				</tr>
    				<tr>
    					<th></th>
    					<th><a href="#" onclick="order('id')">Cód.</a></th>
	    				<th><a href="#" onclick="order('id_assistido')">CIA</a></th>
	    				<th><a href="#" onclick="order('ficha')">FICHA</a></th>
	    				<th><a href="#" onclick="order('nome')">NOME</a></th>
    				</tr>
    			</thead>
    			<tbody>
    			<?php
    			$name = TYPES[$i][1];
    			for ($j=0;$j<$data->$name->num;$j++) {
    			?>
    				<tr>
    					<td><?= ($j+1); ?></td>
    					<td><?= substr($idNums, strlen($data->$name->data[$j]['id']), 6).$data->$name->data[$j]['id']; ?></td>
	    				<td><?= substr($idNums, strlen($data->$name->data[$j]['id_assistido']), 6).$data->$name->data[$j]['id_assistido']; ?></td>
	    				<td>
	    				<?php
	    				$numFicha = substr($idNums, strlen($data->$name->data[$j]['ficha']), 6).$data->$name->data[$j]['ficha'];
	    				if ($numFicha == 0) { echo "-"; } else { echo $numFicha; }
	    				?>
	    				</td>
	    				<td><?= $data->$name->data[$j]['nome']; ?></td>
    				</tr>
    			<?php } ?>
    			</tbody>
    		</table>
    	<?php } ?>
    	</div>
    </div>
    <?php } ?>
</div>
<form id="formPag" method="POST">
    <?php if (isset($_POST['data'])) { echo "<input name='data' type='hidden' value='".$_POST['data']."'>"; } ?>
    <input id="order" name="order" type="hidden" value="id">
</form>
<script>
function order(value)
{
    $("#order").val(value);
    $("#formPag").submit();
}
</script>