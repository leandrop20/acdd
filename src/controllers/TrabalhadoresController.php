<?php
namespace controllers;

use controllers\Controller;
use models\TrabalhadoresModel;
use views\TrabalhadoresView;

class TrabalhadoresController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new TrabalhadoresModel();
		$this->view = new TrabalhadoresView();

		$sectorsAllow = [0,1,2,3,4,5];
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
	public function view($ID)
	{
		$result = $this->model->find($this->table, [["id", $ID]], "first")->data;
		$this->result = $result;
	}
	public function add()
	{
		$this->checkPermit([0]);
		if (count($_POST) > 0) {
			if ($this->model->find($this->table, [["usuario", $_POST['usuario']]])->num > 0) {
				$this->view->callAlert("Usuário já existe, tente outro!");
			} else {
				$save = $this->model->save($this->table, $_POST);
				if ($save->success) {
					$this->view->callAlert("Gravado com sucesso!", "view/".$save->id);
					exit();
				} else {
					$this->view->callAlert("Erro ao tentar gravar!");
				}
			}
		}
	}
	public function edit($ID)
	{
		if ($_SESSION['userID'] != $ID) {
			$this->checkPermit([0]);
		}
		if (count($_POST) > 0) {
			$save = $this->model->update($this->table, $_POST, $ID);
			if ($save->success) {
				$this->view->callAlert("Atualizado com sucesso!", "../view/".$ID);
				exit();
			} else {
				$this->view->callAlert("Erro ao tentar atualizar!", "../view/".$ID);
			}
		} else {
			$result = $this->model->find($this->table, [["id", $ID]], "first")->data;
			$this->result = $result;
		}
	}
	public function delete($ID)
	{
		$this->checkPermit([0]);
		$save = $this->model->delete($this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}
	public function checkPresence($ID)
	{
		if ($this->model->find("trab_presencas", [["id_trabalhador", $ID], ["data", date('Y-m-d')]], "first")->num > 0) {
			return true;
		}
		return false;
	}
	public function setPresence($ID)
	{
		$find = $this->model->find("trab_presencas", [["id_trabalhador", $ID], ["data", date('Y-m-d')]], "first");
		if ($find->num > 0) {
			$delete = $this->model->deletePhysical("trab_presencas", $find->data['id']);
		} else {
			$data = array(
				'id_trabalhador' => urlencode($ID),
				'data' => urlencode(date('Y-m-d'))
			);
			$save = $this->model->save("trab_presencas", $data);
		}
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
		array_push($params, ['setor',2]);
		$result = $this->model->find($this->table, $params);
		$this->result = $result;
	}
	public function searchInstrutor()
	{
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	array_push($params, [$key[0], $val[0]]);
		}
		array_push($params, ['setor',4]);
		$result = $this->model->find($this->table, $params);
		$this->result = $result;
	}
	public function saveImage()
	{
		$params = [];
		if (count($_POST) > 0) {
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	for ($i=0;$i<count($_POST);$i++) {
	    		array_push($params, [$key[$i], $val[$i]]);
	    	}

	    	$img = $_POST['img'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$fileData = base64_decode($img);
			//saving
			$path = "assets/images/profile/trabalhadores/";
			$fileName = "profile_".$_POST['id'].".png";
			file_put_contents($path.$fileName, $fileData);

			$save = $this->model->update('trabalhadores', ['foto'=>$fileName], $_POST['id']);
			$this->result = $save->success;
		}
	}
}
?>