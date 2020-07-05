<?php
	// include_once('auditlogs.php');
	class EmployeesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function getabaees($userid = ""){
			$res = array();
			$res['err'] = 0;
			$where = "WHERE 1 ";
			if(!empty($userid)){
				$where .= " AND ". ABAPEOPLESMST .".userid = '$userid' ";
			}

			$sql = "SELECT " . ABAPEOPLESMST . ".*
						,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`designationid` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`salesofficeid` = " . ABAPEOPLESMST . ".`office` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. $where . " AND " . ABAPEOPLESMST . ".status = 1 AND " . ABAPEOPLESMST . ".contactcategory = 1 "
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini` ";
			// $res['sql'] = $sql;
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in func getabaees(). ". $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			exitme:
			return $res;
		}

		public function getAllAbaPeopleByOffice($data){
            $ofcid = $data['ofcid'];
			$ofcname = $data['ofcname'];
			$ofcwhere = "";
			if($ofcname != '' && $ofcid != ''){
				$ofcwhere = "AND (" . ABAPEOPLESMST . ".webhr_station = '$ofcname' OR " . ABAPEOPLESMST . ".office = '$ofcid')";
			}
            $res = array();
            $rows = array();
            $res['err'] = 0;
            // $where .= " AND " . ABAPEOPLESMST . ".userid = '$id'";
            $contactsinfo = "" . ABAPEOPLESMST . ".emailaddress, " . ABAPEOPLESMST . ".mobileno, " . ABAPEOPLESMST . ".homephoneno, 
                             " . ABAPEOPLESMST . ".wechat, " . ABAPEOPLESMST . ".skype, " . ABAPEOPLESMST . ".whatsapp, " . ABAPEOPLESMST . ".linkedin,    
                             " . ABAPEOPLESMST . ".presentaddress, " . ABAPEOPLESMST . ".presentcity, " . ABAPEOPLESMST . ".presentstate, " . ABAPEOPLESMST . ".presentzipcode, 
                             " . ABAPEOPLESMST . ".presentcountry, " . ABAPEOPLESMST . ".emercontactperson, " . ABAPEOPLESMST . ".emercontactno, " . ABAPEOPLESMST . ".emercontactrelation"; 

            $personaldata = "" . ABAPEOPLESMST . ".fname, " . ABAPEOPLESMST . ".mname, " . ABAPEOPLESMST . ".lname, " . ABAPEOPLESMST . ".nationality, " . ABAPEOPLESMST . ".maritalstatus, 
                             " . ABAPEOPLESMST . ".birthdate, " . ABAPEOPLESMST . ".gender
                             ";

            $employeedata = "" . ABAPEOPLESMST . ".joineddate," . ABAPEOPLESMST . ".office, " . ABAPEOPLESMST . ".webhr_designation,
            				 " . ABAPEOPLESMST . ".designation, " . ABAPEOPLESMST . ".departmentname, 
                             " . ABAPEOPLESMST . ".department," . ABAPEOPLESMST . ".eetype, " . ABAPEOPLESMST . ".eecategory," . ABAPEOPLESMST . ".reportsto," . ABAPEOPLESMST . ".webhr_station,
                             " . ABAPEOPLESMST . ".officephoneno," . ABAPEOPLESMST . ".reportstoindirect," . ABAPEOPLESMST . ".positiongrade, " . ABAPEOPLESMST . ".workemail," . ABAPEOPLESMST . ".officephoneno," . ABAPEOPLESMST . ".workskype," . ABAPEOPLESMST . ".reportstoid," . ABAPEOPLESMST . ".reportstoindirectid";

            $sql = "SELECT " . ABAPEOPLESMST . ".userid, " . ABAPEOPLESMST . ".sesid, " . ABAPEOPLESMST . ".avatarorig," . ABAPEOPLESMST . ".abaini, $personaldata, $contactsinfo, $employeedata
                        ,DATE_FORMAT(" . ABAPEOPLESMST . ".birthdate, '%a %d %b %Y') AS birthdt
                        ,DATE_FORMAT(" . ABAPEOPLESMST . ".joineddate, '%a %d %b %Y') AS joindt
                        ,CONCAT(
                            (CASE WHEN " . ABAPEOPLESMST . ".fname != '' THEN " . ABAPEOPLESMST . ".fname ELSE '' END),' '
                            ,(CASE WHEN " . ABAPEOPLESMST . ".mname != '' THEN " . ABAPEOPLESMST . ".mname ELSE '' END),' '
                            ,(CASE WHEN " . ABAPEOPLESMST . ".lname != '' THEN " . ABAPEOPLESMST . ".lname ELSE '' END)) as eename
                        ,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname                        
                        ,a.description as designationnamedesc
                        ,b.description as officename
                        ,c.description as nationalitydesc
                        ,d.dddescription as eetypedesc
                        ,e.dddescription as eecategorydesc
                        ,f.dddescription as maritalstat
                    FROM " . ABAPEOPLESMST. 
                    " LEFT JOIN " . DESIGNATIONSMST . " a
                        ON a.designationid = " . ABAPEOPLESMST . ".designation 
                      LEFT JOIN " . SALESOFFICESMST . " b
                          ON b.salesofficeid = " . ABAPEOPLESMST . ".office 
                      LEFT JOIN " . NATIONALITYMST . " c
                          ON c.nationalityid = " . ABAPEOPLESMST . ".nationality 
                      LEFT JOIN " . DROPDOWNSMST . " d
                          ON d.ddid = " . ABAPEOPLESMST . ".eetype
                          AND d.dddisplay = 'eetype' 
                      LEFT JOIN " . DROPDOWNSMST . " e
                          ON e.ddid = " . ABAPEOPLESMST . ".eecategory
                          AND e.dddisplay = 'eecategory' 
                      LEFT JOIN " . DROPDOWNSMST . " f
                          ON f.ddid = " . ABAPEOPLESMST . ".maritalstatus
                          AND f.dddisplay = 'maritalstatus' 
                      WHERE " . ABAPEOPLESMST . ".status = 1 
                          AND " . ABAPEOPLESMST . ".contactcategory = 1 
						  $ofcwhere
                      ORDER BY " . ABAPEOPLESMST . ".abaini " ;
            $res['sql'] = $sql;
            $qry = $this->cn->query($sql);
            if(!$qry){
                $res['err'] = 1;
                $res['errmsg'] = "An error occured in func getAllAbaPeople()! " . $this->cn->error;
                goto exitme;
            }
            while($row = $qry->fetch_array(MYSQLI_ASSOC)){
                $rows[] = $row;
            }

            $res['rows'] = $rows;

            exitme:
            // $this->cn->close();
            return $res;
        }

		public function closeDB(){
			$this->cn->close();
		}
	}
?>