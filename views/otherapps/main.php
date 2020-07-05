<div class="card shadow mb-4">
<?php
	switch(strtolower($_GET['mod'])){
		case "suplist":
				include_once("$views/supplierlist/supplierlist.php");
			break;
		case "mkgrequest":
				include_once("$views/marketingrequest/marketingrequest.php");
				include_once("$views/marketingrequest/assignemail-modal.php");
			break;
		case "fxrates":
			include_once("$views/fxrates/fxrates.php");
			break;
		default:
			break;
	}
	
?>
</div>
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
