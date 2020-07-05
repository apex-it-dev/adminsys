/**
* @function qryData Uses callback otherwise return directly
* @param {string} apiName The file name of the API without .php extesion
* @param {string} apiFn The function name from the API
* @param {object} passedData The data that will be passed to apiFn
* @param {function} callback A callback function that returns data
* @param {boolean} debug Enable debug mode
* @returns {object} {success: boolean, data: dataObject, msg: stringMessage}
*/
async function qryData(apiName = '', apiFn = '', passedData = {}, callback, debug = false) {

  // set the return object
  let result = {success: false, data: {}, msg: ''};

  // if reqired object is not fulfilled, return error
  if(apiName === '' || apiFn === '' || typeof passedData !== 'object') {
    result.data = arguments;
    result.msg = 'Parameter error!';
  }

  // fetch data from API
  const fetcheddata = await fetch(`${getAPIURL()}${apiName}.php`, {
    method: 'POST',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ data: {...{'f': apiFn}, ...passedData} })
  }).catch(error => {
    result.data = error;
    result.msg = 'Fetch error!';
  });
  
  if(fetcheddata != undefined) {
    if(fetcheddata.status !== 200) { // if fetching failed
      result.data = {fetchbody: arguments, fetcheddata: fetcheddata};
      result.msg = fetcheddata.statusText;
    } else { // if fetch success
      result.success = true;
      result.data = await fetcheddata.json();
    }
  }
  if(debug) console.log(result); // if debug mode is enabled, console result
  if(callback == undefined) return result; // if callback is not used, return result directly 
  callback(result.data); // if callback is used, call function with the data
}


/* ---------------- start mobile detection ---------------- */
function mobileResponsive() {
  let deviceIsMobile = window.matchMedia('only screen and (max-width: 760px)').matches;
  if (deviceIsMobile) {
    $('#sidebarToggleTop').trigger('click');
  } else {
    $('#accordionSidebar')
      .addClass('toggled')
      .removeClass('toggled');
  }
  //   console.log(`Mobile mode: ${deviceIsMobile}`);
}
  
mobileResponsive();
  
  // when window is resized
  // issue: also triggers when clicking a textbox/inputfield
  /* window.addEventListener('resize', function(event) {
    mobileResponsive();
  });*/
  
  /* ---------------- end mobile detection ---------------- */

  
function serverDateNow(callback) {
  // if(callback == undefined) {
  //   console.log('Callback should be set');
  //   return;
  // }
  $.ajax({
    url: 'inc/getdatetoday.php',
    success: function(data) {
      let newDate = new Date(data);
      if(callback != undefined) callback(newDate);
      return newDate;
    }
  });
}

function blockUI(onBlock, fadeIn = 1000) {
  $.blockUI({
    message: $('#preloader_image'),
    fadeIn: fadeIn,
    onBlock: function() {
      onBlock();
    }
  });
}

function checkImage(imagepath, result) {
  $.ajax({
    type: 'POST',
    url: 'controllers/check_image_exist.php',
    data: {img: imagepath},
    success: function(data) {
      result(data);
    },
    error: function(request, status, err) {
      result(false);
    }
  });
}