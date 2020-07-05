function getBaseURL(){
	return "http://localhost:81/aces-dev/";
  // return "http://box5891.temp.domains/~apexhris/apex/";
}

function getAPIURL() {
  return getBaseURL() + 'api/';
}

function getAbbreviationAPIURL() {
  return getAPIURL() + 'abbreviations.php';
}

function getPortalAPIURL(){
  // return "https://www.abacare.com/hris-dev/api/";  
	return getBaseURL() + "api/";
}

function getabaPeopleAPIURL() {
  return getAPIURL() + 'abapeople.php';
}
function isValidEmailAddress(email) {
  var pattern = new RegExp(
    /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i
  );
  return pattern.test(email);
}
function isURL(string) {
  var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
  if (res == null) {
    return false;
  } else {
    return true;
  }
}
function isDate(string) {
  var bol = true;
  if (new Date(string) == 'Invalid Date') {
    bol = false;
  }
  return bol;
}
function getDayOfDate(string) {
  var dt = new Date(string);
  return dt.getDay();
}

function UCFirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function otlk() {
  var appId = '1738770e-d06a-453f-815e-600335e51488';
  var redirectUri = 'https://www.abacare.com/eportal/leadssync.php';
  // var redirectUri = 'http://localhost/eportal/leadssync.php';
  apparr = { appid: appId, redirecturi: redirectUri };

  return apparr;
}
function addCommas(x) {
  if (x == '' || x == null) {
    return x;
  } else {
    var parts = x.toString().split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return parts.join('.');
  }
}

function generateInitial(idFname, idLname, idInit, callback) {
  // remove excess spaces
  function getInitial() {
    let fname = $(idFname).val();
    let lname = $(idLname).val();

    let firstname = fname.trim().replace(/  /g, ' ');
    let lastname = lname.trim().replace(/  /g, ' ');

    // separate names
    let fnames = firstname.split(' ');
    let lnames = lastname.split(' ');

    // count number of names
    let fname_count = fnames.length;
    let lname_count = lnames.length;

    let f_ini = '';
    let l_ini = '';
    let abaini = '';

    switch (fname_count) {
      case 2:
        f_ini = fnames[0].charAt(0);
        f_ini += fnames[1].charAt(0);
        break;
      default:
        // 1 or >3 firstnames
        f_ini = fnames[0].charAt(0);
        f_ini += fnames[0].charAt(1);
        break;
    }

    switch (lname_count) {
      case 2:
        l_ini = lnames[0].charAt(0);
        l_ini += lnames[1].charAt(0);
        break;
      default:
        // 1 or >3 lastnames
        l_ini = lnames[0].charAt(0);
        l_ini += lnames[0].charAt(1);
        break;
    }

    f_ini = f_ini.toLowerCase();
    l_ini = l_ini.toLowerCase();
    abaini = f_ini + l_ini;
    $(idInit).val(abaini);
    if(callback != undefined) {
      callback();
    }
  }

  $(idFname + ',' + idLname)
    .on('change', function() {
      getInitial();
    })
    // .on('keypress', function() {
    //   getInitial();
    // })
    // .on('keydown', function() {
    //   getInitial();
    // })
    .on('keyup', function() {
      getInitial();
    });
}

function checkNull(strToCheck) {
  if (strToCheck == '' || strToCheck == null || strToCheck == 'Mon 01 Jan 1900') {
    return '';
  }
  return strToCheck;
}

function ccyFormat(moneyVal, decimalCount) {
  // console.log('ccyFormat: ' + moneyVal);
  let deci = decimalCount;
  if (typeof deci == 'undefined') {
    deci = 2;
  }
  if (moneyVal == '' || moneyVal == null) {
    return '0.00';
  }
  return addCommas(parseFloat(moneyVal).toFixed(deci));
}

function ccyHandler(ids) {
  // ids = '#id1,#id2,#id3,....'
  $(ids)
    .off('change')
    .on('change', function(e) {
      let tagID = '#' + e.target.id;
      let tagVal = ($(tagID).val()).replace(',','');
      // console.log('ccyOnChange: ' + tagVal);
      if (tagVal == '' || isNaN(tagVal) || tagVal == 'NaN') {
        $(tagID).val('0.00');
      } else {
        $(tagID).val(ccyFormat(tagVal));
      }
    })
    .off('keypress')
    .keypress(function(e) {
      // console.log(e.which);
      if ((e.which < 48 || e.which > 57) && e.which != 44 && e.which != 46) {
        return false;
      }
    });
}

function leaveVals(ids) {
  // ids = '#id1, #id2, #id3';
  $(ids).on('change', function(e) {
    let fieldId = '#' + e.target.id;

    let checkAttrMin = $(fieldId).attr('min');
    let checkAttrStep = $(fieldId).attr('step');

    if (typeof checkAttrMin === typeof undefined || checkAttrMin === false) {
      $(fieldId).attr('min', '0');
    }
    if (typeof checkAttrStep === typeof undefined || checkAttrStep === false) {
      $(fieldId).attr('step', '0.5');
    }

    let newVal = $(fieldId).val();
    if (newVal != '') {
      $(fieldId).val(parseFloat(newVal).toFixed(1));
    }
  });
  $(ids).keypress(function(e) {
    if ((e.which < 48 || e.which > 57) && e.which != 44 && e.which != 46) {
      return false;
    }
  });
}

function monthIntToName(intMonth, monthIsFull) {
  let monthNamesMMMM = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  let monthNamesMMM = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
  if (monthIsFull) {
    return monthNamesMMMM[intMonth - 1];
  } else {
    return monthNamesMMM[intMonth - 1];
  }
}

function truncateStr(str, maxTxt) {
  //trancate's the string str to the length of maxTxt
  if (str == null) str = '';
  if (str.length > maxTxt) {
    return str.substring(0, maxTxt) + '........';
  } else {
    return str;
  }
}

function toTimestamp(strDate) {
  //creates a timestamp from date
  var datum;
  if (strDate == undefined) {
    strDate = serverDateNow(function(data) {
      datum = Date.parse(data);
      return datum / 1000;
    });
  } else {
    datum = Date.parse(strDate);
    return datum / 1000;
  }
}

/**
 * 
 * @param {string} msg 
 * @param {function} onConfirm 
 */
function confirmDialog(msg, onConfirm) {
  let id = '#yesnoDialog';
  if ($(id).length == 0) {
    let dialogModal = '';
    dialogModal += '<div class="modal fade shadow-lg" tabindex="-1" role="dialog" id="yesnoDialog">';
    dialogModal += '  <div class="modal-dialog modal-dialog-centered" role="document">';
    dialogModal += '    <div class="modal-content" style="border-top: 8px solid #e02d1b">';
    dialogModal += '      <div class="modal-header" style="height: 3em;">';
    dialogModal += '        <h5 class="modal-title" style="font-size: 1.1em;">Confirmation</h5>';
    dialogModal += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="height: 2em;">';
    dialogModal += '          <span aria-hidden="true">&times;</span>';
    dialogModal += '        </button>';
    dialogModal += '      </div>';
    dialogModal += '      <div class="modal-body">';
    dialogModal += '        <p id="message"></p>';
    dialogModal += '      </div>';
    dialogModal += '      <div class="modal-footer" style="height: 3em;">';
    dialogModal += '        <button type="button" class="btn btn-sm btn-danger" id="deleteYes" style="min-width: 80px;">Yes</button>';
    dialogModal += '        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="min-width: 80px;">No</button>';
    dialogModal += '      </div>';
    dialogModal += '    </div>';
    dialogModal += '  </div>';
    dialogModal += '</div>';
    $('body').append(dialogModal);
  }
  $('#message').html(msg);
  $('#yesnoDialog').modal('show');
  $('#deleteYes').removeAttr('disabled');
  $('#deleteYes').on('click', function() {
    $(this).attr('disabled', true);
    $('#yesnoDialog').modal('hide');
    $('#deleteYes').off('click');
    if (onConfirm != undefined) onConfirm();
  });
}

function alertDialog(msg, onDialogClose) {
  let id = '#alertmodal';
  if ($(id).length == 0) {
    let dialogModal = '';
    dialogModal += '<div class="modal fade shadow-lg" tabindex="-1" role="dialog" id="alertmodal">';
    dialogModal += '  <div class="modal-dialog modal-dialog-centered" role="document">';
    dialogModal += '    <div class="modal-content" style="border-top: 10px solid #e02d1b">';
    dialogModal += '      <div class="modal-body">';
    dialogModal += '        <h5 id="alertmsg" style="margin: 5px 5px 20px 5px;"></h5>';
    dialogModal += '        <div style="width:100%;" class="text-right">';
    dialogModal += '          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">OK</button>';
    dialogModal += '        </div>';
    dialogModal += '      </div>';
    dialogModal += '    </div>';
    dialogModal += '  </div>';
    dialogModal += '</div>';
    $('body').append(dialogModal);
  }
  $('#alertmsg').html(msg);
  $(id).modal('show');
  $(id).on('keydown', function(event) {
    let keyCode = event.keyCode ? event.keyCode : event.which;
    if (keyCode == 13) {
      $(id).modal('hide');
    }
    $(id).off('keydown');
  });
  if (onDialogClose != undefined) {
    $(id).on('hidden.bs.modal', function() {
      onDialogClose(); // for sequencing
      $(id).off('hidden.bs.modal');
    });
  }
}

// function loaderBlock(blocker, timer) {
//   if (timer == undefined) timer = 1000;
//   $.ajax({
//     url: 'inc/loaderjs.php',
//     success: function(data) {
//       if ($('#preloader_image').length != 0) $('#preloader').remove(); // remove if exist to append it at the bottom
//       $('body').append(data); // appends the loader
//       $.blockUI({
//         message: $('#preloader_image'),
//         fadeIn: timer,
//         onBlock: function() {
//           blocker(); // calls the function that was passed on this functions' parameter
//         }
//       });
//     }
//   });
// }


/* ---------------- start internet explorer ---------------- */
function browserIsIEEdge() {
  var ua = window.navigator.userAgent;

  if (ua.indexOf('MSIE ') > 0) {
    // IE 10 or older => return version number
    // return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    return true;
  } else if (ua.indexOf('Trident/') > 0) {
    // IE 11 => return version number
    // var rv = ua.indexOf('rv:');
    // return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    return true;
  } else if (ua.indexOf('Edge/') > 0) {
    // Edge => return version number
    //  return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    return true;
  }

  // other browser
  return false;
}
/* ---------------- end internet explorer ---------------- */

