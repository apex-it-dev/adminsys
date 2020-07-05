<?php
	// ENCRYPT PASSWORD to MD5
	function generatePassword($pass){
		$salt = "abacareAbvt";
		$md5 = md5($pass . $salt);

		return $md5.":".$salt;
	}

	function genuri($pass){
		$npass = "";
		$salt = "abacare";
		$md5 = md5($pass . $salt);
		$npass = md5($md5);

		return $npass;
	}

	// GENERATE RANDOM STRING
	function generateRandomString($length) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	// HIGHLIGHT TEXT
	function highlightKeywords($text, $keyword) {
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);
		
		for($i=0;$i<$wordsCount;$i++) {
			$highlighted_text = "<span style='font-weight: bold; color: #000; background: #FFFF00;'>$wordsAry[$i]</span>";
			$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
		}

		return $text;
	}

	// DATE FORM DDD D MMM YY
	function dtFormat($val){
		return !empty($val) ? date("D j M y", strtotime($val)) : "";
	}
	function formatDate($format,$val){
		return !empty($val) ? date($format, strtotime($val)) : "";	
	}
	
	function hasAccess($lvl){
		// temporary
		
		$id = $_SESSION['ee']['userid'];
		$ofc = $_SESSION['ee']['ofc'];
		$filteredID = ['A700101-00004'];

		if(!in_array($id,$filteredID)){

			switch($lvl){
				case 1:	// All employee listing, can only see under their ofc if returns false
					// $id = $_SESSION['ee']['userid'];
					$hasAccessList = ['A190410-00134','A181011-00118','A190927-00376','A170810-00000','A161215-00089', 'A180716-00110','A190116-00127','A170123-00090'];
	
					return in_array($id, $hasAccessList);
					break;
				case 2: // Restricts access to higher level modules
					// $id = $_SESSION['ee']['userid']; 
					$itDevs = ['A190410-00134','A161215-00089', 'A180716-00110','A190116-00127'];
					$overrideUser = []; //['A700101-00039']; // A700101-00039=maggie liu
					return ($id == 'A181011-00118' || $id == 'A170810-00000' || $id == 'A190927-00376' || in_array($id, $overrideUser) || in_array($id, $itDevs));
					break;
				default: // With admin access
					$department = $_SESSION['ee']['dept'];
					$position = $_SESSION['ee']['pos'];
					$ranking = $_SESSION['ee']['rank'];
					$overrideUser = $_SESSION['ee']['userid'];
					
					$allowedDept = ['DEPT0007', 'DEPT0006'];
					$allowedPos = ['POS0041','POS0043','POS0046','POS0064','POS0042'];
					// $allowedRank = []; // 1,2
					$overrideUserList = ['A190116-00127','A700101-00043'];
	
					// in_array($ranking, $allowedRank) ||
					return in_array($department, $allowedDept) || in_array($position, $allowedPos) ||  in_array($overrideUser, $overrideUserList);
					break;
			}
	
		} else {
			if($lvl == 0){
				return true;
			} else {
				return false;
			}
		}
	}

	function isGM(){
		$general_manager = 'POS0036';
		$pos = $_SESSION['ee']['pos'];
		
		return $pos == $general_manager;
	}
	
	function officeOnly(){
		// returns the user's office if has access to it, else 'default'
		$id = $_SESSION['ee']['userid'];
		$ofc = $_SESSION['ee']['ofc'];

		$selectedID = ['A700101-00052','A700101-00007'
						,'A700101-00043','A700101-00006'
						,'A190927-00376','A970623-00002'
						,'A700130-00016','A180123-00369','A700101-00008'
						,'A190116-00127'];

		if(in_array($id, $selectedID)){
			return $ofc;
		} else {
			return 'default';
		}
	}
	
	function srcInit($fileLocation){
		/* 
			* adds a timestamp for css or js. eg: mystyle.css?502312
			* timestamp is based on the file's modified date
			* this is to lessen the use of Ctrl+F5 for users
		*/

		$splitURL = explode("/",$_SERVER['PHP_SELF']);
		$splitURL_len = count($splitURL) - 1;

		// if file is deep in the directory, eg: "/login/" within "https://abacare.com/aces/login/login.php"
		$subLocation = '';
		if($splitURL_len > 2){
			foreach($splitURL as $key => $value){
				if($key > 1 && $key < $splitURL_len){ //skip unneeded urls
					$subLocation .= $value . '/';
				}
			}
		}

		// gets the subdomain, eg: "aces" within "https://abacare.com/aces/profile.php"
		$subDomain = $splitURL[1];
		$filePath = $_SERVER['DOCUMENT_ROOT'] . "/" . $subDomain . "/" . $subLocation . $fileLocation;
		$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // get the modified date of the js file and convert it to timestamp
		$fileModified = filemtime($filePath);

        // debug
        // echo date("F d Y H:i:s.", $fileModified);
        
		// tags
		$tagOpen = '';
		$tagClose = '';
		$isSupported = true;
		switch($fileExtension){
			case 'js':
				$tagOpen = '<script defer src="';
				$tagClose = '"></script>';
				break;
			case 'css':
				$tagOpen = '<link href="';
				$tagClose = '" rel="stylesheet">';
				break;
			default:
				$isSupported = false;
				break;
		}

		// return
		if($isSupported){
			echo $tagOpen . $fileLocation . '?' . $fileModified . $tagClose;
		} else {
			echo '';
		}
	}
	
	function var_pre($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	  }
?>