<?php
namespace controllers;

use controllers\Controller;
use models\CursGruposModel;
use views\CursGruposView;
use \stdClass;

class CursGruposController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new CursGruposModel();
		$this->view = new CursGruposView();

		$sectorsAllow = [0,4];
		parent::__construct($sectorsAllow);
	}

	public function index()
	{
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	array_push($params, [$key[0], $val[0]]);
		}
		$order = "id";
		if (isset($_POST['order'])) {
			if ($_POST['order'] != "nomeCurso" && $_POST['order'] != "nomeTrabalhador") {
				$order = $_POST['order'];
			}
		}
		$result = $this->model->find("curs_".$this->table, $params, "all", true, $order);
		for ($i=0;$i<$result->num;$i++) {
			$dataCurso = $this->model->find('cursos', [["id", $result->data[$i]['id_curso']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $result->data[$i]['id_trabalhador']]], "first")->data;
			$dataAlunos = $this->model->find('curs_alunos', [["id_grupo", $result->data[$i]['id']]], "first");

			$result->data[$i]['nomeCurso'] = $dataCurso['nome'];
			$result->data[$i]['nomeTrabalhador'] = $dataTrabalhador['nome'];
			$result->data[$i]['qtdAlunos'] = $dataAlunos->num;
		}
		if (isset($_POST['order'])) {
			if ($_POST['order'] == "nomeCurso" || $_POST['order'] == "nomeTrabalhador") {
				usort($result->data, function($a, $b){ return strcmp($a[$_POST['order']], $b[$_POST['order']]); });
			}
		}
		$this->result = $result;
	}

	public function add()
	{
		if (count($_POST) > 0) {
			$save = $this->model->save("curs_".$this->table, $_POST);
			if ($save->success) {
				$this->view->callAlert("Gravado com sucesso!", "index");
			} else {
				$this->view->callAlert("Erro ao tentar gravar!");
			}
			exit();
		}
	}

	public function edit($ID)
	{
		if (count($_POST) > 0) {
			$save = $this->model->update("curs_".$this->table, $_POST, $ID);
			if ($save->success) {
				$this->view->callAlert("Atualizado com sucesso!", "../index");
			} else {
				$this->view->callAlert("Erro ao tentar atualizar!", "../index");
			}
			exit();
		} else {
			$result = $this->model->find("curs_".$this->table, [["id", $ID]], "first");
			$dataCurso = $this->model->find('cursos', [["id", $result->data['id_curso']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $result->data['id_trabalhador']]], "first")->data;
			$result->nomeCurso = $dataCurso['nome'];
			$result->nomeTrabalhador = $dataTrabalhador['nome'];
			$this->result = $result;
		}
	}

	public function delete($ID)
	{
		$save = $this->model->delete("curs_".$this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}
	
}