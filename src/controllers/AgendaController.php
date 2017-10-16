<?php
namespace controllers;

use controllers\Controller;
use models\AgendaModel;
use views\AgendaView;
use \stdClass;

class AgendaController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new AgendaModel();
		$this->view = new AgendaView();

		$sectorsAllow = [0,1,2];
		parent::__construct($sectorsAllow);
	}
	private function convertDate($value)
	{
		return date('Y-m-d', strtotime(str_replace('/', '-', $value)));
	}
	public function agenda()
	{
		$result = new stdClass();
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	array_push($params, [$key[0], $val[0]]);
		}
		$order = "id";
		if (isset($_POST['order'])) {
			if ($_POST['order'] != "ficha" && $_POST['order'] != "nome") {
				$order = $_POST['order'];
			}
		}
		if (count($_POST) > 0) {
			$dataAll = array();
			array_push($dataAll, $this->model->find("cirurgias", [["data_cirurgia", $this->convertDate($params[0][1])]], "all", false, $order));
			array_push($dataAll, $this->model->find("ciru_retornos", [["data_retorno", $this->convertDate($params[0][1])]], "all", false, $order));
			array_push($dataAll, $this->model->find("desobsessoes", [["data_desobsessao", $this->convertDate($params[0][1])]], "all", false, $order));
			array_push($dataAll, $this->model->find("deso_retornos", [["data_retorno", $this->convertDate($params[0][1])]], "all", false, $order));

			$names = array("dataCirurgias", "dataCiruRetornos", "dataDesobs", "dataDesoRetornos");
			for ($i=0;$i<count($dataAll);$i++) {
				for ($j=0;$j<$dataAll[$i]->num;$j++) {
					$dataAssistido = $this->model->find("assistidos", [["id", $dataAll[$i]->data[$j]['id_assistido']]], "first")->data;
					$dataAll[$i]->data[$j]['ficha'] = $dataAssistido['ficha'];
					$dataAll[$i]->data[$j]['nome'] = $dataAssistido['nome'];
				}
				if (isset($_POST['order'])) {
					if ($_POST['order'] == "ficha" || $_POST['order'] == "nome") {
						usort($dataAll[$i]->data, function($a, $b){ return strcmp($a[$_POST['order']], $b[$_POST['order']]); });
					}
				}
				$result->$names[$i] = $dataAll[$i];
			}

			$result->data = $params[0][1];
		}
		$this->result = $result;
	}
}