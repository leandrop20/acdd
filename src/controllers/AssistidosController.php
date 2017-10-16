<?php
namespace controllers;

use controllers\AuthController;
use controllers\Controller;
use models\AssistidosModel;
use views\AssistidosView;
use \stdClass;

class AssistidosController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new AssistidosModel();
		$this->view = new AssistidosView();

		$sectorsAllow = [0,1,2,4];
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
		$out = new stdClass();

		$result = $this->model->find($this->table, [["id", $ID]], "first")->data;
		$out->data = $result;
		$out->city = $this->model->find("cidades", [["id", $result['id_cidade']]], "first")->data['nome'];
		$this->result = $out;
	}
	public function add()
	{
		if (count($_POST) > 0) {
			if ($this->model->find($this->table, [["nome", $_POST['nome']]])->num > 0) {
				$this->view->callAlert("Nome já cadastrado, tente outro!");
			} else {
				$save = $this->model->save($this->table, $_POST);
				if ($save->success) {
					$this->view->callAlert("Gravado com sucesso!", "view/".$save->id);
					exit();
				} else {
					$this->view->callAlert("Erro ao tentar gravar!");
				}
			}
		} else {
			$find = $this->model->find("cidades");
			$this->result = $find;
		}
	}
	public function edit($ID)
	{
		$out = new stdClass();
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
			$out->data = $result;
			$out->cities = $this->model->find("cidades")->data;
			$this->result = $out;
		}
	}
	public function delete($ID)
	{
		$save = $this->model->delete($this->table, $ID);
		echo "<script>window.history.go(-1)</script>";
	}
	public function checkPresence($ID)
	{
		if ($this->model->find("assis_presencas", [["id_assistido", $ID], ["data", date('Y-m-d')]], "first")->num > 0) {
			return true;
		}
		return false;
	}
	public function setPresence($ID)
	{
		$find = $this->model->find("assis_presencas", [["id_assistido", $ID], ["data", date('Y-m-d')]], "first");
		if ($find->num > 0) {
			$delete = $this->model->deletePhysical("assis_presencas", $find->data['id']);
		} else {
			$data = array(
				'id_assistido' => urlencode($ID),
				'data' => urlencode(date('Y-m-d'))
			);
			$save = $this->model->save("assis_presencas", $data);
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
		$result = $this->model->find($this->table, $params);
		$this->result = $result;
	}
	public function report($ID)
	{
		$out = new stdClass();
		$result = $this->model->find($this->table, [["id", $ID]], "first")->data;
		$out->nome = $result['nome'];
		$out->totalPresencas = $this->model->find("assis_presencas", [["id_assistido", $ID]])->num;
		$out->totalPasses = $this->model->find("passes", [["id_assistido", $ID]])->num;
		$out->totalCirurgias = $this->model->find("cirurgias", [["id_assistido", $ID]])->num;
		$out->totalCiruRetornos = $this->model->find("ciru_retornos", [["id_assistido", $ID]])->num;
		$out->totalDesob = $this->model->find("desobsessoes", [["id_assistido", $ID]])->num;
		$out->totalDesoRetornos = $this->model->find("deso_retornos", [["id_assistido", $ID]])->num;

		$this->result = $out;
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
			$path = "assets/images/profile/assistidos/";
			$fileName = "profile_".$_POST['id'].".png";
			file_put_contents($path.$fileName, $fileData);

			$save = $this->model->update('assistidos', ['foto'=>$fileName], $_POST['id']);
			$this->result = $save->success;
		}
	}
}
?>