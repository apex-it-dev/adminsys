<div class="card shadow mb-4">
	<div class="card-header py-3 border-bottom-danger">
		<div class="row">
			<div class="col-md-10"> 
				<h3 class="m-0 font-weight-bold text-gray-600">Email Settings</h3>
			 </div>
			<div class="col-md-2">
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="mr-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card">
					<div class="card-header text-light font-weight-bold" id="headingFilter">Settings</div>
					<div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="host" class="col-lg-2 col-sm-4 col-form-label">Host:</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="host" placeholder="smtp.service.com" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="port" class="col-lg-2 col-sm-4 col-form-label">Port:</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <input type="number" class="form-control form-control-sm" id="port" placeholder="587" min="1" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="username" class="col-lg-2 col-sm-4 col-form-label">Username:</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="username" placeholder="user@abacare.com" autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="password" class="col-lg-2 col-sm-4 col-form-label">Password:</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <input type="password" class="form-control form-control-sm" id="password" placeholder="(unchanged)" autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="smtpsecure" class="col-lg-2 col-sm-4 col-form-label">SMTPSecure:</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <div class="row">
                                            <div class="col-6">
                                                <select class="form-control form-control-sm" id="smtpsecure_select">
                                                <option value="none">None</option>
                                                <option value="tls">TLS</option>
                                                <option value="ssl">SSL</option>
                                                <option value="">Custom</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control form-control-sm" id="smtpsecure_custom" placeholder="Custom SMTP" disabled autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <div class="ml-2">&nbsp;SMTPAuth:</div>
                                    <div class="col-lg-2 col-sm-4">
                                        <label class="switch">
                                            <input type="checkbox" name="" class="primary permission_toggle" id="smtpauth">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="from" class="col-lg-2 col-sm-4 col-form-label">From:</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="from" placeholder="user@abacare.com" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button title="Save email settings" type="button" class="btn btn-danger btn-lg apply-filter float-right" id="save_email_settings">Save email settings</button>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
<!-- <input type="hidden" id="accesses" name="accesses" value="" />
<input type="hidden" id="eemgt" name="eemgt" value="" /> -->