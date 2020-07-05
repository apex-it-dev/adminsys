const menuid = (new window.URLSearchParams(window.location.search)).get('mod').toUpperCase();
let menus = [];
let departmentIdOfEe;
let selectedGroupType;
$(function(){
    'use strict'; 
    blockUI(() => loadDefault(), 150);

});

async function loadDefault(){
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
	})
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
					const deptIsSelected = thisItem.includes('DEPT');
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

	getMenuAccess();
	$.unblockUI();
}

function loadEmailList(){
    const emaillist = '#emaillist';
        initializeEmailListDatatable(emaillist);
        getEmailList();
        loadEEAssign();
}

async function loadEEAssign(){
	const getdata = await qryData('aces', 'getEeList', {ofcid: ''});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		return;
	}
	
	const ees = data.ees.rows;
	const depts = data.dept.rows;

	let eeshtml = "";
	eeshtml += '<option value="">Select employee</option>';
	eeshtml += `<optgroup label="Employees">`;
	ees.map(ee => {
		eeshtml += `<option value="${ee.abaini}">${ee.fname} ${ee.lname}</option>`;
	})
	eeshtml += `</optgroup>`;
	$("#txteeassigned").html(eeshtml);
	

	tail.select("#txteeassigned", {
		search: true,
		descriptions: true,
		width: 255
	});
}

async function getMenuUserAccess() {
	await getMenuAccess();
	$('#updateGroupType')
		.prop('hidden', true)
		.prop('disabled', true);
	const getdata = await qryData('hermes', 'getMenuUserAccess', {
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

async function getMenuAccess(callback) {
	const getdata = await qryData('hermes', 'getMenuAccess', {mod:menuid.toUpperCase()});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		$.unblockUI();
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


function cleanCategory(container) {
	$(`#${container}`).html(`<li class="list-group-item">No menus added for this module</li>`);
}

async function getEmailList(){
	const getdata = await qryData('hermes', 'getEmailList', {mod:menuid.toUpperCase()});
	const data = getdata.data;
	if(!getdata.success) {
		console.log(getdata.msg);
		return;
	}
	updateEmailList(data.emaillist.rows);
}

function updateEmailList(data){
    const tableID = '#' + $.fn.dataTable.tables()[0].id;
    $(tableID)
        .dataTable()
        .fnClearTable();
    if(data.length > 0){
        $(tableID)
            .dataTable()
            .fnAddData(data);
        // $(tableID + ' tbody')
        //     .off('click')
        //     .on('click', 'tr', function (evt) {
        //         const dataTable = $(tableID).DataTable();
        //         if ($(evt.currentTarget.childNodes[0]).hasClass('dataTables_empty')) return false;
        //         const rowdata = dataTable.row(this).data();
        //         loanOfEeForm(rowdata);
        //     });
    }
    
    // 
    if ($(tableID + ' tbody tr td').hasClass('dataTables_empty')) {
        $(tableID + ' tbody').css({'cursor':'no-drop'});
    } else {
        $(tableID + ' tbody').css({'cursor':'pointer'});
    }
    
}

function initializeEmailListDatatable(tableID){
    $(emaillist).DataTable({
        data: [],
        language: {
            emptyTable: '<center>No records fouund</center>'
        },
        info: false,
        responsive: true,
        paging: false,
        ordering: false,
        columns: [
            {data: 'company', title: 'Office', width:"30%"},
            {data: 'gmname', title: 'GM Assigned', width:"30%"},
            {data: 'gmemail', title: 'Email Address', width:"30%"},
            {
                data: function(data){
                    return `<span style="display: none;">1</span>
                            <a href="#" onClick="return editEmailRecipientModal('${data.salesofficeid}','${data.id}')" title="Edit" class="px-1">
                            <i class="fas fa-edit fa-sm text-gray-800" ></i>
                            </a>`;
                }, title:'', width:"5%", classname:'center-align'
            }            
        ],
        rowId: 'id',
    });

    $(tableID + '_wrapper div.row div:first-child')[0].remove(); // remove first div
    $(tableID + '_filter').html('');    // clear filter and replace with custom search
    $('#emaillist_search').on('keyup', function(){
        $(tableID).DataTable().search($(this).val()).draw();
    });

        
    $(tableID + ' thead').css({'font-size':'0.9vw'});
    $(tableID + ' tbody').css({'font-size':'0.8vw'});

    $(emaillist).dataTable().fnClearTable();
}

function editEmailRecipientModal(soid='',id=''){
    const modal = '#Assignemailrecipientmodal';
    const table = $(emaillist).DataTable();
    let rowdata = table.row('#' + id).data();

    $(modal).find('#office').val(rowdata.company);
    $(modal).find('#txteeassigned').html(rowdata.assignedgm);
    $(modal).modal('show');

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


function loadPermissionsOnTypeSelect() {
	const isDepartment = $('#grouptype').val() === 'department';
	$('.switch .permission_toggle').prop('disabled', isDepartment);
	$('.switch .slider').css('cursor', (isDepartment ? 'no-drop' : 'pointer'));
	savePermissionEnabled(!isDepartment && $('#updateGroupType').prop('hidden'));

	const passeddata = {
		ee:$("#txtee").val(),
		mod: menuid, 
		dept: departmentIdOfEe,
		grouptype: $('#grouptype').val()
	};
	qryData('hermes', 'switchGroupType', passeddata, data => {
		const accesslist = data.accesses.rows;
		if(accesslist.length > 0) {
			accesslist.map(accessitem => {
				$(`#${accessitem.menutype}_list`).find(`#${accessitem.accessname}`).attr('checked', accessitem.status == 1);
			});
		}
		$.unblockUI();
	});
}

function updateAccessPermission(menutype, stat = null){
	blockUI(async () => {
		let accesslist = [];
		let thischecked;
		$(`input:checkbox[name=${menutype}]`).each(function(){
			thischecked = stat != null ? stat : (this.checked ? 1 : 0);
			accesslist.push({acceessid: $(this).attr("id"), status: thischecked }) 
		});
		
		const getdata = await qryData('hermes', 'updateAccessPermission', {
			ee: $("#txtee").val(), 
			accesslist: accesslist,
			mod: menuid, 
			app: "hermes", 
			userid: $("#userid").val() 
		});
		const data = getdata.data;
		if(!getdata.success) {
			console.log(getdata.msg);
			return;
		}
	
		$.unblockUI();
	});
}