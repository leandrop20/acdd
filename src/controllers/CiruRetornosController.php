<?php
namespace controllers;

use controllers\Controller;
use models\CiruRetornosModel;
use views\CiruRetornosView;
use \stdClass;

class CiruRetornosController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new CiruRetornosModel();
		$this->view = new CiruRetornosView();

		$sectorsAllow = [0,1,2];
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
			if ($_POST['order'] != "nomeAssistido" && $_POST['order'] != "nomeTrabalhador") {
				$order = $_POST['order'];
			}
		}
		$result = $this->model->find("ciru_".$this->table, $params, "all", true, $order);
		for ($i=0;$i<$result->num;$i++) {
			$dataAssistido = $this->model->find('assistidos', [["id", $result->data[$i]['id_assistido']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $result->data[$i]['id_trabalhador']]], "first")->data;
			$result->data[$i]['nomeAssistido'] = $dataAssistido['nome'];
			$result->data[$i]['nomeTrabalhador'] = $dataTrabalhador['nome'];
		}
		if (isset($_POST['order'])) {
			if ($_POST['order'] == "nomeAssistido" || $_POST['order'] == "nomeTrabalhador") {
				usort($result->data, function($a, $b){ return strcmp($a[$_POST['order']], $b[$_POST['order']]); });
			}
		}
		$this->result = $result;
	}

	public function view($ID)
	{
		$result = $this->model->find("ciru_".$this->table, [["id", $ID]], "first");
		$dataAssistido = $this->model->find('assistidos', [["id", $result->data['id_assistido']]], "first")->data;
		$dataTrabalhador = $this->model->find('trabalhadores', [["id", $result->data['id_trabalhador']]], "first")->data;
		$result->nomeAssistido = $dataAssistido['nome'];
		$result->nomeTrabalhador = $dataTrabalhador['nome'];
		$this->result = $result;
	}

	public function add($ID = -1)
	{
		if (count($_POST) > 0) {
			$save = $this->model->save("ciru_".$this->table, $_POST);
			if ($save->success) {
				$this->view->callAlert("Gravado com sucesso!", "../view/".$save->id);
			} else {
				$this->view->callAlert("Erro ao tentar gravar!");
			}
			exit();
		} else {
			$result = $this->model->find('cirurgias', [["id", $ID]], "first");
			$dataAssistido = $this->model->find('assistidos', [["id", $result->data['id_assistido']]], "first")->data;
			$result->nomeAssistido = $dataAssistido['nome'];
			$this->result = $result;
		}
	}

	public function edit($ID)
	{
		if (count($_POST) > 0) {
			$save = $this->model->update("ciru_".$this->table, $_POST, $ID);
			if ($save->success) {
				$this->view->callAlert("Atualizado com sucesso!", "../view/".$ID);
			} else {
				$this->view->callAlert("Erro ao tentar atualizar!", "../view/".$ID);
			}
			exit();
		} else {
			$result = $this->model->find("ciru_".$this->table, [["id", $ID]], "first");
			$dataAssistido = $this->model->find('assistidos', [["id", $result->data['id_assistido']]], "first")->data;
			$dataTrabalhador = $this->model->find('trabalhadores', [["id", $result->data['id_trabalhador']]], "first")->data;
			$result->nomeAssistido = $dataAssistido['nome'];
			$result->nomeTrabalhador = $dataTrabalhador['nome'];
			$this->result = $result;
		}
	}

	public function delete($ID)
	{
		$save = $this->model->delete("ciru_".$this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}
	
}