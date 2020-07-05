const menuid = (new window.URLSearchParams(window.location.search)).get('mod').toUpperCase();
let menus = [];
let departmentIdOfEe;
let selectedGroupType;
$(async function(){
    'use strict'; 

	$('#save_email_recpients').on('click', e => blockUI(() => updateEmailRecipient()));

    blockUI(()=> {
        loadDefault(true);
        if(menuid == 'MKGREQUEST'){
			loadEmailList();
		}
    },150);

});

function loadDefault(isInitial = false){
	qryData('aces', 'loadDefault', {mod: menuid}, data => {
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
		$("#txteeassigned").html(eeshtml);

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
						const profileselected = $("#txtee").val();
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

		if(isInitial) getMenuAccess();
		$.unblockUI();
	});
}

function getMenuUserAccess() {
	getMenuAccess(() => {
		$('#updateGroupType')
			.prop('hidden', true)
			.prop('disabled', true);
		qryData('otapps', 'getMenuUserAccess', {ee:$("#txtee").val(), mod: menuid, dept: departmentIdOfEe}, data => {
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
		});
	});
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

function getMenuAccess(callback) {
	qryData('otapps', 'getMenuAccess', {mod:menuid}, data => {
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
	});
}


function cleanCategory(container) {
	$(`#${container}`).html(`<li class="list-group-item">No menus added for this module</li>`);
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
	qryData('otapps', 'switchGroupType', passeddata, data => {
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
	blockUI(() => {
		let accesslist = [];
		let thischecked;
		$(`input:checkbox[name=${menutype}]`).each(function(){
			thischecked = stat != null ? stat : (this.checked ? 1 : 0);
			accesslist.push({acceessid: $(this).attr("id"), status: thischecked }) 
		});
		
		const passeddata = {
			ee: $("#txtee").val(), 
			accesslist: accesslist,
			mod: menuid, 
			app: "otapps", 
			userid: $("#userid").val() 
		};
	
		qryData('otapps', 'updateAccessPermission', passeddata, data => {
			
			$.unblockUI();
		});
	});
}

function loadEmailList(){
    const emaillist = '#emaillist';
        initializeEmailListDatatable(emaillist);
		getEmailList();
		loadEEAssign()
		$('#status').bootstrapToggle({
			on: 'Enabled',
			off: 'Disabled',
			width: '100%'
		});
}

async function loadEEAssign(){
	const qrydata = await qryData('aces', 'loadDefault', {mod: menuid});
	const ees = qrydata.data.ees;
	const depts = qrydata.data.dept;

	if(!qrydata.success) {
        console.log(qrydata.msg);
        $.unblockUI();
        return;
    }

	let eeshtml = "";
	ees.map(ee => {
		eeshtml += `<option value="${ee.abaini}">${ee.fullname}</option>`;
	})
	$("#txteeassigned").html(eeshtml);
	
		
}

async function getEmailList(){
	const qrydata = await qryData('otapps', 'getEmailList', {mod:menuid});
    const emaillist = qrydata.data.emaillist.rows;
    
	if(!qrydata.success) {
        console.log(qrydata.msg);
        $.unblockUI();
        return;
	}
	
	updateEmailListTable(emaillist);

	let ofchtml = "";
	emaillist.map(ofc => {
		ofchtml += `<option value="${ofc.salesofficeid}">${ofc.company}</option>`;
	})
	ofchtml += `</optgroup>`;
	$("#office").html(ofchtml);
}

function updateEmailListTable(data){
    const tableID = '#' + $.fn.dataTable.tables()[0].id;
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

function initializeEmailListDatatable(tableID){
    $(emaillist).DataTable({
        data: [],
        language: {
            emptyTable: '<center>No records found</center>'
        },
        info: false,
        responsive: true,
        paging: false,
        ordering: false,
        columns: [
            {data: 'company', title: 'Office', width:"15%"},
            {data: 'gmname', title: 'Approver', width:"15%"},
			{data: 'gmemail', title: 'Email Address', width:"15%"},
			{
				data: function(data){
					let statusdesc = data.showmain == 1 ? 'Enabled' : 'Disabled';
					return statusdesc;
				}, title: 'Status', width:"15%"
			},
            {
                data: function(data){
                    return `<span style="display: none;">1</span>
                            <a href="#" onClick="return editEmailRecipientModal('${data.salesofficeid}','${data.id}')" title="Edit" class="px-1">
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
	
	//load data to modal form
    $(modal).find('#office').val(rowdata.salesofficeid);
	$(modal).find('#txteeassigned').val(rowdata.assignedgm);
	if(rowdata.showmain == 1) $(modal).find('#status').bootstrapToggle('on');
	$(modal).modal('show');
	
}


async function updateEmailRecipient() {
	const modal = '#Assignemailrecipientmodal';
	await qryData('otapps', 'updateEmailRecipient', {
		ofcid:       $(modal).find('#office').val(),
		assignedgm:  $(modal).find('#txteeassigned').val(),
		status:		 status = $('#status').is(':checked') ? 1 : 0
	});

	//exit modal update table
	$(modal).modal('hide');
	getEmailList();
    $.unblockUI();
}