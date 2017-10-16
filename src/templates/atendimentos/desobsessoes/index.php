<?php
use controllers\DesobsessoesController;

$desobsessoes = new DesobsessoesController();

$data = $desobsessoes->result;
$idNums = "000000";
?>
<!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Excluir Cadastro</h4>
            </div>
            <div class="modal-body">Deseja realmente excluir este cadastro?</div>
            <div class="modal-footer">
                <input id="ID" name="ID" type="hidden" value="">
                <button type="button" class="btn btn-primary" onclick="window.location = 'delete\/'+$('#ID').val();">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<div id="top" class="row">
 		<div class="col-md-2">
        	<h3>Desobsessões</h3>
    	</div>
    	<div class="col-md-2">
            <form method="POST">
                <div class="input-group h2">
                    <input name="id" class="form-control" id="search" type="text" placeholder="Buscar por Cód." pattern="[0-9]+" title="apenas números!" maxlength="10" required>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <form method="POST">
                <div class="input-group h2">
                    <input name="id_assistido" class="form-control" id="search" type="text" placeholder="Buscar por Cód. do Assistido" pattern="[0-9]+" title="apenas números!" maxlength="10" required>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <form method="POST">
                <div class="input-group h2">
                    <input name="id_trabalhador" class="form-control" id="search" type="text" placeholder="Buscar por Cód. do Médium" pattern="[0-9]+" title="apenas números!" maxlength="10" required>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-2">
            <a href="add" class="btn btn-primary pull-right h2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo Cadastro</a>
        </div>
    </div> <!-- /#top -->
    <hr />
    <div id="list" class="row">
    	<div class="table-responsive col-md-12">
    		<table class="table table-striped" cellspacing="0" cellpadding="0">
            	<thead>
                	<tr>
                		<th><a href="#" onclick="order('id')">Cód.</a></th>
                        <th><a href="#" onclick="order('nomeAssistido')">Assistido</a></th>
                        <th><a href="#" onclick="order('nomeTrabalhador')">Médium</a></th>
                        <th><a href="#" onclick="order('data_desobsessao')">Data da Desobsessão</a></th>
                		<th class="actions">Ações</th>
                	</tr>
                </thead>
                <tbody>
	    			<?php for ($i = 0; $i < $data->num; $i++) { ?>
	    			<tr>
	    				<td><?= substr($idNums, strlen($data->data[$i]['id']), 6).$data->data[$i]['id']; ?></td>
                        <td><?= $data->data[$i]['nomeAssistido']; ?></td>
                        <td><?= $data->data[$i]['nomeTrabalhador']; ?></td>
                        <td><?= date('d/m/Y', strtotime(str_replace('/', '-', $data->data[$i]['data_desobsessao']))); ?></td>
	    				<td class="actions">
	    					<a class="btn btn-success btn-xs" href="view/<?= $data->data[$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
	    					<a class="btn btn-warning btn-xs" href="edit/<?= $data->data[$i]['id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
	    					<a class="btn btn-danger btn-xs"  href="#" data-toggle="modal" onclick="$('#ID').val('<?= $data->data[$i]['id']; ?>'); $('#delete-modal').modal('show');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            <a class="btn btn-primary btn-xs" href="retornos/add/<?= $data->data[$i]['id']; ?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Retorno</a>
	    				</td>
	    			</tr>
	    			<?php } ?>
	    		</tbody>
            </table>
        </div>
    </div> <!-- /#list -->
    <div id="bottom" class="row">
     	<div class="col-md-12 text-center">
     		<ul class="pagination">
     			<?php
                $currentPag = 1;
                if (isset($_POST['pag'])) { $currentPag = $_POST['pag']; }
                $order = "id";
                if (isset($_POST['order'])) { $order = $_POST['order']; }
                $nPags = ceil($data->nTotal/$data->limit);
                $maxBtns = 3;
                
                if ($currentPag>1) {
                    echo "<li><a style='cursor:pointer' onclick='getPag(".($currentPag-1).")'>&lt; Anterior</a></li>";
                } else {
                    echo "<li class='disabled btn'><a>&lt; Anterior</a></li>";
                }
                for ($i=$currentPag-$maxBtns;$i<=$currentPag-1;$i++) {
                    if (!($i<=0)) {
                        echo "<li><a style='cursor:pointer' onclick='getPag(".$i.")'>".$i."</a></li>";
                    }
                }
                echo "<li class='disabled btn'><a>".$i."</a></li>";
                for ($i=$currentPag+1;$i<=$currentPag+$maxBtns;$i++) {
                    if (!($i>$nPags)) {
                        echo "<li><a style='cursor:pointer' onclick='getPag(".$i.")'>".$i."</a></li>";
                    }
                }
                if ($currentPag-$nPags) {
                    echo "<li class='next'><a style='cursor:pointer' rel='next' onclick='getPag(".($currentPag+1).")'>Próximo &gt;</a></li>";
                } else {
                    echo "<li class='disabled btn'><a rel='next'>Próximo &gt;</a></li>";
                }
                ?>

                <form id="formPag" method="POST">
                    <?php if (isset($_POST['id'])) { echo "<input name='id' type='hidden' value='".$_POST['id']."'>"; } ?>
                    <?php if (isset($_POST['id_assistido'])) { echo "<input name='id_assistido' type='hidden' value='".$_POST['id_assistido']."'>"; } ?>
                    <?php if (isset($_POST['id_trabalhador'])) { echo "<input name='id_trabalhador' type='hidden' value='".$_POST['id_trabalhador']."'>"; } ?>
                    <input id="pag" name="pag" type="hidden" value="<?= $currentPag; ?>">
                    <input id="order" name="order" type="hidden" value="<?= $order; ?>">
                </form>
                <script>
                function getPag(id)
                {
                    $("#pag").val(id);
                    $("#formPag").submit();
                }
                function order(value)
                {
                    $("#order").val(value);
                    $("#formPag").submit();
                }
                </script>
     		</ul>
     	</div>
    </div> <!-- /#bottom -->
</div>