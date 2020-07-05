<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="attendance_notif">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 50%; margin:auto;" >
            <div class="modal-header border-bottom-danger" style="height:55px;">
                <h5 class="modal-title" id="modal-title">Edit notified person</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="input-group input-group-sm filter-container col-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="txteeassigned-lbl">Employee:</span>
                        </div>
                        <select id="txteeassigned" name="txteeassigned-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="txteeassigned-lbl" ></select>
                    </div>
                    <div class="input-group input-group-sm filter-container col-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="office-lbl">Office:</span>
                        </div>
                        <select id="office" name="office-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="office-lbl"></select>
                    </div>
                    <div class="input-group input-group-sm filter-container col-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="emailas-lbl">Email as:</span>
                        </div>
                        <select id="emailas" name="emailas-filter" class="form-control form-control-sm" aria-label="Small" aria-describedby="emailas-lbl">
                            <option value="timesheetreportgm">Recipient</option>
                            <option value="timesheetreporthr">CC</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm filter-container col-12 mb-1">
                        <div class="input-group-prepend labelinput" >
                            <span class="input-group-text labeltext" id="txteeassigned-lbl">Status:</span>
                        </div>
                        <input id="status" type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="danger" data-offstyle="info" data-width="35%">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="height:40px"> 
                <button type="button" class="btn btn-sm btn-danger text-center" id="save-notif">Save</button>
            </div>
        </div>
    </div>
</div>

