<div class="modal fade bd-example-modal-lg" role="dialog" aria-hidden="true" id="changePassword">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
  		<div class="modal-header">
  			<h5 class="modal-title" id="exampleModalCenterTitle">Change Password</h5>
  			<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearfields()">
  				<span aria-hidden="true">&times;</span>
  			</button>
  		</div>
  		<div class="modal-body">
        <form method="Post">
        <div class="login-content">
            <div class="form-group"><input class="form-control" type="password" name="txtOldPass" id="txtOldPass" placeholder="Old Password"/></div>
            <div class="form-group"><input class="form-control" type="password" name="txtNewPass" id="txtNewPass" placeholder="New Password" /></div>
            <div class="form-group"><input class="form-control" type="password" name="txtConPass" id="txtConPass" placeholder="Confirm Password" /></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="clearfields()">Cancel</button>
          <button type="button" class="btn btn-danger btn-sm" id="btnChangePass">Change Password</button>
        </div>
        <!-- <input type="hidden" name="txtChangePassReq" id="txtChangePassReq" value="1"  /> -->
        <input type="hidden" name="txtUser" id="txtUser" value="<?php echo $abaini; ?>" />
        </form>
      </div>
    </div>
  </div>
</div>
