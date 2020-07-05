<?php

class NotifiedPersons extends Database{
    private $db = "";
    private $cn = "";

    function __construct(){
        $this->db = new Database();
        $this->cn = $this->db->connect();
    }

    public function saveAttendanceNotif($data){
        $res = array();
        $res['err'] = 0;


        if($data->id == null) {
            $today = TODAY;
            $sql = "
                        INSERT INTO ".NOTIFIEDPERSONSMST." 
                                (notificationtype,userid,ccemailaddress,office,zkdeviceid,status,createdby,createddate)
                        VALUES  ('$data->notificationtype','$data->userid','$data->ccemailaddress','$data->office','$data->zkdeviceid','$data->status','$data->by','$today')
                    ";
        } else {     
            $sql = "
                        UPDATE ".NOTIFIEDPERSONSMST." a 
                        SET  a.notificationtype =   '$data->notificationtype'
                            ,a.userid =             '$data->userid'
                            ,a.ccemailaddress =     '$data->ccemailaddress' 
                            ,a.office =             '$data->office'
                            ,a.zkdeviceid =         '$data->zkdeviceid'
                            ,a.status =             '$data->status'
                        WHERE a.id = $data->id 
                    ";
        }

        $qry = $this->cn->query($sql);
        if(!$qry){
            $res['err'] = 1;
            $res['errmsg'] = "error in func ".__FUNCTION__."(). ". $this->cn->error;
            goto exitme;
        }

        exitme:
        return $res;
    }

    public function saveLeaveNotif($data){
        $res = array();
        $res['err'] = 0;


        if($data->id == null) {
            $today = TODAY;
            $sql = "
                        INSERT INTO ".NOTIFIEDPERSONSMST." 
                                (notificationtype,userid,ccemailaddress,office,zkdeviceid,status,createdby,createddate)
                        VALUES  ('leaveapproved','$data->userid','$data->ccemailaddress','$data->office','$data->zkdeviceid','$data->status','$data->by','$today')
                    ";
        } else {     
            $sql = "
                        UPDATE ".NOTIFIEDPERSONSMST." a 
                        SET  a.userid =             '$data->userid'
                            ,a.ccemailaddress =     '$data->ccemailaddress' 
                            ,a.office =             '$data->office'
                            ,a.zkdeviceid =         '$data->zkdeviceid'
                            ,a.status =             '$data->status'
                        WHERE a.id = $data->id AND a.notificationtype = 'leaveapproved' 
                    ";
        }

        $qry = $this->cn->query($sql);
        if(!$qry){
            $res['err'] = 1;
            $res['errmsg'] = "error in func ".__FUNCTION__."(). ". $this->cn->error;
            goto exitme;
        }

        exitme:
        return $res;
    }
    
    public function getNotifiedList($data) {
        $res = array();
        $res['err'] = 0;
        $data = (object) $data;

        $sql = "SELECT a.*
                        ,CONCAT(b.`fname`, ' ', b.`lname`) AS eename
                        ,c.`description` AS officename 
                FROM ".NOTIFIEDPERSONSMST." a 
                LEFT JOIN ".ABAPEOPLESMST." b 
                    ON b.`userid` = a.`userid` 
                LEFT JOIN ".SALESOFFICESMST." c 
                    ON c.`salesofficeid` = a.`office` 
                WHERE a.`notificationtype` IN ($data->notifiedids) 
                ORDER BY officename ASC
                    ";

        $qry = $this->cn->query($sql);
        if(!$qry){
            $res['err'] = 1;
            $res['errmsg'] = "error in func ".__FUNCTION__."(). ". $this->cn->error;
            goto exitme;
        }
        $rows = array();
        while($row = $qry->fetch_array(MYSQLI_ASSOC)){
            $rows[] = $row;
        }
        $res['rows'] = $rows;

        exitme:
        return $res;
    }
    
    public function closeDB(){
        $this->cn->close();
    }
}

?>