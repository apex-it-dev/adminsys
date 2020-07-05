<?php
	class DepartmentsModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function getAllDepartments(){
			$res = array();
			$rows = array();
			$res['err'] = 0;

			$sql = "SELECT " .DEPARTMENTSMST. ".departmentid, " .DEPARTMENTSMST. ".description, " .DEPARTMENTSMST. ".status 
					FROM " .DEPARTMENTSMST. "
					WHERE " .DEPARTMENTSMST. ".status = 1";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getAllDepartments()! " . $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			exitme:
			// $this->cn->close();
			return $res;
		}

		public function closeDB(){
			$this->cn->close();
		}
	}
?>