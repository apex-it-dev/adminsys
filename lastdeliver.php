<?php
    include_once('inc/global.php');
    include_once('inc/sessions.php');
    if(isset($_SESSION['ee'])) {
    	$protocol = (isset($_SERVER["HTTPS"]) ? 'https' : 'http');
    	$subdomain = explode('/', $_SERVER['REQUEST_URI'])[1];
    	$return_URL = "$protocol://" . $_SERVER['SERVER_NAME'] . '/' . $subdomain;
    	echo "<a href='$return_URL'><button>Return to $subdomain</button></a>";
        echo '<br>';
        echo '<pre>' . shell_exec('git show --summary') . '</pre>';
    } else {
        echo '';
    }
?>