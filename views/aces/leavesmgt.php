<div class="card shadow mb-4">
	<div class="card-header py-3 border-bottom-danger">
		<div class="row">
			<div class="col-md-10"> 
				<h3 class="m-0 font-weight-bold text-gray-600">Leaves Management Access Permission</h3>
			 </div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="input-group input-group-sm col-lg-7 col-md-7 col-sm-12">
				<select id="txtee" name="txtee-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="txtee-lbl" hidden></select>
				<div class="d-none d-md-block d-lg-block ml-1"></div>
				<select id="grouptype" name="grouptype-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="grouptype-lbl" style="height:30px;" hidden>
					<option value="department">Department</option>
					<option value="individual">Individual</option>
				</select>
				<div class="d-none d-md-block d-lg-block ml-1"></div>
				<button title="Update group type of this employee" type="button" class="btn btn-danger btn-lg float-right apply-filter" id="updateGroupType" disabled hidden>Update group type</button>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-12">
				<button title="Save permission" type="button" class="btn btn-danger btn-lg apply-filter save_btn float-right" id="save_permission" style="cursor:no-drop;" disabled hidden>Save permissions</button>
			</div>
		</div>
		<hr />
		<div class="row" id="listcontainers">
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-lg-0 mb-4">
				<div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter" ">Menu</div>
					<div class="card-body">
						<ul class="list-group list-group-flush" id="tab_list">
							<li class="list-group-item">No menus added for this module</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-lg-0 mb-4">
				<div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter" ">View</div>
					<div class="card-body">
						<ul class="list-group list-group-flush" id="view_list">
							<li class="list-group-item">No menus added for this module</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-lg-0 mb-4">
				<div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter" ">Actions</div>
					<div class="card-body">
						<ul class="list-group list-group-flush" id="crud_list">
							<li class="list-group-item">No menus added for this module</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter">
						<div class="row">
							<div class="col-6" title="List of notified persons">Notified persons</div>
							<div class="col-6">
								<div class="float-right" title="Add new notified person" id="addNewNotif" style="cursor:pointer;">
									<i class="fas fa-plus-circle"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table id="notifiedlist" class="table table-sm table-bordered no-footer table-hover display nowrap" width="100%">
							<thead class="thead-light"></thead>
							<tbody></tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" id="eemgt" name="eemgt" value="" />
<?php include_once("_modal-leave-notif.php"); ?>