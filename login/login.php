<?php 
  include_once("../inc/includes.php");
  if(isset($_POST['log']) && !empty($_POST['log']) && $_POST['log'] == 1){

    if(isset($_POST['abaini']) && !empty($_POST['abaini']) && isset($_POST['abaemail']) && !empty($_POST['abaemail'])){
      // print_r($_POST);
      // exit();
      session_start();
      $abaini = $_POST['abaini'];
      $abaemail = $_POST['abaemail'];
      $userid = $_POST['userid'];
      $name = $_POST['eename'];
      $jobtitle = $_POST['eejobtitle'];
      $ofc = $_POST['ofc'];
      $pw = $_POST['pw'];
      $avatar = $_POST['avatar'];
      $dept = $_POST['dept'];
      $rank = $_POST['rank'];
      $pos = $_POST['pos'];

      $_SESSION['ee'] = array("abaini"  => $abaini,
                              "abaUser" => $abaini,
                              "abaemail"=> $abaemail,
                              "userid"  => $userid,
                              "name"    => $name,
                              "jobtitle"=> $jobtitle,
                              "ofc"     => $ofc,
                              "pw"      => $pw,
                              "avatar"  => $avatar,
                              "rank"    => $rank,
                              "dept"    => $dept,
                              "pos"     => $pos);
      // echo '<script type="text/javascript">alert("'.$_SESSION['ee'].'");</script>';
      switch($jobtitle){
        case "business development executive": case "business development manager": case "business development director": case "senior business development manager":
              case "business development supervisor":
        case "general manager hong kong": case "general manager beijing": case "general manager for china": case "general manager singapore": case "general manager":
        case "life insurance manager": case "life insurance executive": case "ceo": case "chairman": case "chief operating officer":
        case "client service director": case "client servicing assistant manager - corporate": case "client servicing assistant manager - individual": 
        case "client servicing director": case "client servicing manager": case "client servicing manager - corporate": case "client servicing manager - individual":
      	case "account executive - corporate": case "account executive - individual": case "account supervisor - corporate": case "account supervisor - individual":
              header("Location: ".hermes_URL."dashboardcdm.php");
            exit();
          break;
        default:
          break;
      }
      // echo '<script type="text/javascript">alert("'.$abaini.'");</script>';
      switch($abaini){
        case "dummy": case "loam":  case "reca": case "vive": case "jacl": case "raoc":
              header("Location: ".hermes_URL."dashboardcdm.php");
            exit();
          break;
        default:
          break;
      }
      
      header("Location: ".base_URL."profile.php");
      exit();
    }
    header("Location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo FAVICO; ?>" type="image/ico" />

    <title><?php echo TITLE; ?></title>

    <?php include_once('bootstrap.php'); ?>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Varela+Round&display=swap" rel="stylesheet">
  <?php srcInit('css/style-for-login.css'); ?>
  </head>

  <body class="login">
    <div>

      <div class="login_wrapper">
        <div class="intro_text">
              <h1>ACE System</h1>
            <h2>Login to start</h2> 
        </div>
        <div class="animate form login_form">
          <section class="login_content">
            <form method="Post" id="frmLogin" name="frmLogin">
             <span id="divLogin">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" placeholder="Username (abaini: i.e. pmhe)" required="" id="txtUsername" name="txtUsername" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input type="password" class="form-control" placeholder="Password" required="" id="txtPassword" name="txtPassword" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-center ">
                    <input type="button" id="btnLogin" class="btn btn-danger" name="btnLogin" value="Login" />
                    <!-- <button class="btn btn-danger" id="btnLogin" name="btnLogin">Log in</button> -->
                  </div>
                  <!-- <div class="col-lg-6 col-sm-6 col-xs-12 text-left mt-5"> -->
                    <a class="reset_pass pull-left" href="#" onClick="gotoForgotPW();" style="margin-left:1em;">Forgot Password</a>
                  <!-- </div> -->
                  <!-- <div class="col-lg-6 col-sm-6 col-xs-12 text-right mt-5"> -->
                    <a class="reset_pass pull-right" href="<?php echo hermes_URL;?>portal" style="margin-right:1em;">Abbreviation</a>
                  <!-- </div> -->
                </div>
              </span>
              <span id="divForgotPW" style="display: none;">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" placeholder="Email Address" required="" id="txtEmailAddr" name="txtEmailAddr" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-center ">
                    <input type="button" id="btnForgot" class="btn btn-danger" name="btnForgot" value="Send Password" style="width: 100%;" />
                    <!-- <button class="btn btn-danger" id="btnLogin" name="btnLogin">Log in</button> -->
                  </div>
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-left mt-5">
                    <a class="reset_pass" href="#" onClick="return gotoLogin();">Go Back to Login</a>
                  </div>
                </div>
              </span>
              <div class="clearfix"></div>

              <div class="separator">

                <div>
                  <img class="login_logo" src="images/logo.png">
                  <p>©2017 All Rights Reserved. Privacy and Terms</p>
                </div>
              </div>
              <input type="hidden" id="abaini" name="abaini" value="" />
              <input type="hidden" id="abaemail" name="abaemail" value="" />
              <input type="hidden" id="userid" name="userid" value="" />
              <input type="hidden" id="eename" name="eename" value="" />
              <input type="hidden" id="eejobtitle" name="eejobtitle" value="" />
              <input type="hidden" id="ofc" name="ofc" value="" />
              <input type="hidden" id="log" name="log" value="1" />
              <input type="hidden" id="pw" name="pw" value="" />
              <input type="hidden" id="avatar" name="avatar" value="" />
              <input type="hidden" id="dept" name="dept" value="" />
              <input type="hidden" id="rank" name="rank" value="" />
              <input type="hidden" id="pos" name="pos" value="" />
            </form>

          </section>
        </div>
      </div>
    </div>
    <?php include_once('../inc/loader.php');?>
    <?php include_once('jquery.php'); ?>
    <?php srcInit('login.js'); ?>
  </body>
</html>