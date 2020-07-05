<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/employees_model.php');
    require_once('models/menuaccesses_model.php');
    require_once('models/salesoffices_model.php');
    require_once('models/departments_model.php');
    require_once('models/notifiedpersons_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
        $f = $json->f;
        $result = $f($json);
        // $result = $json;
    }

    function loadDefault($data){
        $res = array();
        $val = array();
        $mod = $data->mod;

        $ee = new EmployeesModel;
        $ees = $ee->getabaees();
        $ee->closeDB();
        unset($ee);

        $dept = new DepartmentsModel;
        $depts = $dept->getAllDepartments()['rows'];
        $dept->closeDB();
        unset($dept);

        $res['dept'] = $depts;


        $val['menuid'] = $data->mod;
        $val['module'] = "aces";

        $access = new MenuAccessesModel;
        $res['ees'] = array();
        foreach ($ees['rows'] as $eachee) {
            $department = '';
            foreach($depts as $dept) {
                if($dept['departmentid'] == $eachee['department']) {
                    $department = $dept['description'];
                    break;
                }
            }

            $eeaccess = 0;
            $val['ee'] = $eachee['userid'];
            $eeaccess = $access->chkUserIfIndividual($val)['cnt'];

            $res['ees'][] = array(
                'abaini'        =>  $eachee['abaini'],
                'userid'        =>  $eachee['userid'],
                'fullname'      =>  $eachee['fname'] . ' ' . $eachee['lname'],
                'department'    =>  $department,
                'departmentid'  =>  $eachee['department'],
                'accessused'    =>  ($eeaccess > 0 ? 'Individual' : 'Department') . ' access',
                'workemail'     =>  $eachee['workemail'],
                'zkdeviceid'    =>  $eachee['zkdeviceid'],
            );
        }
        $access->closeDB();
        unset($access);
      
        return $res;
    }

    function getMenuAccess($data){
        $res = array();
        // $ee = $data->ee;

        $menuid = $data->mod;
        $module = "aces";

        $val['menuid'] = $menuid;
        $val['module'] = $module;
        // $val['eeuserid'] = $ee;
        
        $menu = new MenuAccessesModel;
        $res['eemgt'] = $menu->getMenuAccesses($val);
        $menu->closeDB();

        return $res;
    }

    function getMenuUserAccess($data){
        $res = array();
        $ee = $data->ee;
        $dept = $data->dept;

        $menuid = $data->mod;
        $module = "aces";

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
        $mod = $data->mod;
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

    function switchGroupType($data){
        $res = array();
        $grouptype = $data->grouptype;

        $menuid = $data->mod;
        $module = "aces";

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

    function getNotifiedList($data) {
        $res = array();
        $val = array();
        
        $val['notifiedids'] = '';
        foreach ($data->notifiedids as $eachid) {
            $val['notifiedids'] .= "'$eachid',";
        }
        $val['notifiedids'] = substr($val['notifiedids'],0,-1);
        
        $getlist = new NotifiedPersons;
        $res['notifiedpersons'] = $getlist->getNotifiedList($val);
        $getlist->closeDB();
        unset($getlist);

        return $res;
    }

    function getOfcList($data) {
        $res = array();

        $getofcs = new SalesOfficesModel;
        $ofclist = $getofcs->getOffices();
        $getofcs->closeDB();
        unset($getofcs);

        $res['ofclist'] = array();
        foreach ($ofclist['rows'] as $eachofc) {
            $res['ofclist'][] = array(
                'id'    =>  $eachofc['salesofficeid'],
                'ini'   =>  $eachofc['description']
            );
        }

        return $res;
    }

    function updateAttendanceNotif($data) {
        $res = array();
        unset($data->f);

        $savenotif = new NotifiedPersons;
        $res['result'] = $savenotif->saveAttendanceNotif($data);
        $savenotif->closeDB();
        unset($savenotif);

        return $res;
    }

    function updateLeaveNotif($data) {
        $res = array();
        unset($data->f);

        $savenotif = new NotifiedPersons;
        $res['result'] = $savenotif->saveLeaveNotif($data);
        $savenotif->closeDB();
        unset($savenotif);

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