	<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
		<!-- Sidebar - Brand -->
		<div class="card-profile mb-sm-3"> 
			<div class="card-avatar">
				<a href="<?php echo hris_URL; ?>"><img src="<?php echo $avatarpath; ?>"></a>
			</div>
		</div>

		<!-- Divider -->
		<hr class="sidebar-divider my-0">

		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#aces" aria-expanded="false" aria-controls="aces">
				<i class="fas fa-wf fa-circle"></i><span> Aces</span>
			</a>
			<div id="aces" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar" style="">
				<div class="bg-white py-2 collapse-inner rounded">
					<!-- <a class="collapse-item" href="#">Dashboard</a> -->
					<a class="collapse-item" href="aces.php?mod=leavesmgt">Leaves</a>
					<a class="collapse-item" href="aces.php?mod=attendancemgt">Attendance</a>
					<a class="collapse-item" href="aces.php?mod=eemgt">Employees</a>
					<a class="collapse-item" href="aces.php?mod=holidaymgt">Holidays</a>
					<a class="collapse-item" href="aces.php?mod=workingdaysmgt">Working Days</a>
					<a class="collapse-item" href="aces.php?mod=reportsleavemgt">Leave Reports</a>
					<a class="collapse-item" href="aces.php?mod=reportseemgt">Employee Reports</a>
				</div>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#hermes" aria-expanded="false" aria-controls="hermes">
				<i class="fas fa-wf fa-circle"></i><span> Hermes</span>
			</a>
			<div id="hermes" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar" style="">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="hermes.php?mod=bdactivitylogs">BD Activity Logs</a>
					<a class="collapse-item" href="hermes.php?mod=hermesuser">Hermes Users</a>
				</div>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#otherapps" aria-expanded="false" aria-controls="otherapps">
				<i class="fas fa-wf fa-circle"></i><span> Other Apps</span>
			</a>
			<div id="otherapps" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar" style="">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="otherapps.php?mod=suplist">Supplier List</a>
					<a class="collapse-item" href="otherapps.php?mod=mkgrequest">Marketing Request</a>
					<a class="collapse-item" href="otherapps.php?mod=fxrates">FX Rates Import</a>
				</div>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				<i class="fas fa-wf fa-circle"></i><span> Settings</span>
			</a>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar" style="">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="adminusers.php">Admin Users</a>
					<a class="collapse-item" href="email.php">Email</a>
				</div>
			</div>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Sidebar Toggler (Sidebar) -->
		<!-- <div class="text-center d-none d-md-inline"><button class="rounded-circle border-0" id="sidebarToggle"></button></div> -->

	</ul>
<!-- End of Sidebar