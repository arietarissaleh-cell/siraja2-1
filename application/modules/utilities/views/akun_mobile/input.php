	<!-- Widget -->
<div class="widget widget-tabs widget-tabs-gray border-bottom-none">

	<!-- Widget heading -->
	<div class="widget-head">
		<ul>
			<li class="active"><a class="glyphicons edit" href="#account-details" data-toggle="tab"><i></i>Account details</a></li>
			<li><a class="glyphicons settings" href="#account-settings" data-toggle="tab"><i></i>Account settings</a></li>
		</ul>
	</div>
	<!-- // Widget heading END -->
	
	<div class="widget-body">
		<form class="form-horizontal">
			<div class="tab-content">
			
				<!-- Tab content -->
				<div class="tab-pane active" id="account-details">
				
					<!-- Row -->
					<div class="row">
					
						<!-- Column -->
						<div class="col-md-6">
						
							<!-- Group -->
							<div class="form-group">
								<label class="col-md-3 control-label">First name</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" value="siRaja" class="form-control" />
										<span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="First name is mandatory"><i class="fa fa-question-circle"></i></span>
									</div>
								</div>
							</div>
							<!-- // Group END -->
							
							<!-- Group -->
							<div class="form-group">
								<label class="col-md-3 control-label">Last name</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" value="Rajawali" class="form-control" />
										<span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Last name is mandatory"><i class="fa fa-question-circle"></i></span>
									</div>
								</div>
							</div>
							<!-- // Group END -->
							
							<!-- Group -->
							<div class="form-group">
								<label class="col-md-3 control-label">Date of birth</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" id="datepicker1" class="form-control" value="20/12/1988" />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							<!-- // Group END -->
							
						</div>
						<!-- // Column END -->
						
						<!-- Column -->
						<div class="col-md-6">
						
							<!-- Group -->
							<div class="form-group">
								<label class="col-md-3 control-label">Gender</label>
								<div class="col-md-9">
									<select class="form-control">
										<option>Male</option>
										<option>Female</option>
									</select>
								</div>
							</div>
							<!-- // Group END -->
							
							<!-- Group -->
							<div class="form-group">
								<label class="col-md-3 control-label">Age</label>
								<div class="col-md-9">
									<input type="text" value="25" class="form-control" />
								</div>
							</div>
							<!-- // Group END -->
							
						</div>
						<!-- // Column END -->
						
					</div>
					<!-- // Row END -->
					
					<div class="separator line bottom"></div>
					
					
					<!-- Form actions -->
					<div class="separator top">
						<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Save changes</button>
						<button type="button" class="btn btn-default"><i class="fa fa-fw fa-times"></i> Cancel</button>
					</div>
					<!-- // Form actions END -->
					
				</div>
				<!-- // Tab content END -->
				
				<!-- Tab content -->
				<div class="tab-pane" id="account-settings">
				
					<!-- Row -->
					<div class="row">
					
						<!-- Column -->
						<div class="col-md-3">
							<strong>Change password</strong>
						</div>
						<!-- // Column END -->
						
						<!-- Column -->
						<div class="col-md-9">
							<label for="inputUsername">Username</label>
							<div class="input-group">
								<input type="text" id="inputUsername" class="form-control" value="siRaja" disabled="disabled" />
								<span class="input-group-addon" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Username can't be changed"><i class="icon-question-sign"></i></span>
							</div>
							<div class="separator bottom"></div>
									
							<label for="inputPasswordOld">Old password</label>
							<div class="input-group">
								<input type="password" id="inputPasswordOld" class="form-control" value="" placeholder="Leave empty for no change" />
								<span class="input-group-addon" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Leave empty if you don't wish to change the password"><i class="icon-question-sign"></i></span>
							</div>
							<div class="separator bottom"></div>
							
							<label for="inputPasswordNew">New password</label>
							<input type="password" id="inputPasswordNew" class="form-control" value="" placeholder="Leave empty for no change" />
							<div class="separator bottom"></div>
							
							<label for="inputPasswordNew2">Repeat new password</label>
							<input type="password" id="inputPasswordNew2" class="form-control" value="" placeholder="Leave empty for no change" />
							<div class="separator bottom"></div>
						</div>
						<!-- // Column END -->
						
					</div>
					<!-- // Row END -->
					
					<div class="separator line bottom"></div>
					
					<!-- Row -->
					<div class="row">
					
						<!-- Column -->
						<div class="col-md-3">
							<strong>Contact details</strong>
						</div>
						<!-- // Column END -->
						
						<!-- Column -->
						<div class="col-md-9">
							<div class="row">
								<div class="col-md-6">
									<label for="inputPhone">Phone</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
										<input type="text" id="inputPhone" class="form-control" placeholder="01234567897" />
									</div>
									<div class="separator bottom"></div>
										
									<label for="inputEmail">E-mail</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input type="text" id="inputEmail" class="form-control" placeholder="siraja@rajawali2.com" />
									</div>
									<div class="separator bottom"></div>
									
									<label for="inputWebsite">Website</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-link"></i></span>
										<input type="text" id="inputWebsite" class="form-control" placeholder="http://www.siraja2.com" />
									</div>
									<div class="separator bottom"></div>
								</div>
								<div class="col-md-6">
									<label for="inputFacebook">Facebook</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-facebook"></i></span>
										<input type="text" id="inputFacebook" class="form-control" placeholder="siRaja" />
									</div>
									<div class="separator bottom"></div>
									
									<label for="inputTwitter">Twitter</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-twitter"></i></span>
										<input type="text" id="inputTwitter" class="form-control" placeholder="@siRaja" />
									</div>
									<div class="separator bottom"></div>
									
									<label for="inputSkype">Skype ID</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-skype"></i></span>
										<input type="text" id="inputSkype" class="form-control" placeholder="siRaja" />
									</div>
									<div class="separator bottom"></div>
									
									<label for="inputgplus">Google</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
										<input type="text" id="inputgplus" class="form-control" placeholder="siRaja" />
									</div>
									<div class="separator bottom"></div>
								</div>
							</div>
						</div>
						<!-- // Column END -->
						
					</div>
					<!-- // Row END -->
					
					<!-- Form actions -->
					<div class="form-actions" style="margin: 0;">
						<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save changes</button>
					</div>
					<!-- // Form actions END -->
					
				</div>
				<!-- // Tab content END -->
			</div>
		</form>
	</div>
</div>
<!-- // Widget END -->