<?php
	// include_once('auditlogs.php');
	class MenuAccessesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function getMenuAccesses($data){
			$res = array();
			$res['err'] = 0;
			$menuid = $data['menuid'];
			$module = $data['module'];

			$sql = "SELECT ". MENUACCESS .".menuid
						,". MENUACCESS .".module
						,". MENUACCESS .".accessname
						,". MENUACCESS .".description
						,". MENUACCESS .".menutype 
					FROM ". MENUACCESS ." 
					WHERE ". MENUACCESS .".menuid = '$menuid' 
					AND ". MENUACCESS .".module = '$module'
					AND ". MENUACCESS .".status = 1";
			// $res['sql'] = $sql;

			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func getMenuAccesses(). ". $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			return $res;
		}

		public function getMenuUserAccess($data){
			$res = array();
			$res['err'] = 0;
			$menuid = $data['menuid'];
			$module = $data['module'];
			$userid = $data['eeuserid'];

			$sql = "SELECT ". MENUUSERACCESS .".menuid
						,". MENUUSERACCESS .".module
						,". MENUUSERACCESS .".accessname
						,". MENUACCESS .".description
						,". MENUACCESS .".menutype 
						,". MENUUSERACCESS .".status
					FROM ". MENUUSERACCESS ." 
					LEFT JOIN ". MENUACCESS ."
						ON ". MENUACCESS .".menuid = ". MENUUSERACCESS .".menuid 
							AND ". MENUACCESS .".module = ". MENUUSERACCESS .".module 
							AND ". MENUACCESS .".accessname = ". MENUUSERACCESS .".accessname 
					WHERE ". MENUUSERACCESS .".userid = '$userid' 
					AND ". MENUUSERACCESS .".menuid = '$menuid'
					AND ". MENUUSERACCESS .".module = '$module'
					AND ". MENUUSERACCESS .".status > -1";
			$res['sql'] = $sql;

			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func getMenuUserAccesses(). ". $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			return $res;
		}

		public function saveMenuUserAccess($data){
			$res = array();
			$res['err'] = 0;
			$menuid = $data['menuid'];
			$module = $data['module'];
			$ee = $data['ee'];
			$accessname = $data['accessname'];
			$userid = $data['userid'];
			$today = TODAY;

			$sql = "INSERT INTO ". MENUUSERACCESS ." (menuid,module,userid,accessname,status,createdby,createddate) 
					VALUES('$menuid','$module','$ee','$accessname',1,'$userid','$today') ";
			// $res['sql'] = $sql;

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func saveUserMenuAccess(). ". $this->cn->error;
				goto exitme;
			}

			exitme:
			return $res;
		}

		public function resetMenuUserAccess($ee){
			$res = array();
			$res['err'] = 0;
			// $ee = $data['ee'];

			$sql = "UPDATE ". MENUUSERACCESS ." SET ". MENUUSERACCESS .".status = 0 WHERE ". MENUUSERACCESS .".userid = '$ee' ";
			// $res['sql'] = $sql;

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func resetMenuUserAccess(). ". $this->cn->error;
				goto exitme;
			}

			exitme:
			return $res;
		}

		public function chkMenuUserAccess($data){
			$res = array();
			$res['err'] = 0;
			$menuid = $data['menuid'];
			$module = $data['module'];
			$ee = $data['ee'];
			$accessname = $data['accessname'];

			// $sql = "";
			$sql = "SELECT COUNT(". MENUUSERACCESS .".id) AS cnt 
					FROM ". MENUUSERACCESS ." 
					WHERE ". MENUUSERACCESS .".menuid = '$menuid' 
						AND ". MENUUSERACCESS .".module = '$module' 
						AND ". MENUUSERACCESS .".userid = '$ee' 
						AND ". MENUUSERACCESS .".accessname = '$accessname'";
			// $res['sql'] = $sql;

			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func chkMenuUserAccess(). ". $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['cnt'];
			}
			$res['cnt'] = $cnt;

			exitme:
			return $res;
		}

		public function chkUserIfIndividual($data) {
			$res = array();
			$res['err'] = 0;
			$module = $data['module'];
			$menuid = $data['menuid'];
			$ee = $data['ee'];

			$sql = "SELECT COUNT(". MENUUSERACCESS .".id) AS cnt 
					FROM ". MENUUSERACCESS ." 
					WHERE ". MENUUSERACCESS .".menuid = '$menuid' 
						AND ". MENUUSERACCESS .".module = '$module' 
						AND ". MENUUSERACCESS .".userid = '$ee' 
						AND ". MENUUSERACCESS .".status != -1";
						// $res['sql'] = $sql;

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func ". __FUNCTION__ ."(). ". $this->cn->error;
				goto exitme;
			}
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['cnt'];
			}
			$res['cnt'] = $cnt;

			exitme:
			return $res;
		}

		public function updateMenuUserAccess($data){
			$res = array();
			$res['err'] = 0;
			$menuid = $data['menuid'];
			$module = $data['module'];
			$ee = $data['ee'];
			$accessname = $data['accessname'];
			$status = $data['status'];

			// $sql = "";
			$sql = "UPDATE ". MENUUSERACCESS ." 
					SET ". MENUUSERACCESS .".status = '$status' 
					WHERE ". MENUUSERACCESS .".menuid = '$menuid' 
						AND ". MENUUSERACCESS .".module = '$module' 
						AND ". MENUUSERACCESS .".userid = '$ee' 
						AND ". MENUUSERACCESS .".accessname = '$accessname'";
			// $res['sql'] = $sql;
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func updateMenuUserAccess(). ". $this->cn->error;
				goto exitme;
			}

			exitme:
			return $res;
		}

		public function updateUserAccess($data){
			$res = array();
			$res['err'] = 0;	
			// $sql = array();

			$menuid = $data['menuid'];
			$module = $data['module'];
			$ee = $data['eeid'];
			$accesslist = $data['accesslist'];
			$countaccesslist = count($accesslist);
			$userid = $data['userid'];
			$today = TODAY;

			if($countaccesslist>0){
				$val['ee'] = $ee;
				$val['module'] = $module;
				$val['menuid'] = $menuid;
				for ($i=0; $i < $countaccesslist; $i++) {
					$accessname = $accesslist[$i]->acceessid;
					$status = $accesslist[$i]->status;
					$val['accessname'] = $accessname;
					$chk = $this->chkMenuUserAccess($val);
					if($chk['cnt'] > 0){
						$sql = "UPDATE ". MENUUSERACCESS ." 
								SET ". MENUUSERACCESS .".status = '$status' 
								WHERE ". MENUUSERACCESS .".menuid = '$menuid' 
								AND ". MENUUSERACCESS .".module = '$module' 
								AND ". MENUUSERACCESS .".userid = '$ee' 
								AND ". MENUUSERACCESS .".accessname = '$accessname'";
					}else{
						$sql = "INSERT INTO ". MENUUSERACCESS ." (menuid,module,userid,accessname,status,createdby,createddate) 
								  VALUES('$menuid','$module','$ee','$accessname','$status','$userid','$today') ";
					}
					$qry = $this->cn->query($sql);
					if(!$qry){
						$res['err'] = 1;
						$res['errmsg'] = "An error occured in func updateUserAccess()!". $this->cn->error;
						goto exitme;
					}	
				}
				
			}

			exitme:
			return $res;
		}

		function getAllUserMenuAccessbyMenuid($data){
			$res = array();
			$res['err'] = 0;
			$menuid = $data['menuid'];

			$sql = "SELECT ". MENUUSERACCESS .".menuid
						,". MENUUSERACCESS .".module
						,". MENUUSERACCESS .".accessname
						,". MENUACCESS .".description
						,". MENUACCESS .".menutype 
						,". MENUUSERACCESS .".status
						,CONCAT(b.`fname`, ' ', b.`lname`) AS eename
					FROM ". MENUUSERACCESS ." 
					LEFT JOIN ". MENUACCESS ."
						ON ". MENUACCESS .".menuid = ". MENUUSERACCESS .".menuid 
							AND ". MENUACCESS .".module = ". MENUUSERACCESS .".module 
							AND ". MENUACCESS .".accessname = ". MENUUSERACCESS .".accessname 
					LEFT JOIN ".ABAPEOPLESMST." b
							ON b.`userid` = ". MENUUSERACCESS .".`userid`
					WHERE  ". MENUUSERACCESS .".menuid = '$menuid'
					AND ". MENUUSERACCESS .".status = 1";
			// $res['sql'] = $sql;

			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func getAllUserMenuAccessbyMenuid(). ". $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			return $res;
		}

		public function closeDB(){
			$this->cn->close();
		}
	}
?>