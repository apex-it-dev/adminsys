const menuid = (new window.URLSearchParams(window.location.search)).get('mod').toUpperCase();
let menus = [];
let departmentIdOfEe;
let selectedGroupType;
const notifiedpersons = '#notifiedlist';
const notifiedtableexist = $(notifiedpersons).length > 0;
$(async function(){
	blockUI(async () => {
        const ees = await loadDefault();
        await getMenuAccess();
        if(notifiedtableexist) {
            switch (menuid) {
                case 'ATTENDANCEMGT':
                    if(ees != undefined) await populateNotifModal(ees, '#attendance_notif');
                    initializeAttendanceNotifDatatable(notifiedpersons);
                    break;
                case 'LEAVESMGT':
                    if(ees != undefined) await populateNotifModal(ees, '#leave_notif');
                    initializeLeaveNotifDatatable(notifiedpersons);
                    break;
                default:
                    break;
            }
            await getNotifPerson();

            let notifmodal = '';
            if($('#attendance_notif').length > 0) {
                notifmodal = '#attendance_notif';
            } else if($('#leave_notif').length > 0) {
                notifmodal = '#leave_notif';
            }
            
            if(notifmodal !== '') {
                cleanNotifModal(notifmodal);
                $(notifmodal)
                    .off('hide.bs.modal')
                    .on('hide.bs.modal', e => {
                        cleanNotifModal(notifmodal);
                    });
            }

            $('#addNewNotif')
                .off('click')
                .on('click', (e) => {
                    switch (notifmodal) {
                        case '#attendance_notif':
                            $(notifmodal).find('#save-notif').attr('onClick', `return addAttendanceNotif();`);
                            break;
                        case '#leave_notif':
                            $(notifmodal).find('#save-notif').attr('onClick', `return addLeaveNotif();`);
                            break;
                        default:
                            break;
                    }
                    $(notifmodal).find('#modal-title').html('Add notified person');
                    $(notifmodal).modal('show');
                });
        }
        $.unblockUI();
	}, 150);
});

function cleanNotifModal(notifmodal) {
    switch (notifmodal) {
        case '#attendance_notif':
            $(notifmodal).find('#txteeassigned').val('');
            $(notifmodal).find('#office').val('');
            $(notifmodal).find('#emailas').val('');
            $(notifmodal).find('#status').bootstrapToggle('off');
            $(notifmodal).find('#save-notif').attr('onClick', `return;`);
            break;
        case '#leave_notif':
            $(notifmodal).find('#txteeassigned').val('');
            $(notifmodal).find('#office').val('');
            $(notifmodal).find('#status').bootstrapToggle('off');
            $(notifmodal).find('#save-notif').attr('onClick', `return;`);
            break;
        default:
            break;
    }
}

async function loadDefault() {
	const getdata = await qryData('aces', 'loadDefault', {mod: menuid});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		$.unblockUI();
		return;
	}
	
	const ees = data.ees;
	const depts = data.dept;

	let eeshtml = "";
	eeshtml += '<option value="">Select department or employee...</option>';
	eeshtml += `<optgroup label="Departments">`;
	depts.map(dept => {
		eeshtml += `<option value="${dept.departmentid}">${dept.description}</option>`;
	})
	eeshtml += `</optgroup>`;
	eeshtml += `<optgroup label="Employees">`;
	let abaini = '';
	ees.map(ee => {
		abaini = ee.abaini != null && ee.abaini != '' ? `(${ee.abaini})` : '';
		eeshtml += `<option data-description="${ee.department}" value="${ee.userid}">${ee.fullname} ${abaini}</option>`;
	});
	eeshtml += `</optgroup>`;
	$("#txtee").html(eeshtml);
	
	tail.select("#txtee", {
		search: true,
		descriptions: true,
		width: 400,
		searchConfig: [
			'attributes',
			'text',
			'value'
		],
		cbComplete: function() {
			$("#txtee")
				.off('change')
				.on('change', function(e) {
                    const thisItem = $(`#${this.id}`).val();
					const departmentIdOfEeTmp = ees.find(ee => e.currentTarget.value == ee.userid);
					const deptIsSelected = thisItem.includes('DEPT') || thisItem === '';
					departmentIdOfEe = departmentIdOfEeTmp === undefined ? '' : departmentIdOfEeTmp.departmentid;

					blockUI(() => getMenuUserAccess(), 150);

					$('#grouptype').prop('hidden', deptIsSelected);

					$('#grouptype').off('change');
					if(!deptIsSelected) {
						$('#grouptype').on('change', () => permissionTypeSelect());
					}
				});
		}
	});
    return ees;
}


function savePermissionEnabled(isEnabled) {
	$('.save_btn')
		.prop('disabled', !isEnabled)
		.prop('hidden', !isEnabled)
		.css('cursor', (!isEnabled ? 'no-drop' : 'pointer'));
	
	$('#save_permission').off('click')
	if(isEnabled) {
		$('#save_permission').on('click', function(e) {
			menus.map(menu => updateAccessPermission(menu));
		});
	}
}

async function getMenuAccess(callback) {
	const getdata = await qryData('aces', 'getMenuAccess', {mod: menuid});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		return;
	}
	
	const eemgt = data.eemgt.rows;
	menus = eemgt.map(a => a.menutype).filter((value, index, array) => array.indexOf(value) === index);
	menus.map(menu => {
		if($("#txtee").val() != '') {
			thismenu = eemgt.filter(ee => ee.menutype === menu);
			genCategory(thismenu, `${menu}_list`);
		} else {
			cleanCategory(`${menu}_list`);
		}
	});
	if(callback != undefined) callback();
}

async function getMenuUserAccess() {
	await getMenuAccess();
	$('#updateGroupType')
		.prop('hidden', true)
		.prop('disabled', true);

	const getdata = await qryData('aces', 'getMenuUserAccess', {
		ee:$("#txtee").val(), 
		mod: menuid, 
		dept: departmentIdOfEe
	});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		$.unblockUI();
		return;
	}

	const accesslist = data.accesses.rows;
	const isDepartment = data.from.includes('DEPT');
	const dataFrom = isDepartment ? 'department' : 'individual';
	selectedGroupType = dataFrom;
	$('#grouptype').val(dataFrom);

	const isEnabled = !isDepartment || (isDepartment && $("#txtee").val().includes('DEPT'));
	$('.switch .permission_toggle').prop('disabled', !isEnabled);
	$('.switch .slider').css('cursor', (!isEnabled ? 'no-drop' : 'pointer'));
	savePermissionEnabled(isEnabled);

	if(accesslist.length > 0) {
		accesslist.map(accessitem => {
			$(`#${accessitem.menutype}_list`).find(`#${accessitem.accessname}`).attr('checked', accessitem.status == 1);
		});
	}
	$.unblockUI();
}

function permissionTypeSelect() {
	const updateGroupTypeId = `#updateGroupType`;
	const selectedGroupTypeChanged = selectedGroupType !== $('#grouptype').val();
	const individualIsDefault = selectedGroupType === 'individual';
	$(updateGroupTypeId)
		.prop('hidden', !selectedGroupTypeChanged)
		.prop('disabled', !selectedGroupTypeChanged);


	if(individualIsDefault) {
		blockUI(() => getMenuAccess(() => loadPermissionsOnTypeSelect()), 150);
	} else {
		loadPermissionsOnTypeSelect();
	}


	$(updateGroupTypeId).off('click');
	if(selectedGroupTypeChanged) {
		$(updateGroupTypeId).on('click', function (e) {
			menus.map(menu => updateAccessPermission(menu, individualIsDefault ? -1 : null));
			selectedGroupType = $('#grouptype').val();
			$(updateGroupTypeId)
				.prop('hidden', true)
				.prop('disabled', true);
			savePermissionEnabled(!individualIsDefault);
		});
	}
}


async function loadPermissionsOnTypeSelect() {
	const isDepartment = $('#grouptype').val() === 'department';
	$('.switch .permission_toggle').prop('disabled', isDepartment);
	$('.switch .slider').css('cursor', (isDepartment ? 'no-drop' : 'pointer'));
	savePermissionEnabled(!isDepartment && $('#updateGroupType').prop('hidden'));


	const getdata = await qryData('aces', 'switchGroupType', {
		ee:$("#txtee").val(),
		mod: menuid, 
		dept: departmentIdOfEe,
		grouptype: $('#grouptype').val()
	});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		$.unblockUI();
		return;
	}

	const accesslist = data.accesses.rows;
	if(accesslist.length > 0) {
		accesslist.map(accessitem => {
			$(`#${accessitem.menutype}_list`).find(`#${accessitem.accessname}`).attr('checked', accessitem.status == 1);
		});
	}
	$.unblockUI();
}

function genCategory(menuitems, container) {
	let menuhtml = '';
	menuitems.map(menu => {
		menuhtml += `
			<li class="list-group-item">
				${menu.description}
				<label class="switch">
					<input type="checkbox" name="${menu.menutype}" class="primary permission_toggle" id="${menu.accessname}">
					<span class="slider round"></span>
				</label>
			</li>
		`;
	});
	$(`#${container}`).html(menuhtml);
}

function cleanCategory(container) {
	$(`#${container}`).html(`<li class="list-group-item">No menus added for this module</li>`);
}

function updateAccessPermission(menutype, stat = null){
	blockUI(async () => {
		let accesslist = [];
		let thischecked;
		$(`input:checkbox[name=${menutype}]`).each(function(){
			thischecked = stat != null ? stat : (this.checked ? 1 : 0);
			accesslist.push({acceessid: $(this).attr("id"), status: thischecked }) 
		});
		
		const getdata = await qryData('aces', 'updateAccessPermission', {
			ee: $("#txtee").val(), 
			accesslist: accesslist,
			mod: menuid, 
			app: "aces", 
			userid: $("#userid").val() 
		});
		const data = getdata.data;
		if(!getdata.success) {
			console.log(getdata.msg);
			$.unblockUI();
			return;
		}
		$.unblockUI();
	}, 150);
}


async function getNotifPerson() {
    let notifiedids = [];
    switch (menuid) {
        case 'ATTENDANCEMGT':
            notifiedids = ['timesheetreportgm', 'timesheetreporthr'];
            break;
        case 'LEAVESMGT':
            notifiedids = ['leaveapproved'];
            break;
        default:
            break;
    }
    const getdata = await qryData('aces', 'getNotifiedList', {
        notifiedids: notifiedids,
    });
    const data = getdata.data;
    if(!getdata.success) {
        console.log(getdata.msg);
        $.unblockUI();
        return;
    }

    updateNotifiedListTable(data.notifiedpersons.rows); 
}

function updateNotifiedListTable(data){
    const tableID = notifiedpersons;
    $(tableID)
        .dataTable()
        .fnClearTable();
    if(data.length > 0){
        $(tableID)
            .dataTable()
            .fnAddData(data);
    }
    
    if ($(tableID + ' tbody tr td').hasClass('dataTables_empty')) {
        $(tableID + ' tbody').css({'cursor':'no-drop'});
    } else {
        $(tableID + ' tbody').css({'cursor':'pointer'});
    }
    
}

async function populateNotifModal(ees, modal) {
    $(modal)
        .find('#txteeassigned')
        .html(ees.map(ee => `<option aba-email="${ee.workemail}" aba-zkdeviceid="${ee.zkdeviceid}" value="${ee.userid}">${ee.fullname}</option>`));

    const getdata = await qryData('aces','getOfcList');
    const ofcs = getdata.data;
    if(!getdata.success) {
        console.log(getdata.msg);
        return;
    }

    $(modal)
        .find('#office')
        .html(ofcs.ofclist.map(ofc => `<option value="${ofc.id}">${ofc.ini}</option>`));
}









function initializeAttendanceNotifDatatable(tableID){
    $(notifiedpersons).DataTable({
        data: [],
        language: {
            emptyTable: '<center>No records found</center>'
        },
        searching: false,
        info: false,
        responsive: true,
        paging: false,
		ordering: false,
		scrollY: '35vh',
        columns: [
            {data: 'eename', title: 'Employee name', width:"15%"},
            {data: 'ccemailaddress', title: 'Email address', width:"15%"},
			{data: 'office', title: '', visible: false},
			{data: 'officename', title: 'Assigned Office', width:"15%"},
            {data: data => {
                switch (data.notificationtype) {
                    case 'timesheetreportgm': return 'Recipient'
                    case 'timesheetreporthr': return 'CC';
                    default: return '';
                }
            }, title: 'Email as', width:"15%"},
			{data: data => data.status == 1 ? 'Enabled' : 'Disabled', title: 'Status', width:"15%"},
            {
                data: function(data){
                    return `<a href="#editnotif" onClick="return editAttendanceNotif('${data.id}');" title="Edit" class="px-1">
                                <i class="fas fa-edit fa-sm text-gray-800" ></i>
                            </a>`;
                }, title:'Edit', width:"5%", className: "text-center"
            }            
        ],
		rowId: 'id',
		fnRowCallback: function(row, data){
			if(data.showmain == 0){
				$('td', row).css('background-color', 'Red');
				$('td', row).css('color', '#fff');
			}
		},
    });

    // $(tableID + '_wrapper div.row div:first-child')[0].remove(); // remove first div
    // $(tableID + '_filter').html('');    // clear filter and replace with custom search
    // $('#emaillist_search').on('keyup', function(){
    //     $(tableID).DataTable().search($(this).val()).draw();
    // });

        
    $(tableID + ' thead').css({'font-size':'0.9vw'});
    $(tableID + ' tbody').css({'font-size':'0.8vw'});

    $(notifiedpersons).dataTable().fnClearTable();
}


function editAttendanceNotif(id) {
    const table = $(notifiedpersons).DataTable();
    const rowdata = table.row('#' + id).data();
    
    const modal = '#attendance_notif';
    $(modal).find('#modal-title').html('Edit notified person');
    $(modal).find('#txteeassigned').val(rowdata.userid);
    $(modal).find('#office').val(rowdata.office);
    $(modal).find('#emailas').val(rowdata.notificationtype);
    $(modal).find('#status').bootstrapToggle(rowdata.status == 1 ? 'on' : 'off');
    $(modal).find('#save-notif').attr('onClick', `return updateAttendanceNotif(${id});`);
	$(modal).modal('show');
}

async function updateAttendanceNotif(id) {
    const modal = '#attendance_notif';
    const updatedata = await qryData('aces','updateAttendanceNotif', {
        id:                 id,
        userid:             $(modal).find('#txteeassigned').val(),
        office:             $(modal).find('#office').val(),
        notificationtype:   $(modal).find('#emailas').val(),
        status:             $(modal).find('#status').is(':checked') ? 1 : 0,
        ccemailaddress:     $(modal).find('#txteeassigned option:selected').attr('aba-email'),
        zkdeviceid:         $(modal).find('#txteeassigned option:selected').attr('aba-zkdeviceid'),
        by:                 $('#userid').val()
    });
    $(modal).modal('hide');
    getNotifPerson();
}

async function addAttendanceNotif() {
    const modal = '#attendance_notif';
    const adddata = await qryData('aces','updateAttendanceNotif', {
        id:                 null,
        userid:             $(modal).find('#txteeassigned').val(),
        office:             $(modal).find('#office').val(),
        notificationtype:   $(modal).find('#emailas').val(),
        status:             $(modal).find('#status').is(':checked') ? 1 : 0,
        ccemailaddress:     $(modal).find('#txteeassigned option:selected').attr('aba-email'),
        zkdeviceid:         $(modal).find('#txteeassigned option:selected').attr('aba-zkdeviceid'),
        by:                 $('#userid').val()
    });
    $(modal).modal('hide');
    getNotifPerson();
}




/*
! Leave notified person
*/

function initializeLeaveNotifDatatable(tableID){
    $(notifiedpersons).DataTable({
        data: [],
        language: {
            emptyTable: '<center>No records found</center>'
        },
        searching: false,
        info: false,
        responsive: true,
        paging: false,
		ordering: false,
		scrollY: '35vh',
        columns: [
            {data: 'eename', title: 'Employee name', width:"15%"},
            {data: 'ccemailaddress', title: 'Email address', width:"15%"},
			{data: 'office', title: '', visible: false},
			{data: 'officename', title: 'Assigned Office', width:"15%"},
			{data: data => data.status == 1 ? 'Enabled' : 'Disabled', title: 'Status', width:"15%"},
            {
                data: function(data){
                    return `<a href="#editnotif" onClick="return editLeaveNotif('${data.id}');" title="Edit" class="px-1">
                                <i class="fas fa-edit fa-sm text-gray-800" ></i>
                            </a>`;
                }, title:'Edit', width:"5%", className: "text-center"
            }            
        ],
		rowId: 'id',
		fnRowCallback: function(row, data){
			if(data.showmain == 0){
				$('td', row).css('background-color', 'Red');
				$('td', row).css('color', '#fff');
			}
		},
    });

    // $(tableID + '_wrapper div.row div:first-child')[0].remove(); // remove first div
    // $(tableID + '_filter').html('');    // clear filter and replace with custom search

        
    $(tableID + ' thead').css({'font-size':'0.9vw'});
    $(tableID + ' tbody').css({'font-size':'0.8vw'});

    $(notifiedpersons).dataTable().fnClearTable();
}

function editLeaveNotif(id) {
    const table = $(notifiedpersons).DataTable();
    const rowdata = table.row('#' + id).data();
    
    const modal = '#leave_notif';
    $(modal).find('#modal-title').html('Edit notified person');
    $(modal).find('#txteeassigned').val(rowdata.userid);
    $(modal).find('#office').val(rowdata.office);
    $(modal).find('#status').bootstrapToggle(rowdata.status == 1 ? 'on' : 'off');
    $(modal).find('#save-notif').attr('onClick', `return updateLeaveNotif(${id});`);
	$(modal).modal('show');
}



async function updateLeaveNotif(id) {
    const modal = '#leave_notif';
    const updatedata = await qryData('aces','updateLeaveNotif', {
        id:                 id,
        userid:             $(modal).find('#txteeassigned').val(),
        office:             $(modal).find('#office').val(),
        notificationtype:   $(modal).find('#emailas').val(),
        status:             $(modal).find('#status').is(':checked') ? 1 : 0,
        ccemailaddress:     $(modal).find('#txteeassigned option:selected').attr('aba-email'),
        zkdeviceid:         $(modal).find('#txteeassigned option:selected').attr('aba-zkdeviceid'),
        by:                 $('#userid').val()
    });
    $(modal).modal('hide');
    getNotifPerson();
}

async function addLeaveNotif() {
    const modal = '#leave_notif';
    const adddata = await qryData('aces','updateLeaveNotif', {
        id:                 null,
        userid:             $(modal).find('#txteeassigned').val(),
        office:             $(modal).find('#office').val(),
        status:             $(modal).find('#status').is(':checked') ? 1 : 0,
        ccemailaddress:     $(modal).find('#txteeassigned option:selected').attr('aba-email'),
        zkdeviceid:         $(modal).find('#txteeassigned option:selected').attr('aba-zkdeviceid'),
        by:                 $('#userid').val()
    });
    $(modal).modal('hide');
    getNotifPerson();
}