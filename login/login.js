$(document).ready(function () {
  $('#txtUsername').focus();
  checkBrowser();
  $('#btnLogin').on('click', function () {
    var u = $('#txtUsername').val();
    var p = $('#txtPassword').val();

    if (u == '') {
      alertDialog('Username is required! Please enter your username.', function () {
        $('#txtUsername').focus();
      });
      return false;
    }
    if (p == '') {
      alertDialog('Password is required! Please enter your password.', function () {
        $('#txtPassword').focus();
      });
      return false;
    }

    $.blockUI({
      message: $('#preloader_image'),
      fadeIn: 1000,
      onBlock: function () {
        // console.log('OK');
        // return false;
        logMeIn();
        // var url = getBaseURL();
        // window.location = url;
        // console.log(url);
      }
    });
  });

  $('#txtUsername,#txtPassword').keydown(function (event) {
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if (keyCode == 13) {
      if ($('#txtUsername').val() == '') {
        $('#txtUsername').focus();
        return false;
      }
      if ($('#txtPassword').val() == '') {
        $('#txtPassword').focus();
        return false;
      }
      $.blockUI({
        message: $('#preloader_image'),
        fadeIn: 1000,
        onBlock: function () {
          // console.log('OK');
          // return false;
          logMeIn();
          // var url = getBaseURL();
          // window.location = url;
          // console.log(url);
        }
      });
    }
  });

  $('#btnForgot').on('click', function () {
    var u = $('#txtUsername1').val();
    if (u == '') {
      alertDialog('Username is required! Please enter your username.');
      $('#txtUsername1').focus();
      return false;
    }
    $.blockUI({
      message: $('#preloader_image'),
      fadeIn: 1000,
      onBlock: function () {
        // console.log('OK');
        // return false;
        forgotPassword();
        // var url = getBaseURL();
        // window.location = url;
        // console.log(url);
      }
    });
  });
});

function checkBrowser() {
  if (browserIsIEEdge()) {
    $('.intro_text h2').html('');
    $('.login_content').html("Your browser isn't supported, please use a different browser.");
  }
}

function logMeIn() {
  var url = getPortalAPIURL() + 'abauser.php';
  var f = 'logMeIn';
  var u = $('#txtUsername').val();
  var p = $('#txtPassword').val();
  var data = { f: f, u: u, p: p };

  // console.log(url);
  // return false;

  $.ajax({
    type: 'POST',
    url: url,
    data: JSON.stringify({ data: data }),
    dataType: 'json',
    success: function (data) {
      // console.log(data);
      // return false;
      var avatar = 'default.jpg';
      if (data['err'] == 0) {
        // if(data['avatar'] != ""){
        //     avatar = data['avatar'];
        // }
        var res = data['login']['rows'][0];
        if (res.avatarorig != '' && res.avatarorig != null) {
          avatar = res.avatarorig;
        }
        // console.table(res);
        var eename = res['fname'] + ' ' + res['lname'];
        var desig = res['designationname'] == '' || res['designationname'] == null ? res['webhr_designation'] : res['designationname'];
        var ofcname = res['officename'] == '' || res['officename'] == null ? res['webhr_station'] : res['officename'];
        var eaddr = res['workemail'] == '' || res['workemail'] == null ? res['emailaddress'] : res['workemail'];

        $('#abaini').val(res['abaini']);
        $('#abaemail').val(eaddr);
        $('#userid').val(res['userid']);
        $('#eename').val(eename);
        $('#eejobtitle').val(desig);
        $('#ofc').val(ofcname);
        $('#pw').val(res['password']);
        $('#avatar').val(avatar);
        $('#dept').val(res['department']);
        $('#rank').val(res['positiongrade']);
        $('#pos').val(res['designation']);
        // return false;
        $('#frmLogin').submit();
        // window.location = getBaseURL() + 'dashboardcdm.php';
        return false;
      }
      alertDialog(data['errmsg']);
      // return false;
      // var url = getBaseURL();
      // console.log(url);
      // window.location = url;
      $.unblockUI();
    },
    error: function (request, status, err) { }
  });
}

function gotoForgotPW() {
  $('#divLogin').hide();
  $('#divForgotPW').show();
  $('#txtUsername1').focus();
}

function gotoLogin() {
  $('#divLogin').show();
  $('#divForgotPW').hide();
  $('#txtUsername').focus();
}

function forgotPassword() {
  var url = getAPIURL() + 'abauser.php';
  var f = 'forgotPassword';
  var email = $('#txtEmailAddr').val();

  var data = { f: f, email: email };

  // console.log(url);
  // return false;

  $.ajax({
    type: 'POST',
    url: url,
    data: JSON.stringify({ data: data }),
    dataType: 'json',
    success: function (data) {
      // console.log(data);
      // return false;

      alertDialog(data['errmsg']);
      $.unblockUI();
      if (data['err'] > 0) {
        $('#txtEmailAddr').val('');
        gotoForgotPW();
        return false;
      }
      gotoLogin();
    },
    error: function (request, status, err) { }
  });
}
