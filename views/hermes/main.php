<div class="card shadow mb-4">
<?php
	switch(strtolower($_GET['mod'])){
		case "bdactivitylogs":
				include_once("$views/bdactivitylogs/bdactivitylogs.php");
			break;
		case "hermesuser":
				include_once("$views/hermesusers/hermesusers.php");
			break;
		default:
			break;
	}
	
?>
</div>
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
