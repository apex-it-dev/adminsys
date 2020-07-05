<?php
	class EmailSettingsModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
        }
        
        public function getEmailSettings(){
            $res = array();
            $res['err'] = 0;

            $sql = "SELECT *
                    FROM ". MAILSETTINGSMST ." a
                    WHERE a.id = 1";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func ".__FUNCTION__."(). ". $this->cn->error;
				goto exitme;
			}
            $rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			return $res;
        }

        public function saveEmailSettings($data){
            $res = array();
            $res['err'] = 0;
            $password = '';

            if(!empty($data->password)) {
                $password = ",a.password = '$data->password' ";
            }

            $data->modifieddate = TODAY;

            $sql = "UPDATE ". MAILSETTINGSMST ." a 
                    SET  a.host =           '$data->host'
                        ,a.port =           $data->port
                        ,a.username =       '$data->username'
                        $password
                        ,a.SMTPSecure =     '$data->smtpsecure'
                        ,a.SMTPAuth =       $data->smtpauth
                        ,a.from =           '$data->from'
                        ,a.modifiedby =     '$data->modifiedby'
                        ,a.modifieddate =   '$data->modifieddate'
                    WHERE a.id = 1 ";
			// $res['sql'] = $sql;

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func ".__FUNCTION__."(). ". $this->cn->error;
				goto exitme;
			}

			exitme:
			return $res;
		}

		public function closeDB(){
			$this->cn->close();
		}
	}
?>