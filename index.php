<?php 
  include_once("inc/includes.php");
  include_once("inc/sessions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo FAVICO; ?>" type="image/ico" />

  <title><?php echo TITLE; ?></title> 
	
  <link rel="stylesheet" href="css/simple-calendar.css">
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@4/themes/light-border.css"/>
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@4/themes/translucent.css"/>

  <script src="https://unpkg.com/popper.js@1/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tippy.js@4"></script>

  <!--	flags-->
	<link href="vendor/flag-icon-css-master/assets/docs.css" rel="stylesheet">
	<link href="vendor/flag-icon-css-master/css/flag-icon.css" rel="stylesheet">
	
  <!-- Custom fonts for this template-->
 <?php include_once('inc/bs-css.php'); ?>

<!--	Fullcalendar-->
	<!-- <link href="vendor/fullcalendar/packages/daygrid/main.css" rel="stylesheet"/>
	<link href="vendor/fullcalendar/packages/bootstrap/main.css" rel="stylesheet"/>
	<link href="vendor/fullcalendar/packages/list/main.css" rel="stylesheet"/>
	<link href="vendor/fullcalendar/packages/core/main.css" rel="stylesheet"/>
 -->

  
</head>

<body id="page-top">

 
  <!-- Page Wrapper -->

  <div id="wrapper">
     <!-- <div class="sidebar-primary"> -->
    <?php include_once('inc/sidebar.php');?>
  <!-- </div> -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">       

        <?php include_once('inc/header.php');?>
          <!-- Begin Page Content -->
        <?php //include_once('views/dashboard.php');?>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <?php include_once('inc/footer.php');?>
    </div>
    <!-- End of Content Wrapper -->
  </div>

  <!-- End of Page Wrapper -->
  <?php include_once('inc/loader.php');?>
  <?php include_once('inc/scrolltotop.php');?>
  <?php include_once('inc/logoutmodal.php')?>
  <?php include_once('inc/jquery.php')?>
	
	<!-- <script src="build/js/custom.js"></script> -->

  <!-- Page level plugins -->

	<!-- <script src="vendor/fullcalendar/packages/core/main.js"></script>
	<script src="vendor/fullcalendar/packages/daygrid/main.js"></script>
	<script src="vendor/fullcalendar/packages/interaction/main.js"></script>
	<script src="vendor/fullcalendar/packages/list/main.js"></script>
	<script src="vendor/fullcalendar/packages/moment/main.js"></script> -->

  <!-- clock -->
  <!-- <script src="vendor/CanvasClock-master/canvas_clock.js"></script> -->
  <!--	flags-->
	<!-- <script src="vendor/flag-icon-css-master/assets/docs.js"></script> -->

  <!-- <script src="js/jquery.simple-calendar.min.js"></script> -->
  <!-- <script src="js/jquery.simple-calendar.min.js"></script> -->

	<!-- <script src="<?php //echo VIEWS . "dashboard.js"; ?>"></script> -->
</body>

</html>
