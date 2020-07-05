<?php
	include_once("../inc/functions.php");
	include_once("../inc/includes.php");
  	include_once("../inc/sessions.php");

	// file name
	$filename = $_FILES['file']['name'];
	$filesize = $_FILES['file']['size'];
	
	// Location
	$folderlocation = '../upload/tmp/'.$userid.'/';
	
	if(!file_exists($folderlocation)){
		mkdir($folderlocation, 0777, true);
	} else {
		chmod($folderlocation, 0777);
		$filesInFolder = glob($folderlocation . '/*');
		foreach($filesInFolder as $file){
			if(is_file($file))
				unlink($file);
		}
	}

	$location = $folderlocation.$filename;
	
	// file extension
	$file_extension = pathinfo($location, PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);
	
	// Valid image extensions
	$image_ext = array("jpg", "jpeg", "png", "gif","pdf","docx"); 
	
	$response = 0;
	$today = formatDate("Ymd",TODAY);
	if($filesize <= (1*MB)){
		if(in_array($file_extension,$image_ext)){
			$newFileName = $userid . ';' . $today . ';' . md5(rand()) . ';' . str_replace(' ', '' ,$filename);
			$sourcePath = $_FILES['file']['tmp_name'];
			$targetPath = $folderlocation . $newFileName;
			// Upload file
			if(move_uploaded_file($sourcePath,$targetPath)){
				chmod($targetPath, 0777);
				$response = base_URL."upload/tmp/".$userid."/".$newFileName;
			}
		}
	} else {
		$response = 1;
	}
	
	// = 0 : Failed
	// = 1 : File size exceeded
	// else: url
	echo  $response;

?>