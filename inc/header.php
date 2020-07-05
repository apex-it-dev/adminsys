 <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Desktop: Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <li class="nav-item mx-1">
              <a class="nav-link" href="<?php echo hris_URL;?>profile.php">
                  <span class="d-xl-flex d-lg-flex d-md-flex d-sm-flex d-none"><i class="fas fa-user" style="margin-top:3px; height:auto; width: 22px;"></i><span class="font-weight-bold ml-1">aces</span></span>
                  <span class="d-xl-none d-lg-none d-md-none d-sm-none d-flex"><i class="fas fa-user" style="height: auto; width: 18px;"></i></span>
              </a>
            </li>
            <?php if(isset($useraccesshermes['HERMESUSER'])){?>
              <li class="nav-item mx-1">
                <a class="nav-link" href="<?php echo hermes_URL;?>dashboardcdm.php">
                  <span class="d-xl-flex d-lg-flex d-md-flex d-sm-flex d-none"><img src="img/hermes-logo-red.svg" style="height: auto; width: 20px;"><span class="font-weight-bold ml-1">hermes</span></span>
                  <span class="d-xl-none d-lg-none d-md-none d-sm-none d-flex"><img src="img/hermes-logo-red.svg" style="height: auto; width: 18px;"></span>
                </a>
              </li>
            
            <?php }?>
            <div class="topbar-divider"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">Valerie Luna</span> -->
                <img class="img-profile rounded-circle" src="<?php echo $avatarpath; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <?php include('inc/menuprofile.php');?>
            </li>

          </ul>

        </nav>
<!-- End of Topbar -->