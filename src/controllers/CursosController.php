<?php
namespace controllers;

use controllers\Controller;
use models\CursosModel;
use views\CursosView;
use \stdClass;

class CursosController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new CursosModel();
		$this->view = new CursosView();

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
		if (isset($_POST['order'])) { $order = $_POST['order']; }
		$result = $this->model->find($this->table, $params, "all", true, $order);
		$this->result = $result;
	}

	public function add()
	{
		if (count($_POST) > 0) {
			$save = $this->model->save($this->table, $_POST);
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
			$save = $this->model->update($this->table, $_POST, $ID);
			if ($save->success) {
				$this->view->callAlert("Atualizado com sucesso!", "../index");
			} else {
				$this->view->callAlert("Erro ao tentar atualizar!", "../view");
			}
			exit();
		} else {
			$result = $this->model->find($this->table, [["id", $ID]], "first");
			$this->result = $result;
		}
	}

	public function delete($ID)
	{
		$save = $this->model->delete($this->table, $ID);
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
		$result = $this->model->find($this->table, $params);
		$this->result = $result;
	}
	
}