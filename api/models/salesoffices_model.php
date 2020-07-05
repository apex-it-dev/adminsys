<?php
	// include_once('auditlogs.php');
	class SalesOfficesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function getOffices($officeid = ""){
			$res = array();
			$res['err'] = 0;
			$where = "";
			if(!empty($officeid)){
				$where = " AND ". SALESOFFICESMST .".salesofficeid = '$officeid' ";
			}

			$sql = "SELECT ". SALESOFFICESMST .".salesofficeid
						,". SALESOFFICESMST .".name
						,". SALESOFFICESMST .".longname
						,". SALESOFFICESMST .".assignedgm
						,". SALESOFFICESMST .".assignedhr
						,". SALESOFFICESMST .".description
						,". SALESOFFICESMST .".company
						,". SALESOFFICESMST .".incofcs
						,". SALESOFFICESMST .".emailaddress
					FROM ". SALESOFFICESMST ." 
					WHERE ". SALESOFFICESMST .".showmain = 1 $where 
					ORDER BY ". SALESOFFICESMST .".sort";
			// $res['sql'] = $sql;
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func getOffices(). ". $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			return $res;
		}

		public function getSalesOfficeByOfcId($id){
			$res = array();
			// $rows = array();
			$res['err'] = 0;
			//$salesofc = "sscceb";
			$sql = "SELECT " . SALESOFFICESMST . ".* 
					FROM " . SALESOFFICESMST . " WHERE " . SALESOFFICESMST . ".salesofficeid = '$id' ";
			
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func " .__FUNCTION__."()! " . $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows = $row;
			}
			$res['rows'] = $rows;
			exitme:
			// $this->cn->close();
			return $rows;
		}

		public function getSalesOfficesGM($soid=""){
			$res = array();
			$where = "";
			$res['err'] = 0;
			if(!empty($soid)){
				$where .= " AND " . SALESOFFICESMST . ".salesofficeid = '$soid' ";
			}
			$sql = "SELECT " . SALESOFFICESMST . ".* 
						, CONCAT(" . ABAPEOPLESMST . ".`fname`,' '," . ABAPEOPLESMST . ".`lname`,' '," . ABAPEOPLESMST . ".`cnname`) AS gmname 
						, " . ABAPEOPLESMST . ".`workemail` AS gmemail 
					FROM " . SALESOFFICESMST . " 
					LEFT JOIN " . ABAPEOPLESMST . " 
						ON " . ABAPEOPLESMST . ".abaini = " . SALESOFFICESMST . ".assignedgm 
							AND " . ABAPEOPLESMST . ".status = 1 
							AND " . SALESOFFICESMST . ".status = 1 
					WHERE " . SALESOFFICESMST . ".status = 1 $where 
					ORDER BY " . SALESOFFICESMST . ".`sort`";
			// $res['sql'] = $sql;
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getSalesOfficesGM()! " . $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			$this->cn->close();
			return $res;
		}

		public function updateEmailRecipient($data){
			$res = array();
			$res['err'] = 0;

			$ofcid = $data['ofcid'];
			$assignedgm = $data['assignedgm'];
			$status = $data['status'];
			
			$sql = "UPDATE ". SALESOFFICESMST ." 
					SET ". SALESOFFICESMST .".assignedgm = '$assignedgm',
						". SALESOFFICESMST .".showmain = '$status'
					WHERE ". SALESOFFICESMST .".salesofficeid = '$ofcid'";
			// $res['sql'] = $sql;
			$qry = $this->cn->query($sql);

			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getSalesOfficesGM()! " . $this->cn->error;
				goto exitme;
			}

			exitme:
			$this->cn->close();

			return $res;

		}

		public function closeDB(){
			$this->cn->close();
		}
	}

	
?>