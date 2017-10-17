<?php
namespace controllers;

use controllers\Controller;
use models\CursAlunosModel;
use views\CursAlunosView;
use \stdClass;

class CursAlunosController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new CursAlunosModel();
		$this->view = new CursAlunosView();

		$sectorsAllow = [0,4];
		parent::__construct($sectorsAllow);
	}

	public function index($ID)
	{
		$dataGrupo = $this->model->find('curs_grupos', [["id", $ID]], "first")->data;
		$dataCurso = $this->model->find('cursos', [["id", $dataGrupo['id_curso']]], "first")->data;

		$params = [];
		array_push($params, ["id_grupo", $ID]);
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	array_push($params, [$key[0], $val[0]]);
		}
		$order = "id";
		if (isset($_POST['order'])) {
			if ($_POST['order'] != "nomeAssistido" && $_POST['order'] != "nomeTrabalhador") {
				$order = $_POST['order'];
			}
		}
		$result = $this->model->find("curs_".$this->table, $params, "all", true, $order);

		for ($i=0;$i<$result->num;$i++) {
			$dataAssistido = $this->model->find('assistidos', [["id", $result->data[$i]['id_assistido']]], "first")->data;
			$dataGrupo = $this->model->find('curs_grupos', [["id", $result->data[$i]['id_grupo']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $dataGrupo['id_trabalhador']]], "first")->data;

			$result->data[$i]['nomeAssistido'] = $dataAssistido['nome'];
			$result->data[$i]['nomeTrabalhador'] = $dataTrabalhador['nome'];
		}
		if (isset($_POST['order'])) {
			if ($_POST['order'] == "nomeAssistido" || $_POST['order'] == "nomeTrabalhador") {
				usort($result->data, function($a, $b){ return strcmp($a[$_POST['order']], $b[$_POST['order']]); });
			}
		}
		$result->nomeGrupo = $dataGrupo['nome'];
		$result->nomeCurso = $dataCurso['nome'];
		$this->result = $result;
	}

	public function add($ID)
	{
		if (count($_POST) > 0) {
			if ($this->model->find("curs_".$this->table, [["id_assistido", $_POST['id_assistido']], ["id_grupo", $_POST['id_grupo']]])->num > 0) {
				$this->view->callAlert("Aluno já cadastrado, tente outro!", "../add/".$ID);
			} else {
				$save = $this->model->save("curs_".$this->table, $_POST);
				if ($save->success) {
					$this->view->callAlert("Gravado com sucesso!", "../index/".$ID);
				} else {
					$this->view->callAlert("Erro ao tentar gravar!");
				}
				exit();
			}
		} else {
			$result = new stdClass();
			$dataGrupo = $this->model->find('curs_grupos', [["id", $ID]], "first")->data;
			$dataCurso = $this->model->find('cursos', [["id", $dataGrupo['id_curso']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $dataGrupo['id_trabalhador']]], "first")->data;
			$result->nomeGrupo = $dataGrupo['nome'];
			$result->idCurso = $dataCurso['id'];
			$result->nomeCurso = $dataCurso['nome'];
			$result->idTrabalhador = $dataTrabalhador['id'];
			$result->nomeTrabalhador = $dataTrabalhador['nome'];
			$this->result = $result;
		}
	}

	public function edit($ID)
	{
		if (count($_POST) > 0) {
			$save = $this->model->update("curs_".$this->table, $_POST, $ID);
			if ($save->success) {
				$this->view->callAlert("Atualizado com sucesso!", "../index/".$_POST['id_grupo']);
			} else {
				$this->view->callAlert("Erro ao tentar atualizar!", "../index/".$_POST['id_grupo']);
			}
			exit();
		} else {
			$result = $this->model->find('curs_'.$this->table, [["id", $ID]], "first")->data;
			$dataAssistido = $this->model->find('assistidos', [["id", $result['id_assistido']]], "first")->data;
			$dataGrupo = $this->model->find('curs_grupos', [["id", $result['id_grupo']]], "first")->data;
			$dataCurso = $this->model->find('cursos', [["id", $dataGrupo['id_curso']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $dataGrupo['id_trabalhador']]], "first")->data;

			$result['nomeAssistido'] = $dataAssistido['nome'];
			$result['nomeGrupo'] = $dataGrupo['nome'];
			$result['idCurso'] = $dataCurso['id'];
			$result['nomeCurso'] = $dataCurso['nome'];
			$result['idTrabalhador'] = $dataTrabalhador['id'];
			$result['nomeTrabalhador'] = $dataTrabalhador['nome'];
			$this->result = $result;
		}
	}

	public function delete($ID)
	{
		$save = $this->model->delete("curs_".$this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}

	public function getFaltas($grupoID, $alunoID)
	{
		$dataAulas = $this->model->find('curs_aulas', [["id_grupo", $grupoID]]);
		$amount = 0;
		for ($i=0;$i<$dataAulas->num;$i++) {
			if ($this->model->find('curs_presencas', [['id_aula', $dataAulas->data[$i]['id']], ['id_aluno', $alunoID]])->num > 0) {
				$amount++;
			}
		}
		return $dataAulas->num-$amount;
	}
	
}