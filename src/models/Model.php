<?php
namespace models;

use \stdClass;

class Model
{

	function __construct()
	{
		$this->server = "localhost";
		$this->user = "root";
		$this->password = "";
		$this->db = "acdd";
	}

	private function connect()
	{
		$conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
		return $conn;
	}

	public function save($table, $data)
	{
		$out = new stdClass();

		if (isset($data['senha'])) {
			$data['senha'] = md5($data['senha']);
		}

		$typesDate = array('nascimento', 'data', 'data_cirurgia', 'data_retorno', 'data_desobsessao', 'validade', 'data_saida', 'data_passe');
		for ($i=0; $i < count($typesDate); $i++) {
			if (isset($data[$typesDate[$i]])) {
				$data[$typesDate[$i]] = date('Y-m-d', strtotime(str_replace('/', '-', $data[$typesDate[$i]])));
			}
		}

		$conn = $this->connect();
		$key = array_keys($data);
	    $val = array_values($data);
	    $sql = "INSERT INTO ".$table." (" . implode(', ', $key) . ") "
	         . "VALUES ('" . implode("', '", $val) . "')";
	 	// echo $sql;
	    $out->success = $conn->query($sql);
	    $out->id = $conn->insert_id;
		$conn->close();
		return $out;
	}

	public function find($table, $params = [], $typeReturn = "all", $pagination = false, $order = "id")
	{
		$out = new stdClass();

		for ($i=0; $i < count($params); $i++) {
			if ($params[$i][0] == "pag") {
				unset($params[$i]);
				break;
			}
		}

		$conn = $this->connect();
		$sql = "SELECT * FROM ".$table;
		for ($i=0; $i < count($params); $i++) {
			if ($i == 0) { $sql .= " WHERE "; }
			if ($i > 0) { $sql .=" AND "; }
			if ($params[$i][0] == "nome") {
				$sql .= "".$params[$i][0]." LIKE '%".$params[$i][1]."%'";
			} else {
				$sql .= "".$params[$i][0]."= '".$params[$i][1]."'";
			}
		}
		if (!strpos($sql, " WHERE ")) {
			$sql .= " WHERE status='1'";
		} else {
			$sql .= " AND status='1'";
		}
		if ($typeReturn == "all") { $sql .= " ORDER BY ".$order; }

		if ($pagination) {
			$limit = 10;//20
			$nPag = 1;
			if (isset($_POST['pag'])) {
				$nPag = $_POST['pag'];
			}
			$offset = $limit*($nPag-1);

			$out->limit = $limit;
			$out->nTotal = $conn->query($sql)->num_rows;

			$sql .= " LIMIT ".$limit." OFFSET ".$offset;
		}

		// echo "<br><br><br>".$sql;
		$result = $conn->query($sql);
		$out->num = $result->num_rows;
		$data = array();
		while ($row  = $result->fetch_array()) {
			array_push($data, $row);
		}
		if ($typeReturn == "first" && count($data) > 0) {
			$out->data = $data[0];
		} else {
			$out->data = $data;
		}
		$conn->close();
		return $out;
	}

	public function findByDate($table, $params = [], $order = 'id')
	{
		$out = new stdClass();
		$conn = $this->connect();
		$sql = "SELECT * FROM ".$table." WHERE ";

		$sql .= $params[0][0]." BETWEEN '".$params[0][1]."' AND '".$params[1][1]."'";

		$sql .= " AND status='1'";
		$sql .= " ORDER BY ".$order;

		// echo "<br><br><br>".$sql;
		$result = $conn->query($sql);
		$out->num = $result->num_rows;
		$data = array();
		while ($row  = $result->fetch_array()) {
			array_push($data, $row);
		}
		$out->data = $data;
		$conn->close();
		return $out;
	}

	public function update($table, $data, $ID)
	{
		$out = new stdClass();

		if (isset($data['senha'])) {
			$data['senha'] = md5($data['senha']);
		}

		$typesDate = array('nascimento', 'data', 'data_cirurgia', 'data_retorno', 'data_desobsessao', 'validade', 'data_saida', 'data_passe');
		for ($i=0; $i < count($typesDate); $i++) {
			if (isset($data[$typesDate[$i]])) {
				$data[$typesDate[$i]] = date('Y-m-d', strtotime(str_replace('/', '-', $data[$typesDate[$i]])));
			}
		}

		$conn = $this->connect();
		$key = array_keys($data);
	    $val = array_values($data);
	    $sql = "UPDATE ".$table." SET ";
	    for ($i=0;$i<count($key);$i++) {
	    	$sql .= $key[$i]."='".$val[$i]."'";
	    	if ($i < count($key)-1) {
	    		$sql .= ", ";
	    	} else {
	    		$sql .= ", data_atualizacao='".date('Y-m-d H:i:s')."'";
	    	}
	    }
	    $sql .= " WHERE id='".$ID."' ";
	 	// echo $sql;
	    $out->success = $conn->query($sql);
		$conn->close();

		return $out;
	}

	public function delete($table, $ID)
	{
		$out = new stdClass();

		$conn = $this->connect();
		$sql = "UPDATE ".$table." SET status='0' WHERE id='".$ID."' ";
		$out->success = $conn->query($sql);
		$conn->close();

		return $out;
	}

	public function deletePhysical($table, $ID)
	{
		$out = new stdClass();

		$conn = $this->connect();
		$sql = "DELETE FROM ".$table." WHERE id='".$ID."' ";
		$out->success = $conn->query($sql);
		$conn->close();

		return $out;
	}
	
}
?>