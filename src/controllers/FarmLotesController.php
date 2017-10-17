<?php
namespace controllers;

use controllers\Controller;
use models\FarmLotesModel;
use views\FarmLotesView;
use \stdClass;
use \DateTime;

class FarmLotesController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new FarmLotesModel();
		$this->view = new FarmLotesView();

		$sectorsAllow = [0,3];
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
			if ($_POST['order'] != "nomeMedicamento") {
				$order = $_POST['order'];
			}
		}
		$result = $this->model->find("farm_".$this->table, $params, "all", true, $order);
		print('<br><br><br>');
		for ($i=0;$i<$result->num;$i++) {
			$dataMedicamento = $this->model->find("farm_medicamentos", [['id', $result->data[$i]['id_medicamento']]], "first")->data;
			$result->data[$i]['nomeMedicamento'] = $dataMedicamento['nome'];

			$validity = new DateTime($result->data[$i]['validade']);
			$today = new DateTime('now');
			
			$diff = $today->diff($validity);
			if ($diff->invert) {
				$result->data[$i]['statusVencimento'] = 2;
			} else if ($diff->d < 7) {
				$result->data[$i]['statusVencimento'] = 1;
			} else {
				$result->data[$i]['statusVencimento'] = 0;
			}
		}
		if (isset($_POST['order'])) {
			if ($_POST['order'] == "nomeMedicamento") {
				usort($result->data, function($a, $b){ return strcmp($a[$_POST['order']], $b[$_POST['order']]); });
			}
		}
		$this->result = $result;
	}

	public function add($ID = null)
	{
		if (count($_POST) > 0) {
			$save = $this->model->save("farm_".$this->table, $_POST);
			if ($save->success) {
				if ($ID) {
					$this->view->callAlert("Gravado com sucesso!", "../index");
				} else {
					$this->view->callAlert("Gravado com sucesso!", "index");
				}
			} else {
				$this->view->callAlert("Erro ao tentar gravar!");
			}
			exit();
		} else {
			if ($ID) {
				$result = $this->model->find("farm_medicamentos", [['id', $ID]], "first");
				$this->result = $result;
			}
		}
	}

	public function edit($ID)
	{
		if (count($_POST) > 0) {
			$save = $this->model->update("farm_".$this->table, $_POST, $ID);
			if ($save->success) {
				$this->view->callAlert("Atualizado com sucesso!", "../index");
			} else {
				$this->view->callAlert("Erro ao tentar atualizar!", "../index");
			}
			exit();
		} else {
			$result = $this->model->find("farm_".$this->table, [["id", $ID]], "first");
			$dataMedicamento = $this->model->find("farm_medicamentos", [['id', $result->data['id_medicamento']]], "first")->data;

			$result->data['nomeMedicamento'] = $dataMedicamento['nome'];
			$this->result = $result;
		}
	}

	public function delete($ID)
	{
		$save = $this->model->delete("farm_".$this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}

	public function search()
	{
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	array_push($params, [$key[0], $val[0]]);
		}
		$result = $this->model->find("farm_".$this->table, $params);
		$this->result = $result;
	}
	
}