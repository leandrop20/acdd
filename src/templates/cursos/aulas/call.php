<?php
use controllers\CursAulasController;

$cursAulas = new CursAulasController();

$data = $cursAulas->result;
?>
<div class="container">
    <div id="top" class="row">
        <div class="col-md-7">
            <h3>Chamada -</h3><h4><?= $data->nomeCurso; ?> - <?= $data->nomeGrupo; ?> - <?= $data->aula['nome']; ?> - <td><?= date('d/m/Y', strtotime(str_replace('/', '-', $data->aula['data']))); ?></td></h4>
        </div>
    </div> <!-- /#top -->
    <hr />
    <div id="list" class="row">
    	<div class="table-responsive col-md-12">
        	<table class="table table-striped" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                    	<th>Nome</th>
                    	<th class="actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < $data->alunos->num; $i++) { ?>
                    <tr>
                    	<td><?= $data->alunos->data[$i]['nome']; ?></td>
                    	<td class="actions">
                            <form method="POST">
                                <input name="id_aula" type="hidden" value="<?= $data->aula['id']; ?>">
                                <input name="id_aluno" type="hidden" value="<?= $data->alunos->data[$i]['id']; ?>">
                                <input name="data" type="hidden" value="<?= $data->aula['data']; ?>">
                    		<?php
                            if ($cursAulas->checkPresence($data->aula['id'], $data->alunos->data[$i]['id'])) {
                                echo "<button type='submit' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Presença</button>";
                            } else {
                                echo "<button type='submit' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Presença</button>";
                            }
                            ?>
                            </form>
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
                $nPags = ceil($data->alunos->nTotal/$data->alunos->limit);
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
                    <input id="pag" name="pag" type="hidden" value="">
                </form>
                <script>
                function getPag(id)
                {
                    $("#pag").val(id);
                    $("#formPag").submit();
                }
                </script>
     		</ul>
     	</div>
    </div> <!-- /#bottom -->
</div>