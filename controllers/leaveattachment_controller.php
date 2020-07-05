<?php
	include_once("../inc/functions.php");
	include_once("../inc/includes.php");
  	include_once("../inc/sessions.php");
//allowed file types
// $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
 
// if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
//     echo "false";
//     return;
// }
 
// if (!file_exists('uploads')) {
//     mkdir('uploads', 0777);
// }
 
// move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
 
// echo "success";
// die();
	$result = ''; 
	$today = formatDate("Ymd",TODAY);
	// echo $userid;
	chmod('../upload/tmp/', 0777);
	// $filepath = base_URL . 'upload/tmp/';
	if(is_array($_FILES)){ 
		foreach ($_FILES['files']['name'] as $name => $value){ 
			$my_file_name = explode(".", $_FILES['files']['name'][$name]); 
			$extension_name = array("jpg", "jpeg", "png", "gif","pdf","docx"); 
			if(in_array($my_file_name[1], $extension_name)){ 
				$NewImageName = $userid.'-'.$today.'-'.md5(rand()) . '.' . $my_file_name[1]; 
				$SourcePath = $_FILES['files']['tmp_name'][$name]; 
				$TargetPath = '../upload/tmp/'.$NewImageName; 
				if(move_uploaded_file($SourcePath, $TargetPath)) { 
					chmod($TargetPath, 0777);
					$TargetPath = base_URL."upload/tmp/".$NewImageName;
					$result .= '<div class="form-group col-lg-4"><a href="'.$TargetPath.'" target="'.$TargetPath.'"><img src="'.$TargetPath.'" style="width: 100px;"></a></div>'; 
				}
			}else{
				// echo '<script type="text/javascript">alert("Invalid file type.");</script>';
				$result = 'Invalid file type.';
			  	goto exitme;
			} 
		} 
		exitme:
		echo $result; 
	} 
?>