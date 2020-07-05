<div class="card shadow mb-4">
	<div class="card-header py-3 border-bottom-danger">
		<div class="row">
			<div class="col-md-10"> 
				<h3 class="m-0 font-weight-bold text-gray-600">Admin Settings</h3>
			 </div>
			<div class="col-md-2">
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="input-group input-group-sm filter-container col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-1">
				<div class="input-group-prepend labelinput">
					<span class="input-group-text labeltext" id="eename-lbl">Employee:</span>
				</div>
				<select id="txtee" name="eename-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="eename-lbl">
					<option value="" selected></option>
				</select>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-3">
				<div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter" ">
						Menu
					</div>
					<div class="card-body">
						<ul class="list-group list-group-flush" id="menulist">
							<li class="list-group-item">
								No menus added for this module
							</li>
						</ul>
						<div class="row">
							<div class="col-12 mt-3">
								<button title="Update access" type="button" class="btn btn-danger btn-lg float-right apply-filter" id="savemenuaccess" disabled>Save</button>
							</div>
						</div>
						<input type="hidden" id="filter-data" name="filter-data" value="" readonly disabled />
					</div>
				</div>
			</div>
			<!-- <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-3">
				<div class="card">
					<div class="table-responsive">
						<table id="userlist" class="table table-sm table-bordered no-footer table-hover display nowrap">
							<thead class="thead-dark"></thead>
							<tbody></tbody>
						</table>	
					</div>	
				</div>
			</div> -->
			<!-- <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-3">
				<div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter" ">
						View
					</div>
					<div class="card-body">
						<ul class="list-group list-group-flush" id="viewlist">
							<li class="list-group-item">
								No views added for this module
							</li>
							
						</ul>
						<div class="row">
							<div class="col-12 mt-3">
								<button title="Update access" type="button" class="btn btn-danger btn-lg float-right apply-filter" id="saveviewaccess" disabled>Save</button>
							</div>
						</div>
						<input type="hidden" id="filter-data" name="filter-data" value="" readonly disabled />
					</div>
				</div>
			</div> -->
		</div>
	</div>
</div>
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" id="accesses" name="accesses" value="" />
<input type="hidden" id="eemgt" name="eemgt" value="" />