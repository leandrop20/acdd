<?php
namespace controllers;

use controllers\Controller;
use models\CursAulasModel;
use views\CursAulasView;
use \stdClass;

class CursAulasController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new CursAulasModel();
		$this->view = new CursAulasView();

		$sectorsAllow = [0,4];
		parent::__construct($sectorsAllow);
	}

	public function index($ID)
	{
		$dataGrupo = $this->model->find('curs_grupos', [["id", $ID]], "first")->data;
		$dataCurso = $this->model->find('cursos', [["id", $dataGrupo['id_curso']]], "first")->data;

		if (count($_POST) > 0) {
			if (isset($_POST['data'])) {
				$_POST['data'] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['data'])));
			}
		}

		$params = [];
		array_push($params, ["id_grupo", $ID]);
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	array_push($params, [$key[0], $val[0]]);
		}
		$order = "id";
		if (isset($_POST['order'])) { $order = $_POST['order']; }
		$result = $this->model->find("curs_".$this->table, $params, "all", true, $order);

		$result->nomeGrupo = $dataGrupo['nome'];
		$result->nomeCurso = $dataCurso['nome'];
		$this->result = $result;
	}

	public function add($ID)
	{
		if (count($_POST) > 0) {
			$save = $this->model->save("curs_".$this->table, $_POST);
			if ($save->success) {
				$this->view->callAlert("Gravado com sucesso!", "../index/".$ID);
			} else {
				$this->view->callAlert("Erro ao tentar gravar!");
			}
			exit();
		} else {
			$result = new stdClass();
			$dataGrupo = $this->model->find('curs_grupos', [["id", $ID]], "first")->data;
			$result->idGrupo = $dataGrupo['id'];
			$result->nomeGrupo = $dataGrupo['nome'];
			$this->result = $result;
		}
	}

	public function delete($ID)
	{
		$save = $this->model->delete("curs_".$this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}

	public function call($ID)
	{
		if (count($_POST) > 0 && !isset($_POST['pag'])) {
			$find = $this->model->find("curs_presencas", [["id_aula", $_POST['id_aula']], ["id_aluno", $_POST['id_aluno']], ["data", $_POST['data']]], "first");
			if ($find->num > 0) {
				$delete = $this->model->deletePhysical("curs_presencas", $find->data['id']);
			} else {
				$save = $this->model->save("curs_presencas", $_POST);
			}
			echo "<script>window.history.go(-1)</script>";
			exit();
		} else {
			$result = new stdClass();
			$result->aula = $this->model->find('curs_'.$this->table, [["id", $ID]], "first")->data;
			$dataGrupo = $this->model->find('curs_grupos', [["id", $result->aula['id_grupo']]], "first")->data;
			$dataCurso = $this->model->find('cursos', [["id", $dataGrupo['id_curso']]], "first")->data;
			$dataAlunos = $this->model->find('curs_alunos', [["id_grupo", $dataGrupo['id']]], "all", true);

			$dataAssistido;
			for ($i=0;$i<$dataAlunos->num;$i++) {
				$dataAssistido = $this->model->find('assistidos', [["id", $dataAlunos->data[$i]['id_assistido']]], "first")->data;
				$dataAlunos->data[$i]['nome'] = $dataAssistido['nome'];
			}
			usort($dataAlunos->data, function($a, $b){ return strcmp($a['nome'], $b['nome']); });

			$result->nomeGrupo = $dataGrupo['nome'];
			$result->nomeCurso = $dataCurso['nome'];
			$result->alunos = $dataAlunos;
			$this->result = $result;
		}
	}

	public function checkPresence($aulaID, $alunoID)
	{
		if ($this->model->find("curs_presencas", [["id_aula", $aulaID], ["id_aluno", $alunoID]], "first")->num > 0) {
			return true;
		}
		return false;
	}

	public function pctPresenca($grupoID, $aulaID)
	{
		$totalAlunos = count($this->model->find("curs_alunos", [["id_grupo", $grupoID]])->data);
		$totalPresencas = count($this->model->find("curs_presencas", [["id_aula", $aulaID]])->data);
		return round(($totalPresencas/$totalAlunos)*100);
	}
	
}