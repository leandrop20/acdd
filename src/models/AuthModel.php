<?php
namespace models;

use models\Model;
use \stdClass;

class AuthModel extends Model
{
	public $dataAuth;
	public static $status = false;

	function __construct()
	{
		if (!AuthModel::$status) { session_start(); }
		$this->dataAuth = new stdClass();
		if (isset($_SESSION['userName'])) {
			$this->dataAuth->status = true;
			AuthModel::$status = true;
			$this->dataAuth->name = $_SESSION['userName'];
			$this->dataAuth->setor = $_SESSION['userSetor'];
			$this->dataAuth->id = $_SESSION['userID'];
		} else {
			$this->dataAuth->status = false;
		}
		parent::__construct();
	}

	function checkLog()
	{
		if (isset($_POST['login'])) {
			$dataUsers = $this->find("trabalhadores", [['usuario', $_POST['login']], ['senha', md5($_POST['password'])]], "first");
			if ($dataUsers->num == 1) {
				$this->dataAuth->status = true;
				AuthModel::$status = true;
				$_SESSION['userName'] = $dataUsers->data['nome'];
				$_SESSION['userSetor'] = $dataUsers->data['setor'];
				$_SESSION['userID'] = $dataUsers->data['id'];
				return true;
			}
		}
		return false;
	}

	public function getAuth()
	{
		return $this->dataAuth;
	}

	public function logout()
	{
		session_unset('userName');
		session_unset('userSetor');
		session_unset('userID');
		$this->dataAuth->status = false;
		AuthModel::$status = false;
		$this->dataAuth->name = "";
		$this->dataAuth->setor = "";
		$this->dataAuth->id = "";
	}
	
}
?>