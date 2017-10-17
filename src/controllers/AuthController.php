<?php
namespace controllers;

use models\AuthModel;
use views\AuthView;


class AuthController
{
	private $model;
	private $view;

	function __construct()
	{
		$this->model = new AuthModel();
		$this->view = new AuthView();
	}

	public function checkLog()
	{
		return $this->view->checkLog($this->model->checkLog());
	}

	public function getAuth()
	{
		return $this->view->getAuth($this->model->getAuth());
	}

	public function logout()
	{
		$this->model->logout();
	}
	
}
?>