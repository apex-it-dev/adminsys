<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/employees_model.php');
    require_once('models/menuaccesses_model.php');
    require_once('models/salesoffices_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
        $f = $json->f;
        $result = $f($json);
        // $result = $json;
    }

    function getEeList($data){
		$res = array();
		$val = array();

		$ofcid = $data->ofcid;
		$val['ofcid'] = $ofcid;
		$val['ofcname'] = '';

		if(!empty($ofcid)){
			$getofc = new SalesOfficesModel;
			$ofc = $getofc->getSalesOfficeByOfcId($ofcid);
			$getofc->closeDB();
			if(count($ofc) > 0) $val['ofcname'] = $ofc['rows'][0]['description'];
		}

		$getee = new EmployeesModel;
		$eelist = $getee->getAllAbaPeopleByOffice($val);
		$getee->closeDB();

		// return only name and userid
		foreach ($eelist['rows'] as $key => $ee) {
			$res['eelist'][$key]['userid'] = str_replace('  ', ' ', $ee['userid']);
			$res['eelist'][$key]['eename'] = str_replace('  ', ' ', $ee['eename']);
		}

		return $res;
    }
    
    function initializeCategories($data){
        $res = array();
        $val = array();
        
        $menuid = $data->menuid;
        $module = $data->module;

        $val['menuid'] = $menuid;
        $val['module'] = $module;

        $menuaccessmodel = new MenuAccessesModel;
        $res['accesses'] = $menuaccessmodel->getMenuAccesses($val);
        $res['userlist'] = $menuaccessmodel->getAllUserMenuAccessbyMenuid($val);
        return $res;
    }

    function getMenuUserAccess($data){
        $res = array();
        $eeuserid = $data->eeuserid;
        $menuid = $data->menuid;
        $module = $data->module;

        $val['menuid'] = $menuid;
        $val['module'] = $module;
        $val['eeuserid'] = $eeuserid;

        $menuaccessmodel = new MenuAccessesModel;
        $res['useraccess'] = $menuaccessmodel->getMenuUserAccess($val);
        $menuaccessmodel->closeDB();

        return $res;
    }

    function updateAccessPermission($data){
        $res = array();
        $ee = $data->ee;
        $accesslist = $data->accesslist;
        $mod = strtoupper($data->mod);
        $app = $data->app;
        $userid = $data->userid;

        $val['eeid'] = $ee;
        $val['accesslist'] = $accesslist;
        $val['userid'] = $userid;
        $val['menuid'] = $mod;
        $val['module'] = $app;

        $menuaccessmodel = new MenuAccessesModel;
        $res['result'] = $menuaccessmodel->updateUserAccess($val);
        
        $menuaccessmodel->closeDB();

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