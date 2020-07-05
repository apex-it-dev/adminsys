<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="Assignemailrecipientmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 50%; margin:auto;" >
            <div class="modal-header border-bottom-danger">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Email Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="input-group input-group-sm filter-container col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="office-lbl">Office:</span>
                        </div>
                        <!-- <input id="office" name="office-filter" type="text" class="form-control form-control-sm" readonly value="" disabled aria-label="Small" aria-describedby="office-lbl"> -->
                        <select id="office" name="office-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="office-lbl" readonly disabled></select>
                    </div>
                    <div class="input-group input-group-sm filter-container col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="txteeassigned-lbl">Employee:</span>
                        </div>
                        <select id="txteeassigned" name="txteeassigned-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="txteeassigned-lbl" ></select>
                    </div>
                    <div class="input-group input-group-sm filter-container col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="txteeassigned-lbl">Status:</span>
                        </div>
                        <input id="status" type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-width="25%">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="height:40px"> 
                <button type="button" class="btn btn-sm btn-primary text-center" id="save_email_recpients">Save</button>
            </div>
        </div>
    </div>
</div>

