$(function() { 
    $('#btnsbSignIn').on('click', function() {
      var msg = 'Are you sure you want to sign in?';
      var param = '';
      checkAttendance(function(signinIsVisible){
        if(signinIsVisible)
          confirmDialog(msg, sbSignIn, param);
      });
    });
  
    $('#btnsbSignOut').on('click', function() {
      var msg = 'Are you sure you want to sign out?';
      var param = '';
      confirmDialog(msg, sbSignOut, param);
    });
  
    $('#btnsbCallin').on('click', function() {
      window.location = 'callin.php';
    });
    
    // $('#btnsbCallIn').on('click', function() {});
    $('#btnLoading').html('Please wait...');
    checkAttendance();
  });
  
  function sbSignIn() {
    var url = getAPIURL() + 'attendance.php';
    var f = 'signInAttendance';
    var userid = $('#txtsbuserid').val();
    var signintype = 'webapp';
  
    // $('#btnsbSignIn').attr('disabled', true); 
    $('#btnsbSignIn').hide();
    $('#btnLoading').html('Signing in...');
    $('#btnLoading').show();
    var data = { f: f, userid: userid, signintype: signintype };
    // console.log(data);
    // return;
    $.ajax({
      type: 'POST',
      url: url,
      data: JSON.stringify({ data: data }),
      dataType: 'json',
      success: function(data) {
        console.log(data);
        // if(data.emptyzk === 1)
        //     alertDialog('ZK ID not found, please approach HR to update your employee profile info.');
        checkAttendance();
        $.unblockUI();
        // return false;
      },
      error: function(request, status, err) {}
    });
  }
  
  function sbSignOut() {
    var url = getAPIURL() + 'attendance.php';
    var f = 'signOutAttendance';
    var userid = $('#txtsbuserid').val();
  
    var data = { f: f, userid: userid };
    // $('#btnsbSignOut').attr('disabled', true);
    $('#btnsbSignOut').hide();
    $('#btnLoading').html('Signing out...');
    $('#btnLoading').show();
    $.ajax({
      type: 'POST',
      url: url,
      data: JSON.stringify({ data: data }),
      dataType: 'json',
      success: function(data) {
        // console.log(data);
  
        checkAttendance();
        $.unblockUI();
        // return false;
      },
      error: function(request, status, err) {}
    });
  }
  
  function checkAttendance(callback) {
    var url = getAPIURL() + 'attendance.php';
    var f = 'checkAttendance';
    var userid = $('#txtsbuserid').val();
  
    var data = { f: f, userid: userid };
    // console.log(url);
    // console.log(data);
    $.ajax({
      type: 'POST',
      url: url,
      data: JSON.stringify({ data: data }),
      dataType: 'json',
      success: function(data) {
        // console.log(data); 
        var loggedout = data['loggedout'];
        var loggedin = data['loggedin'];
        let attendancerec = null;
        if(data.attendacesres.rows.length > 0) attendancerec = data.attendacesres.rows[0];
  
        $('#btnsbSignIn').removeAttr('disabled');
        $('#btnsbSignOut').removeAttr('disabled');
        $('#btnsbCallin').hide();
        $('#btnLoading')
          .html('Please wait...')
          .attr('title','Loading...')
          .attr('disabled',true)
          .css('pointer-events','')
          .removeAttr('class')
          .attr('class','btn btn-info btn-sm')
          .hide();
  
        function defaultAction(){
          $('#btnsbCallin').show();
          if (loggedout == '1900-01-01 00:00:00' || (loggedin != null && loggedout == null))  {
            $('#btnsbSignOut').show();
            $('#btnsbSignIn').hide();
          } else if (loggedout == null) {
            $('#btnsbSignOut').hide();
            $('#btnsbSignIn').show();
          } else {
            $('#btnsbSignOut').hide();
            $('#btnsbSignIn').show();
          }
          callCallback($('#btnsbSignIn').is(':visible'));
        }
  
        if(attendancerec === null){
          defaultAction();
        } else if(attendancerec.onleave == 0){
          defaultAction();
        } else {
          if(attendancerec.onleave == 1) {
            let signedin = loggedout == '1900-01-01 00:00:00';
  
            serverDateNow(function(val){
              let timenow = parseInt(val.getHours()+''+val.getMinutes());
              if(!signedin){
                // if onleave but not whole day
                if((attendancerec.firsthalf == 1 && timenow >= 0 && timenow <= 1330) || 
                   (attendancerec.secondhalf == 1 && timenow > 1330 && timenow <= 2359) || 
                   (attendancerec.wholeday == 1)) {
                    $('#btnsbSignOut').hide();
                    $('#btnsb`SignIn`').hide();
                    if(attendancerec.wholeday == 1) $('#btnsbCallin').hide();
                    $('#btnLoading')
                      .html('On Leave')
                      .attr('title','On Leave')
                      .removeAttr('disabled')
                      .css('pointer-events','none')
                      .removeAttr('class')
                      .attr('class','btn btn-primary btn-sm')
                      .show();
                } else {
                  $('#btnsbSignOut').hide();
                  $('#btnsbSignIn').show();
                }
              } else {
                $('#btnsbSignOut').show();
                $('#btnsbSignIn').hide();
              }
              callCallback($('#btnsbSignIn').is(':visible'));
            });
          }
        }
        function callCallback(signinIsVisible){
          if(callback != undefined) callback(signinIsVisible);
        }
        // $.unblockUI();
        // return false;
      },
      error: function(request, status, err) {}
    });
  }
  