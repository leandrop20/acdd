<?php
namespace controllers;

use controllers\AuthController;

class Controller
{
	public $table;

	function __construct($sectors = [])
	{
		$checkURI = explode("/", $_SERVER['REQUEST_URI']);
		if (is_numeric($checkURI[count($checkURI)-1])) {
			$this->table = $checkURI[count($checkURI)-3];
			$this->$checkURI[count($checkURI)-2]($checkURI[count($checkURI)-1]);
		} else {
			$this->table = $checkURI[count($checkURI)-2];
			$this->$checkURI[count($checkURI)-1]();
		}
		$this->checkPermit($sectors);
	}
	public function checkPermit($sectors = [])
	{
		//0 = administrativo, 1 = recepcao, 2 = atendimento, 3 = farmacia, 4 = cursos, 5 = tecnico
		$allowAccess = false;
		$auth = new AuthController();
		for ($i=0;$i<count($sectors);$i++) {
			if ($sectors[$i] == $auth->getAuth()->setor) {
				$allowAccess = true;
			}
		}
		if (!$allowAccess) {
			echo "<br><br><br>";
			echo "<div class='alert alert-danger' role='alert'><strong>Ops!</strong> Acesso não permitido.</div>";
			exit();
		}
	}
}
?>