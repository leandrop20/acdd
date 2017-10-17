<?php
namespace controllers;

use controllers\Controller;
use models\FarmSaidasModel;
use views\FarmSaidasView;
use \stdClass;

class FarmSaidasController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new FarmSaidasModel();
		$this->view = new FarmSaidasView();

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
		for ($i=0;$i<$result->num;$i++) {
			$dataMedicamento = $this->model->find("farm_medicamentos", [['id', $result->data[$i]['id_medicamento']]], "first")->data;
			$result->data[$i]['nomeMedicamento'] = $dataMedicamento['nome'];
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
		if (count($_POST) == 3) {
			$result = $this->model->find("farm_medicamentos", [['id', $_POST['id_medicamento']]], "first");
			$dataLote = $this->model->find("farm_lotes", [['id', $_POST['id_lote']]], "first")->data;
			$result->data['idLote'] = $dataLote['id'];
			$this->result = $result;
		} else if ($ID && count($_POST) == 0) {
			$result = $this->model->find("farm_medicamentos", [['id', $ID]], "first");
			$this->result = $result;
		} else if (count($_POST) > 0) {
			$qtdTotal = $this->model->find("farm_lotes", [['id', $_POST['id_lote']]], "first")->data['quantidade'];
			$restNum = ($qtdTotal-(int)$_POST['quantidade']);
			$loteID = $_POST['id_lote'];
			$save = $this->model->update("farm_lotes", ['quantidade'=>$restNum], $loteID);
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
		}
	}

	public function delete($ID)
	{
		$dataSaida = $this->model->find("farm_".$this->table, [['id', $ID]], "first")->data;
		$dataLote = $this->model->find("farm_lotes", [['id', $dataSaida['id_lote']]], "first")->data;
		$newQtd = ((int)$dataSaida['quantidade']+$dataLote['quantidade']);
		$this->model->update("farm_lotes", ['quantidade'=>$newQtd],$dataSaida['id_lote']);
		$this->model->deletePhysical("farm_".$this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}
	
}