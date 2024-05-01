<!-- Main content -->
<style>
	.mobile_code{
		position: absolute;
		top: 56px;
		left: 22px;
	}
	.mobile_count{
		padding-left: 80px;
	}
</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 mt-3">
				<nav>
					<ol class="breadcrumb mb-0 bg-transparent">
						<!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
						<li class="breadcrumb-item"><a href="#">Users</a></li>
						<li class="breadcrumb-item active">Create User</li>
					</ol>
				</nav>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="card mt-3 border-0">
					<div class="card-body">
						<h4 class="title">Personal Details</h4>
						<?php echo form_open('', array('id' => 'userForm', 'autocomplete' => 'off')); ?>
							<div class="row mt-3">
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											First Name<span style="color:red;">*</span>
										</label>
										<input type="text" class="form-control" name="first_name" id="first_name"
											placeholder="Enter First Name" />
										<p class="first_name error" style="color: red;"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Last Name<span style="color:red;">*</span>
										</label>
										<input type="text" class="form-control" name="last_name" id="last_name"
											placeholder="Enter Last Name" />
											<p class="last_name error" style="color: red;"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Phone Number<span style="color:red;">*</span>
										</label>
										<span class="mobile_code">
											<select name="mobile_code">
												<option value="+251">+251</option>
												<option value="+254">+254</option>
											</select>
											</span>
										<input type="text" class="form-control mobile_count" name="mobile_number" id="mobile_number" placeholder="Enter number"/>
										<p class="mobile_number error" style="color: red;"></p>
									</div>
								</div>

								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Email Address<span style="color:red;">*</span>
										</label>
										<input type="text" class="form-control" name="email" id="email"
											placeholder="example@gmail.com" />
											<p class="email error" style="color: red;"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Username<span style="color:red;">*</span>
										</label>
										<input type="text" class="form-control" name="username" id="username"
											placeholder="Enter unique username" />
											<p class="username error" style="color: red;"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Password<span style="color:red;">*</span>
										</label>
										<div class="main-password">
											<input type="password" class="form-control input-password"  aria-label="password" placeholder="Password" name="password" id="password" autocomplete="off">
											<a href="JavaScript:void(0);" class="icon-view" >
												<i class="fa fa-eye"></i>
											</a>
											<p class="password error" style="color: red;"></p>
										</div>
									</div>
								</div>

								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Confirm Password<span style="color:red;">*</span>
										</label>
										<div class="main-password">
											<input type="password" class="form-control input-password" aria-label="password" placeholder="Confirm Password" name="cpassword" id="cpassword" autocomplete="off">
											<a href="JavaScript:void(0);" class="icon-view" >
												<i class="fa fa-eye"></i>
											</a>
											<p class="cpassword error" style="color: red;"></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group my-3">
										<label class="label-text">
											Select Role<span style="color:red;">*</span>
										</label>
										<select class="form-control" name="user_role">
											<option value="">-- Select --</option>
											<?php foreach ($all_roles as $key => $value) { ?>
												<option value="<?php echo $value['role_id'] ?>"><?php echo $value['role_name']; ?></option>
											<?php } ?>
										</select>
										<p class="user_role error" style="color: red;"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-12 mb-3">
									<button type="submit" class="btn btn-submit text-white">Add User</button>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Main content -->

<!-- Page Script -->
<!-- password text view Script -->
<script>
	$(document).ready(function () {
			$('.main-password').find('.input-password').each(function(index, input) {
				var $input = $(input);
				$input.parent().find('.icon-view').click(function() {
					var change = "";
					if ($(this).find('i').hasClass('fa-eye')) {
						$(this).find('i').removeClass('fa-eye')
						$(this).find('i').addClass('fa-eye-slash')
						change = "text";
					} else {
						$(this).find('i').removeClass('fa-eye-slash')
						$(this).find('i').addClass('fa-eye')
						change = "password";
					}
					var rep = $("<input type='" + change + "' />")
						.attr('id', $input.attr('id'))
						.attr('name', $input.attr('name'))
						.attr('class', $input.attr('class'))
						.val($input.val())
						.insertBefore($input);
					$input.remove();
					$input = rep;
				}).insertAfter($input);
			});
		});
</script>
<!-- password text view Script end-->
<script type="text/javascript">
	// Handle field value change
	$('.form-control').on('change', function(event) {
		var elem = $(this);
		if(elem.val().length > 0) elem.removeClass('form-control-danger');
	});
	
	// Handle user form submit
	$('#userForm').on('submit', function(event) {
		event.preventDefault();

		var elem = $(this);
		$('.error').empty();
		$('button').prop('disabled', true);
		$('button[type="submit"]').html('Please wait...');

		
		var error_count = 0;

		var textregex = new RegExp("^[a-zA-Z ]*$");
		var passwordregex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@$!%*?&]){8,}");

		var user_role = $('select[name="user_role"]').val();
		var first_name = $('input[name="first_name"]').val();
		var last_name = $('input[name="last_name"]').val();
		var mobile_number = $('input[name="mobile_number"]').val();
		var email = $('input[name="email"]').val();
		var username = $('input[name="username"]').val();
		var password = $('input[name="password"]').val();
		var cpassword = $('input[name="cpassword"]').val();

		if($.trim(user_role).length == 0){
			$('.user_role').html('Role is mandatory');
			error_count++;
		}

		if($.trim(first_name).length == 0){
			$('.first_name').html('First name is mandatory');
			error_count++;
		}else if($.trim(first_name).length < 2){
			$('.first_name').html('Minimum 2 characters required in first name');
			error_count++;
		}else if (!textregex.test($.trim(first_name))) {
			$('.first_name').html('First name can contain only alphabets');
			error_count++;
		}

		if($.trim(last_name).length == 0){
			$('.last_name').html('Last name is mandatory');
			error_count++;
		}else if($.trim(last_name).length < 2){
			$('.last_name').html('Minimum 2 characters required in last name');
			error_count++;
		}else if (!textregex.test($.trim(last_name))) {
			$('.last_name').html('Last name can contain only alphabets');
			error_count++;
		}

		if($.trim(mobile_number).length == 0){
			$('.mobile_number').html('Please provide a valid Mobile Number.');
			error_count++;
		}else if($.trim(mobile_number).length != 9) {
			$('.mobile_number').html('Please provide a valid Mobile Number nOt more than 9 digits.');
			error_count++;
		}else if(!isValidMobileNumber(mobile_number)) {
			$('.mobile_number').html('Please provide a valid Mobile Number.');
			error_count++;
		}
		// else if(check_user_number(mobile_number)) {
		// 	$('.mobile_number').html('Mobile Number already exists.'); //check phone number already esists or not
		// 	error_count++;
		// }


		if($.trim(email).length == 0){
			$('.email').html('Email id name is mandatory');
			error_count++;
		}else if(!isValidEmailAddress(email)) {
			$('.email').html('Please provide a valid emailid.');
			error_count++;
		}

		if($.trim(username).length == 0){
			$('.username').html('Username is mandatory');
			error_count++;
		}else if($.trim(username).length < 2){
			$('.username').html('Minimum 2 characters required in username');
			error_count++;
		}
		if($.trim(password).length == 0){
			$('.password').html('Password is mandatory');
			error_count++;
		}else if (!passwordregex.test($.trim(password))) {
			$('.password').html('Password should contain at least one digit, at least one lower case, at least one upper case,at least one special character, at least 8 from the mentioned characters');
			error_count++;
		}

		if($.trim(cpassword).length == 0){
			$('.cpassword').html('Confirm password is mandatory');
			error_count++;
		}else if (!passwordregex.test($.trim(cpassword))) {
			$('.cpassword').html('Password should contain at least one digit, at least one lower case, at least one upper case,at least one special character, at least 8 from the mentioned characters');
			error_count++;
		}

		if(password != cpassword){
			$('.cpassword').html('Both password and confirm password should be same');
			error_count++;
		}
		if(error_count == 0){

			var form = $(this)
			formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url(); ?>users/insert_user/',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				complete: function(data) {
					var csrfData = JSON.parse(data.responseText);
					ajaxData[csrfData.csrfName] = csrfData.csrfHash;
					if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
						$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
					}
				},
				error: function() {
					$('button').prop('disabled', false);
					$('button[type="submit"]').html('Add User');
					$.toast({
						heading: 'Network Error!',
						text: 'Could not establish connection to server. Please refresh the page and try again.',
						icon: 'error'
					});
				},
				success: function(data) {
					var data = JSON.parse(data);

					// If session error exists
					if(data.session_err == 1) {
						$.toast({
							heading: 'Session Error!',
							text: data.msg,
							icon: 'error'
						});

						$('button').prop('disabled', false);
						$('button[type="submit"]').html('Add User');
					}

					// If validation error exists
					if(data.status > 0) {
						for(var key in data) {
							var errorContainer = form.find(`.${key}.error`),
							errorInput = form.find(`[name="${key}"].form-control`);
							
							if(errorContainer.length !== 0) {
								errorContainer.html(data[key]);
							}
							if(errorInput.length !== 0) {
								errorInput.addClass('form-control-danger');
							}
						}
						$('button').prop('disabled', false);
						$('button[type="submit"]').html('Add User');
					}

					if(data.insertstatus == 1) {
						// If update completed
						$.toast({
							heading: 'Success!',
							text: data.msg,
							icon: 'success',
							afterHidden: function () {
								window.location.href = '<?php echo base_url(); ?>users/create';
							}
						});
					} else if(data.insertstatus == 0) {
						$.toast({
							heading: 'Error!',
							text: data.msg,
							icon: 'error'
						});
						$('button').prop('disabled', false);
						$('button[type="submit"]').html('Add User');
					}
				}
			});
		}else{
			$('button').prop('disabled',false);
			$('button[type="submit"]').html('Add User');
		}
	});
	function isValidMobileNumber(mobile) {
        var pattern = /^[0-9]{9,9}$/;
		// var pattern = /^[+]?[0-9]{12,12}$/;
        return pattern.test(mobile);
    }
	function isValidEmailAddress(emailAddress) {
        var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(emailAddress);
    }
	function check_user_number(user_number){
		// var data1=array();
		// data1['usernumber']=user_number;
		alert(user_number);
		var result=0;
		// data1={usernumber:user_number,status:true};
		var usernumber1=user_number;
		$.ajax({
				url: '<?php echo base_url(); ?>users/check_user_number/',
				type: 'POST',
				data: {usernumber:usernumber1},
				// data: usernumber1,
				processData: false,
				contentType: false,
				complete: function(data) {
					var csrfData = JSON.parse(data.responseText);
					ajaxData[csrfData.csrfName] = csrfData.csrfHash;
					if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
						$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
					}
				},
				error: function() {
					$('button').prop('disabled', false);
					$('button[type="submit"]').html('Add User');
					$.toast({
						heading: 'Network Error!',
						text: 'Could not establish connection to server. Please refresh the page and try again.',
						icon: 'error'
					});
				},
				success: function(data) {
					var data = JSON.parse(data);
					if(data.status == 1) {
						// If update completed
						// $.toast({
						// 	heading: 'Success!',
						// 	text: data.msg,
						// 	icon: 'success',
						// 	afterHidden: function () {
						// 		window.location.href = '<?php echo base_url(); ?>users/create';
						// 	}
						// });
						result=1;
					} else if(data.status == 0) {
						// $.toast({
						// 	heading: 'Error!',
						// 	text: data.msg,
						// 	icon: 'error'
						// });
						// $('button').prop('disabled', false);
						// $('button[type="submit"]').html('Add User');
						result=0;
					}else{
						result=0;
					}
				}
			});
			return result;
	}
</script>