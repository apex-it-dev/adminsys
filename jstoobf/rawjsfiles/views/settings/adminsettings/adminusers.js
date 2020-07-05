$(function(){
    'use strict';

    $("#txtee").change(function(){
        if( $("#txtee").val() == "" ){
            $('#savemenuaccess,#saveviewaccess').attr('disabled',true);
            initializeCategories();
			return false;
		}
        $('#savemenuaccess,#saveviewaccess').attr('disabled',false);
        blockUI(()=> {
            getMenuUserAccess();
            $.unblockUI(); //tmp
        });
    });

    $('#savemenuaccess')
        .off('click')
        .on('click', function(e){
            blockUI(()=> {
                updateAccessPermission('mod');
                $.unblockUI(); //tmp
            });
            
        });

    // $('#saveviewaccess')
    // .off('click')
    // .on('click', function(e){        
    //     blockUI(()=> {
    //         updateAccessPermission('view');
    //         $.unblockUI(); //tmp
    //     });
    // });

    blockUI(()=> {
        loadEeList();
        initializeCategories();
        $.unblockUI(); //tmp
    });

    
});

function loadEeList() {
    $('#txtee').html('<option>Loading...</option>');
    qryData('adminsys', 'getEeList', {ofcid: ''}, data => {
        const eelist = data.eelist;
        let eenamehtml = '<option value="">Select Employee</option>';
        eenamehtml += eelist.map(ee => '<option value="'+ ee.userid +'">'+ ee.eename +'</option>');
        $('#txtee').html(eenamehtml);
        eenamehtml = null; // clean
    });
}

function initializeCategories(){
    const data = {
        module: 'adminsys',
        menuid: 'ADMINSYS'
    }
    qryData('adminsys', 'initializeCategories', data, data => {
        const accesses = data.accesses.rows;
        const userlist = data.userlist.rows;
        if(accesses.length > 0){
            const mods = accesses.filter(function(access){
                return access.menutype == 'mod';
            });
            const views = accesses.filter(function(access){
                return access.menutype == 'view';
            });
    
            //generate list
            genMenuCategory(mods);
            // genViewCategory(views);
            // genUserList("#userlist",userlist);
        }
    });
}

function genMenuCategory(modules){
    let menuhtml = '';
    if(modules.length > 0){
        for(var i=0;i<modules.length;i++){
            let accessnameid = modules[i].accessname;
            menuhtml += '<li class="list-group-item">';
                menuhtml +=  modules[i].description;
                menuhtml +='<label class="switch ">';
                    menuhtml +='<input type="checkbox" name="'+ modules[i].menutype +'" class="primary" id="'+ accessnameid +'">';
                    menuhtml +='<span class="slider round"></span>';
                menuhtml +='</label>';
            menuhtml +='</li>';
        }
        $("#menulist").html(menuhtml);
    }
    // console.log(menuhtml);
}

function genViewCategory(views){
    let viewhtml = '';
    if(views.length > 0){
        for(let i=0;i<views.length;i++){
            let accessnameid = views[i].accessname;
            viewhtml += '<li class="list-group-item">';
                viewhtml +=  views[i].description;
                viewhtml +='<label class="switch ">';
                    viewhtml +='<input type="checkbox" name="'+ views[i].menutype +'" class="primary" id="'+ accessnameid +'">';
                    viewhtml +='<span class="slider round"></span>';
                viewhtml +='</label>';
            viewhtml +='</li>';
        }
        $("#viewlist").html(viewhtml);
    }
    // console.log(viewhtml);
}

function genUserList(tableid, data){
    
}

function updateAccessPermission(menutype){
    let ee = $("#txtee").val();
    let userid = $("#userid").val();
    let accesslist = [];
    $("input:checkbox[name="+ menutype +"]").each(function(){
        this.checked ? accesslist.push({acceessid: $(this).attr("id"), status: 1 }) : accesslist.push({acceessid: $(this).attr("id"), status: 0 });
    });
   
    const data = { 
        ee:ee, 
        accesslist:accesslist, 
        mod:'ADMINSYS', 
        app:'adminsys', 
        userid:userid 
    };
    // console.log(data);
    qryData('adminsys', 'updateAccessPermission', data, data => {
       
    });
   
}

function getMenuUserAccess(){
    const data = {
        module: 'adminsys',
        menuid: 'ADMINSYS',
        eeuserid: $("#txtee").val()
    }
    
    // initializeCategories();
    qryData('adminsys', 'getMenuUserAccess', data, data => {
        const useraccesses = data.useraccess.rows;
        if(useraccesses.length > 0){
            for(var i=0;i<useraccesses.length;i++){
                let accessname = useraccesses[i].accessname;
                let status = useraccesses[i].status;
                if(status == 1){
                    $('#menulist').find("#"+accessname).attr('checked', true);
                }else{
                    $('#menulist').find("#"+accessname).attr('checked', false);
                }
            }
        }else{
            initializeCategories();
        }
    });
}




