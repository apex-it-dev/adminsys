<?php
	// session_destroy();
	session_start();
	if(!empty($_SESSION['ee']['abaini'])){
        // print_r($_SESSION);
      	// exit();
		$abaini = $_SESSION['ee']['abaini'];
		// $accsslvl = $_SESSION['userAccessLvl'];
		$abaemail = $_SESSION['ee']['abaemail'];
		$userid = $_SESSION['ee']['userid'];
		$eename = $_SESSION['ee']['name'];
		$eejt = $_SESSION['ee']['jobtitle'];
		$ofc = $_SESSION['ee']['ofc'];
		
		$rank = $_SESSION['ee']['rank'];
		$dept = $_SESSION['ee']['dept'];
		$pos = $_SESSION['ee']['pos'];
		
		
		
		$acespath = explode('/', hris_URL)[3];
		$avatartmp = $_SESSION['ee']['avatar'];
		$avatarpath = '../'.$acespath.'/'.$_SESSION['ee']['avatarpath'];

		$useraccesshermes = isset($_SESSION['useraccess']['hermes']) ? $_SESSION['useraccess']['hermes'] : null;
		
		if(!isset($_SESSION['useraccess']['adminsys']['ADMINSYS']['hasadminsys'])){
			header("Location: ".hris_URL."");
		}
	}
	if(empty($_SESSION['ee']['abaini'])){
		sessionout();
	}

	function sessionout(){
		$headerprotocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://";
		$urlsub = explode('/', $_SERVER['PHP_SELF']);
		$domain = $urlsub[1];
		unset($urlsub[1]);
		$prevurl = base64_encode($headerprotocol.$_SERVER['HTTP_HOST'].'/'.$domain.implode('/',$urlsub));
		header("Location: ".hris_URL."login/login.php");
		exit();
	}
?>