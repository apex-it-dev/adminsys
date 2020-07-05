<?php
	include_once('config.php');
	$today = date("Y-m-d H:i:s");

	// FILES LOCATIONS
	define("ADMIN", base_URL . "admin/");
	define("CSS", base_URL . "css/");
	define("JS", base_URL . "js/");
	define("IMAGES", base_URL . "img/");
	define("FAVICO", IMAGES . "favicon.png");
	define("VIEWS", 'views/');
	define("CONTROLLERS", 'controllers/');
	define("API", 'api/');
	define("LOADER", IMAGES . "abaload.svg");

	// PAGE LOCATIONS
	// HRIS
	// define("EES", base_URL . "ees.php");
	// define("DASHBOARDHRIS", base_URL . "dashboardhris.php");
	define("EESPROFILE", base_URL . "profile.php");

	//HRIS tables
	define("APPLICANTSMST", "hris_applicants");
	define("ATTENDANCESMST", "hris_attendance");
	define("ATTENDANCEMNTRGMST", "hris_attendance_monitoring");
	define("BENEFITSMST","hris_benefits");
	define("POSITIONHISTMST","hris_position_history");
	define("CALENDAREVENTSMST","hris_holidays");
	define("HOLIDAYSMST", "hris_holidays");
	define("WORKINGDAYMST", "hris_workingdays");
	define("LEAVESDTL", "hris_leave_details");
	define("LEAVESMST", "hris_leaves");
	define("LEAVECREDITSMST", "hris_leave_credits");
	define("NOTIFIEDPERSONSMST","hris_notified_persons");
	define("CERTIFICATIONMST","hris_certification");

	// abacare TABLES
	define("ABAUSER","aba_abvt_users");
	define("ABAPEOPLESMST","aba_people");
	define("ABBREVIATIONSMST", "aba_abvt");
	define("COUNTRIESMST","aba_countries");
	define("DEPARTMENTSMST", "aba_departments");
	define("DESIGNATIONSMST", "aba_designations");
	define("DROPDOWNSMST", "aba_dropdown");
	define("ETHNICITYMST", "aba_ethnicities");
	define("FXRATESMST", "aba_fxrates");
	define("NATIONALITYMST", "aba_nationalities");
	define("SALESOFFICESMST", "aba_sales_offices");
	define("MENUACCESS", "aba_menu_accesses");
	define("MENUUSERACCESS", "aba_menu_user_accesses");
	define("ZKTECODEVICESMST","aba_zktecodevices");
	define("MAILSETTINGSMST","aba_email_settings");
	
	// CDM TABLES
	define("CDMACCOUNTS", "aba_cdm_accounts");
	define("CDMACCOUNTSACCESS", "aba_cdm_accounts_access");
	define("CDMACTIVITIES", "aba_cdm_activities");
	define("CDMCONTACTS", "aba_cdm_contacts");
	define("CDMGALINFOS", "aba_cdm_generalinfos");
	define("CDMLEADS", "aba_cdm_leads");
	define("CDMLEADDUPS", "aba_cdm_lead_duplicates");
    define("CDMNOTES", "aba_cdm_notes");
	define("CDMOPPS", "aba_cdm_opportunities");
	define("CDMTASKS", "aba_cdm_tasks");

	// SUPPLIERS TABLES
	define("SUPPLIERS", "aba_suppliers");

	//TO DO LIST TABLES
	define("TODOLISTS","aba_cdm_tdl");
	define("TODOLISTSATRAIL","aba_cdm_tdl_atrail");
	define("USEFULINKS","aba_cdm_usefullinks");

	// TEXT DESCRIPTIONS
	define("TITLE", "abacare Group Limited | ACE System");
	define("TODAY", $today);
	
	// FILE SIZES
	// USAGE 5*MB
	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);
?>