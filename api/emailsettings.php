<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
	require_once('../../api/RSAUtils/function.php');
    require_once('models/employees_model.php');
    require_once('models/salesoffices_model.php');
    require_once('models/email_model.php');
    // require_once('models/menuaccesses_model.php');
    // require_once('models/departments_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
        $f = $json->f;
        $result = $f($json);
        // $result = $json;
    }

    function getEmailSettings($data) {
        $res = array();

        $emailsettings = new EmailSettingsModel;
        $res['emailsettings'] = $emailsettings->getEmailSettings();
        $emailsettings->closeDB();
        unset($emailsettings);

        // $rsa = new RSAUtilsAba;
        // $res['password'] = $rsa->runRSA(MethodEnum::pubDec, $res['emailsettings']['rows'][0]['password']);
        // unset($rsa);

        return $res;
    }

    function saveEmailSettings($data) {
        $res = array();

        if(!empty($data->password)) {
            $rsa = new RSAUtilsAba;
            $data->password = $rsa->runRSA(MethodEnum::priEnc, $data->password);
            unset($rsa);
        }

        $emailsettings = new EmailSettingsModel;
        $res['emailsettings'] = $emailsettings->saveEmailSettings($data);
        $emailsettings->closeDB();
        unset($emailsettings);

        return $res;
    }

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Expires: 0");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    echo json_encode($result);
?>