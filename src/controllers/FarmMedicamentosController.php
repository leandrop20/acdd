<?php
namespace controllers;

use controllers\Controller;
use models\FarmMedicamentosModel;
use views\FarmMedicamentosView;
use \stdClass;

class FarmMedicamentosController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new FarmMedicamentosModel();
		$this->view = new FarmMedicamentosView();

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
		if (isset($_POST['order'])) { $order = $_POST['order']; }
		$result = $this->model->find("farm_".$this->table, $params, "all", true, $order);
		for ($i=0;$i<$result->num;$i++) {
			$dataLotes = $this->model->find("farm_lotes", [['id_medicamento', $result->data[$i]['id']]]);
			$qtd = 0;
			for ($j=0;$j<$dataLotes->num;$j++){
				$qtd += $dataLotes->data[$j]['quantidade'];
			}
			$result->data[$i]['qtd'] = $qtd;
		}
		$this->result = $result;
	}
	public function add()
	{
		if (count($_POST) > 0) {
			if ($this->model->find("farm_".$this->table, [["nome", $_POST['nome']]])->num > 0) {
				$this->view->callAlert("Nome já cadastrado, tente outro!");
			} else {
				$save = $this->model->save("farm_".$this->table, $_POST);
				if ($save->success) {
					$this->view->callAlert("Gravado com sucesso!", "index");
				} else {
					$this->view->callAlert("Erro ao tentar gravar!");
				}
				exit();
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