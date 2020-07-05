<?php
	$payload = json_decode(file_get_contents('php://input'));
    if($payload) if($payload->ref === "refs/heads/master") shell_exec('sh dev-pull');
?>