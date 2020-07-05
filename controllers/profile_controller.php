<?php
	// echo $_POST['uploadphoto'];
	if(isset($_POST['uploadphoto']) && !empty($_POST['uploadphoto']) && $_POST['uploadphoto'] == 1){
		
		$tmpname = $_FILES['selectfile']['name'];
		$tmpfile = $_FILES['selectfile']['tmp_name'];
		$fileType = $_FILES['selectfile']['type'];
		$error = $_FILES['selectfile']['error'];
		$filesize = $_FILES['selectfile']['size'];
		$curavatar = $_POST['avatar'];

		$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

		//rename file
		$temp = explode(".", $tmpname);
        $ext = $temp[count($temp)-1];
        $eeid = $_POST['txteeid'];
        if(isset($_GET['action'])){
        	$action = base64_decode($_GET['action']);
        }else{
        	$action = "";
        }
        $val = array();
        switch($action){
        	case 'editcontact':
        		$id = $_GET['id'];
	        	$newfilename = $userid . '.' . $ext;
	        	$val['userid'] = $userid;
	        	// echo $action."<br>".$newfilename."<br>".$id;
       			// exit();
        		break;
        	case 'editprofile':
        		$id = $_GET['id'];
	        	$newfilename = $eeid . '.' . $ext;
	        	$val['userid'] = $eeid;
	        	$curavatar = $newfilename;
	        	// echo $action."<br>".$newfilename."<br>".$id;
       			// exit();
        		break;
        	default:
        		$newfilename = $eeid . '.' . $ext;
        		$val['userid'] = $eeid;
        		$curavatar = $newfilename;
        		// echo $action."<br>".$newfilename."<br>";
       			// exit();
        		break;
        }
		$limitFileSize = 1;
		if($filesize/MB > $limitFileSize*MB){
			echo '<script type="text/javascript">alert("Please upload an image less than ' . $limitFileSize .'MB");</script>';
			goto exitme;
		} else if (in_array($fileType, $arr_file_types)){
			if($error === 0){
				if(file_exists('img/ees/'.$curavatar)){
					unlink('img/ees/'.$curavatar);
				}

              	$filedestination = 'img/ees/' . $newfilename;
				if(!move_uploaded_file($tmpfile, $filedestination)){
					echo '<script type="text/javascript">alert("There was an error uploading your file. Please contact the web administrator.");</script>';
					goto exitme;
				}
				//save file name to database
				$fileWithStamp = $newfilename . '?' . time();
				$val['filename'] = $fileWithStamp ;
				$ees = new EmployeesModel;
				$res = $ees->updateAvatarfile($val);
				$ees ->closeDB(); 

				if($action == 'editcontact'){
					$_SESSION['ee']['avatar'] = $fileWithStamp;
				}elseif($action == 'editprofile'){
					if($eeid == $userid){
						$_SESSION['ee']['avatar'] = $fileWithStamp;
					}
				}
				
				echo '<script type="text/javascript">alert("Profile updated successfully.");</script>';
				goto exitme;
			}else{
				echo '<script type="text/javascript">alert("There was an error uploading your file. Please contact the web administrator.");</script>';
			  	goto exitme;
			}
		}else{
			echo '<script type="text/javascript">alert("Invalid file type.");</script>';
		  	goto exitme;
		}

		exitme:
		if(!empty($action)){
			echo '<script type="text/javascript">
					window.location="profile-edit.php?id='.$id.'&action='. $_GET['action'] .'";
				  </script>';
		}
		
	    exit();
	}
?>