<?php

    if(!isset($_GET['user'])){
        include_once('../inc/sessions.php');
        $user = $_SESSION['ee']['abaini'];
    } else {
        $user = $_GET['user'];
    }
    $domain = $_SERVER['HTTP_HOST'];
    $subdomain = explode('/', $_SERVER['PHP_SELF'])[1];
    $islocal = strpos($domain, 'localhost') !== FALSE || strpos($domain, '.local') !== FALSE;
    if(!$islocal) header('Location: 404');

    $setupexist = file_exists("$user/");
    $protocol = (isset($_SERVER["HTTPS"]) ? 'https' : 'http');
    if($setupexist){
        $setupfile = array(
            array("userfile"=>"$user/config.js", "destination"=>"../js/config.js"),
            array("userfile"=>"$user/config.php", "destination"=>"../inc/config.php"),
            array("userfile"=>"$user/database.php", "destination"=>"../api/models/database.php"),
            array("userfile"=>"$user/database.php", "destination"=>"../inc/database.php"),
        );
        // var_dump($setupfile);

        // move each file
        foreach ($setupfile as $key => $file) {
            if(file_exists($file['userfile'])) copy($file['userfile'], $file['destination']);
        }
        
        echo '<script>alert("Done"); window.location.replace("'.$protocol.'://'.$domain.'/'.$subdomain.'/");</script>';
    }

?>