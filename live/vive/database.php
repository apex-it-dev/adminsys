<?php
	class Database{
		private $cn = "";
		function connect(){
			$cn = new mysqli("localhost", "root", "", "aba_abvt_dev");
			$cn->set_charset("utf8");

			if ($cn->connect_error) {
			    die("Connection failed: " . $cn->connect_error);
			    exit();
			} 

			return $cn;
		}

		function closeDB(){
			mysqli_close($cn);
			unset($cn);
			$cn = null;
		}
	}
?>