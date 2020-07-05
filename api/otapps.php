<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/employees_model.php');
    require_once('models/menuaccesses_model.php');
    require_once('models/salesoffices_model.php');
    require_once('models/departments_model.php');

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

        $ee = new EmployeesModel;
        $res['ees'] = $ee->getabaees();
        $ee->closeDB();

        $dept = new DepartmentsModel;
        $res['dept'] = $dept->getAllDepartments();
        $dept->closeDB();

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

        return $res;
    }

    function getMenuUserAccess($data){
        $res = array();
        $ee = $data->ee;
        $dept = $data->dept;

        $menuid = $data->mod;
        $module = "otapps";

        $val['menuid'] = $menuid;
        $val['module'] = $module;
        $val['eeuserid'] = $ee;

        $menu = new MenuAccessesModel;
        $individual = $menu->getMenuUserAccess($val);
        if(count($individual['rows']) > 0) {
            $res['accesses'] = $individual;
        } else {
            $val['eeuserid'] = $dept;
            $res['accesses'] = $menu->getMenuUserAccess($val);
        }
        $res['from'] = $val['eeuserid'];
        
        $menu->closeDB();

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

    function getMenuAccess($data){
        $res = array();
        // $ee = $data->ee;

        $menuid = $data->mod;
        $module = "otapps";

        $val['menuid'] = $menuid;
        $val['module'] = $module;
        // $val['eeuserid'] = $ee;
        
        $menu = new MenuAccessesModel;
        $res['eemgt'] = $menu->getMenuAccesses($val);
        $menu->closeDB();

        return $res;
    }

    function getEmailList(){
        $res = array();
        $sofc = new SalesOfficesModel;
        $res['emaillist'] = $sofc->getSalesOfficesGM();
        return $res;
    }

    function switchGroupType($data){
        $res = array();
        $grouptype = $data->grouptype;

        $menuid = $data->mod;
        $module = "otapps";

        $val['menuid'] = $menuid;
        $val['module'] = $module;
        
        $menu = new MenuAccessesModel;
        switch ($grouptype) {
            case 'department':
                $val['eeuserid'] = $data->dept;
                $res['accesses'] = $menu->getMenuUserAccess($val);
                break;
            case 'individual':
                $val['eeuserid'] = $data->ee;
                $res['accesses'] = $menu->getMenuUserAccess($val);
                break;
            default:
                break;
        }
        $res['from'] = $val['eeuserid'];
        $menu->closeDB();
        unset($menu);

        return $res;
    }

    //saves directly to salesoffice table
    function updateEmailRecipient($data){
        $res = array();
        $val = array();

        $ofcid = $data->ofcid;
        $assignedgm = $data->assignedgm;
        $status = $data->status;

        $val['ofcid'] = $ofcid;
        $val['assignedgm'] = $assignedgm;
        $val['status'] = $status;

        $sofc = new SalesOfficesModel;
        $res['updateemail'] = $sofc->updateEmailRecipient($val);
    
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