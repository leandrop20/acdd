<?php
namespace controllers;

use controllers\Controller;
use models\RelatoriosModel;
use views\RelatoriosView;
use \stdClass;

class RelatoriosController extends Controller
{
	private $model;
	private $view;
	public $result;

	function __construct()
	{
		$this->model = new RelatoriosModel();
		$this->view = new RelatoriosView();

		$sectorsAllow = [0];
		parent::__construct($sectorsAllow);
	}

	private function convertDate($value)
	{
		return date('Y-m-d', strtotime(str_replace('/', '-', $value)));
	}

	public function assistidos()
	{
		$result = new stdClass();
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	for ($i=0;$i<count($_POST);$i++) {
	    		array_push($params, [$key[$i], $val[$i]]);
	    	}
		}

		if (count($_POST) > 0) {
			$params1 = [[$params[0][0], $this->convertDate($params[0][1])." 00:00:01"], [$params[1][0], $this->convertDate($params[1][1])." 23:59:59"]];
			$params2 = [["data", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];

			$dataAssistidos = $this->model->findByDate("assistidos", $params1);
			$result->total = $dataAssistidos->num;

			$dataPresencas = $this->model->findByDate("assis_presencas", $params2);
			$result->presencas = $dataPresencas->num;

			$result->dataInit = $params[0][1];
			$result->dataEnd = $params[1][1];
		}
		$this->result = $result;
	}

	public function trabalhadores()
	{
		$result = new stdClass();
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	for ($i=0;$i<count($_POST);$i++) {
	    		array_push($params, [$key[$i], $val[$i]]);
	    	}
		}

		if (count($_POST) > 0) {
			$params1 = [[$params[0][0], $this->convertDate($params[0][1])." 00:00:01"], [$params[1][0], $this->convertDate($params[1][1])." 23:59:59"]];
			$params2 = [["data", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];

			$dataAssistidos = $this->model->findByDate("trabalhadores", $params1);
			$result->total = $dataAssistidos->num;

			$dataPresencas = $this->model->findByDate("trab_presencas", $params2);
			$result->presencas = $dataPresencas->num;

			$result->dataInit = $params[0][1];
			$result->dataEnd = $params[1][1];
		}
		$this->result = $result;
	}

	public function atendimentos()
	{
		$result = new stdClass();
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	for ($i=0;$i<count($_POST);$i++) {
	    		array_push($params, [$key[$i], $val[$i]]);
	    	}
		}

		if (count($_POST) > 0) {
			$paramsPasses = [["data_passe", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];
			$paramsCirurgias = [["data_cirurgia", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];
			$paramsDesob = [["data_desobsessao", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];
			$paramsRetornos = [["data_retorno", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];

			$dataPasses = $this->model->findByDate("passes", $paramsPasses);
			$result->totalPasses = $dataPasses->num;

			$dataCirurgias = $this->model->findByDate("cirurgias", $paramsCirurgias);
			$dataCiruRetornos = $this->model->findByDate("ciru_retornos", $paramsRetornos);
			$dataDesob = $this->model->findByDate("desobsessoes", $paramsDesob);
			$dataDesoRetornos = $this->model->findByDate("deso_retornos", $paramsRetornos);

			$dataAll = array();
			array_push($dataAll, $dataCirurgias);
			array_push($dataAll, $dataCiruRetornos);
			array_push($dataAll, $dataDesob);
			array_push($dataAll, $dataDesoRetornos);
			$dataOut = array();

			for ($i=0;$i<count($dataAll);$i++) {
				$total = $dataAll[$i]->num;
				$efe = 0;
				$naoEfe = 0;
				$cancel = 0;
				for ($j=0;$j<$total;$j++){
					switch ($dataAll[$i]->data[$j]['situacao']) {
						case 0: $naoEfe++; break;
						case 1: $efe++; break;
						case 2: $cancel++; break;
					}
				}
				array_push($dataOut, ["total"=>$total, "efetuadas"=>$efe, "naoEfe"=>$naoEfe, "cancel"=>$cancel]);
			}
			$result->dataAll = $dataOut;
			$result->dataInit = $params[0][1];
			$result->dataEnd = $params[1][1];
		}

		$this->result = $result;
	}

	public function cursos()
	{
		$result = new stdClass();
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	for ($i=0;$i<count($_POST);$i++) {
	    		array_push($params, [$key[$i], $val[$i]]);
	    	}
		}

		if (count($_POST) > 0) {
			$paramsGrupos = [["data_cadastro", $this->convertDate($params[0][1])." 00:00:01"], [$params[1][0], $this->convertDate($params[1][1])." 23:59:59"]];
			$paramsAulas = [["data", $this->convertDate($params[0][1])], [$params[1][0], $this->convertDate($params[1][1])]];

			$result->totalCursos = $this->model->find("cursos")->num;
			$dataGrupos = $this->model->findByDate("curs_grupos", $paramsGrupos);
			$result->totalGrupos = $dataGrupos->num;

			$gruposFinished = 0;
			$gruposInProgress = 0;
			$grupoConcluido = true;
			for ($i=0;$i<$dataGrupos->num;$i++) {
				$grupoConcluido = true;
				$dataAlunosEach = $this->model->find("curs_alunos", [["id_grupo", $dataGrupos->data[$i]['id']]]);
				for ($j=0;$j<$dataAlunosEach->num;$j++){
					if ($dataAlunosEach->data[$j]['situacao'] == 3) {
						$grupoConcluido = false;
						break;
					}
				}
				if ($grupoConcluido) { $gruposFinished++; } else { $gruposInProgress++; }
			}
			$result->gruposFinalizados = $gruposFinished;
			$result->gruposEmAndamento = $gruposInProgress;

			$result->totalAulas = $this->model->findByDate("curs_aulas", $paramsAulas)->num;

			$dataAlunos = $this->model->findByDate("curs_alunos", $paramsGrupos);
			$result->totalAlunos = $dataAlunos->num;
			$aprovados = 0;
			$reprovados = 0;
			$cursando = 0;
			$desistentes = 0;
			for ($i=0;$i<$dataAlunos->num;$i++) {
				switch($dataAlunos->data[$i]['situacao']) {
					case 0: $reprovados++; break;
					case 1: $aprovados++; break;
					case 2: $desistentes++; break;
					case 3: $cursando++; break;
				}
			}
			$result->alunosAprovados = $aprovados;
			$result->alunosReprovados = $reprovados;
			$result->alunosDesistentes = $desistentes;
			$result->alunosCursando = $cursando;

			$result->dataInit = $params[0][1];
			$result->dataEnd = $params[1][1];
		}

		$this->result = $result;
	}

	public function farmacia()
	{
		$result = new stdClass();
		$params = [];
		if (count($_POST) > 0) {//SEARCH
			$key = array_keys($_POST);
	    	$val = array_values($_POST);
	    	for ($i=0;$i<count($_POST);$i++) {
	    		array_push($params, [$key[$i], $val[$i]]);
	    	}
		}

		if (count($_POST) > 0) {
			$paramsMed = [["data_cadastro", $this->convertDate($params[0][1])." 00:00:01"], [$params[1][0], $this->convertDate($params[1][1])." 23:59:59"]];
			$dataMedicamentos = $this->model->findByDate("farm_medicamentos", $paramsMed);
			$totalEmEstoque = 0;
			$totalEmFalta = 0;
			$totalVencidos = 0;
			$hasStock = false;
			$hasExpired = false;
			for ($i=0;$i<$dataMedicamentos->num;$i++) {
				$hasStock = false;
				$hasExpired = false;
				$dataLotes = $this->model->find("farm_lotes", [['id_medicamento', $dataMedicamentos->data[$i]['id']]]);
				for ($j=0;$j<$dataLotes->num;$j++) {
					if ($dataLotes->data[$j]['quantidade'] > 0) {
						$hasStock = true;
						if ($dataLotes->data[$j]['validade'] < date("Y-m-d")) {
							$hasExpired = true;
						}
						break;
					}
				}
				if ($hasStock) { $totalEmEstoque++; } else { $totalEmFalta++; }
				if ($hasExpired) { $totalVencidos++; }
			}
			$result->totalEmEstoque = $totalEmEstoque;
			$result->totalEmFalta = $totalEmFalta;
			$result->totalVencidos = $totalVencidos;

			$result->totalEntradas = $this->model->findByDate("farm_lotes", $paramsMed)->num;
			$result->totalSaidas = $this->model->findByDate("farm_saidas", $paramsMed)->num;

			$result->dataInit = $params[0][1];
			$result->dataEnd = $params[1][1];
		}

		$this->result = $result;
	}
	
}