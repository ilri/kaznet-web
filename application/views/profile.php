<link rel="Stylesheet" href="<?php echo base_url();?>include/croppie/croppie.css">
<style type="text/css">
			.btn-bs-file{
			    position:relative;
			    height: 30px; width: 30px;
			}
			.btn-bs-file input[type="file"]{
			    position: absolute;
			    top: -9999999;
			    opacity: 0.7;
			    width:0;
			    height:0;
			}
			textarea{
				resize: none;
			}

			.modal-header .close {
		        -ms-flex-order: 2;
		        order: 2;
		        margin-top: -10px;
		    }
		    

		    @media (min-width: 576px){
		        .modal-dialog {
		            max-width: 700px;
		            margin: 1.75rem auto;
		        }
		    }
		</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active"> Profile</li>
                    </ol>
                </nav>
                <!-- <?php print_r($profile_details); ?> -->
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                    <div> <h4 class="title">Personal Details</h4></div>
                    <div> 
                        <button class="btn btn-outline-dark btn-change-password" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                    </div>
                    </div>
                    <form id="updateProfile">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group my-3">
                                <label for="" class="label-text">Profile Image *</label>
                                    <div class="profile-box">
                                    <?php if(isset($profile_details['image'])){ ?>
                                    <img class="profile_image" src="<?php echo base_url(); ?>uploads/user/<?php echo($profile_details['image']); ?>" width="100%" height="100%" />
                                    <?php }else{ ?>
                                        <img class="pr-3" src="<?php echo base_url(); ?>include/assets/images/default.png" width="100%" height="100%"/>
                                        <?php } ?>
                                    </div>
                                    <input type="file" class="my-4" name="profile_img" class="file-upload">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">First Name *</label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo($profile_details['first_name']); ?>">
                                    </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">Last Name *</label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo($profile_details['last_name']); ?>">
                                    </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">Phone Number *</label>
                                    <input type="text" class="form-control" name="mobile_number" value="<?php echo($profile_details['mobile_number']); ?>">
                                    </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">Email *</label>
                                    <input type="text" class="form-control" name="email_id" value="<?php echo($profile_details['email_id']); ?>" disabled>
                                    </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">Username *</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo($profile_details['username']); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <button class="btn btn-submit text-white" id="update_btn">Update</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- main-content div closed -->
    <!-- password change model -->
    <div class="modal" id="changePasswordModal">
        <div class="modal-dialog modal-lg  modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header p-4">
              <h4 class="modal-title">Edit User Personal Details</h4>
              <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url(); ?>include/assets/images/cancel.svg" /></button>
            </div>
            <div class="modal-body bg-modal-cyan p-4">
                <div class="row">
                    <div id="cp_succ" class="col-md-12"></div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group my-3">
                            <label for="" class="label-text">Old Password *</label>
                            <div class="main-password">
                                <input type="password" class="form-control input-password" name="old_pass"  placeholder="Old Password" autocomplete="off">
                                <a href="JavaScript:void(0);" class="icon-view" >
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                            <span id="op" style="color:red; font-size: 11px;"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6"></div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group my-3">
                            <label for="" class="label-text">New Password *</label>
                            <div class="main-password">
                                <input type="password" class="form-control input-password" name="new_pass"  placeholder="New Password" autocomplete="off">
                                <a href="JavaScript:void(0);" class="icon-view" >
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                            <span id="np" style="color:red; font-size: 11px;"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group my-3">
                            <label for="" class="label-text">Confirm Password  *</label>
                            <div class="main-password">
                                <input type="password" class="form-control input-password" name="cnew_pass"  placeholder="Confirm Password" autocomplete="off">
                                <a href="JavaScript:void(0);" class="icon-view" >
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                            <span id="cnp" style="color:red; font-size: 11px;"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <button class="btn btn-submit-active text-white" id="cpm_btn">Change Password</button>
                        <button class="btn btn-cancel">Cancel</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div> 
    <!-- password change model end-->
    <!-- Croppie Modal -->
		<div class="modal fade modal-fade-in-scale-up" id="cropperModal" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
			<div class="modal-dialog">
			  <div class="modal-content">
			    <div class="modal-header">
			      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        <span aria-hidden="true">×</span>
			      </button>
			      <h4 class="modal-title">Select Viewable Portion</h4>
			    </div>
			    <div class="modal-body">
			      <div id="demo-basic"></div>
			    </div>
			    <div class="modal-footer">
			      <button type="button" class="btn btn-sm btn-danger margin-0" id="cancelImage" data-dismiss="modal">Discard Changes</button>
			      <button type="button" class="btn btn-sm btn-success" id="saveImage">Save Changes</button>
			    </div>
			  </div>
			</div>
		</div>
		<!-- End Modal -->
    <script src="<?php echo base_url();?>include/croppie/croppie.js"></script>
    <!-- password text view script-->
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
    <!-- password text view script end-->
    <!-- password change script -->
    <script type="text/javascript">
        // Define global variable ajaxData
        var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };
        
        $('body').on('click', '#cpm_btn', function(event) {
            var old_pass = $('body').find('input[name="old_pass"]').val();
            var new_pass = $('body').find('input[name="new_pass"]').val();
            var cnew_pass = $('body').find('input[name="cnew_pass"]').val();

            $('body').find('#op').empty();
            $('body').find('#np').empty();
            $('body').find('#cnp').empty();

            ajaxData['old_pass'] = old_pass;
            ajaxData['new_pass'] = new_pass;
            ajaxData['cnew_pass'] = cnew_pass;
            $.ajax({
                url: '<?php echo base_url(); ?>login/change_password/',
                type: 'POST',
                dataType:"json",
                data: ajaxData,
                complete: function(data) {
                    var csrfData = JSON.parse(data.responseText);
                    ajaxData[csrfData.csrfName] = csrfData.csrfHash;
                    if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                    }
                },
                error: function() {
                    $('body').find('#cp_succ').append('<p style="background-color: #F35462; color: #FFFFFF; padding: 10px;">Could not establish connection to server. Please refresh the page and try again.</p>').delay(5000).fadeOut(400);
                },
                success: function(data) {
                    if(data.status > 0){
                        $('body').find('#op').html(data.old_pass);
                        $('body').find('#np').html(data.new_pass);
                        $('body').find('#cnp').html(data.cnew_pass);
                    }
                    
                    if(data.c_status > 0){
                        $('body').find('#cp_succ').append('<p style="background-color: #6cc00c; color: #FFFFFF; padding: 10px;">'+data.msg+'</p>').delay(5000).fadeOut(400);
                        // $('#cp_modal_body').html('');
                        window.location.replace("<?php echo base_url(); ?>auth/logout");
                    }
                }
            });

        });
    </script>

<script type="text/javascript">
  /*var sizeerror = 0;
  var myReader = new FileReader();
  var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];  //acceptable file types
  var image_holder = $("#holder");
  var image_err = $("#img_err");

  var basic = $('#demo-basic').croppie({
    viewport: {
      width: 180,
      height: 180
    }
  });
  $("input[name='profile_img']").on('change', function () {
  	image_err.empty();
    if($("input[name='cropimg']").length > 0) $("input[name='cropimg']").remove();
    if (typeof (FileReader) != "undefined") {
      var extension = $(this)[0].files[0].name.split('.').pop().toLowerCase(),//file extension from input file
      isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable type

      //image_holder.empty();
      if($(this)[0].files[0].size > 5242880) {
        sizeerror = 1;
      }
      else {
        sizeerror = 0;
      }

      if (isSuccess && sizeerror === 0) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#cropperModal').modal('show');

          $('#cropperModal').on('shown.bs.modal', function() {
            basic.croppie('bind', {
              url: e.target.result
            });
          });
        }
        //image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
      } else if(!isSuccess) {
        image_err.html("<p class='red-800 font-size-16'>Please choose .gif, .png, .jpg, .jpeg file type.</p>");
      } 
      else if(sizeerror > 0) {
        image_err.html("<p class='red-800 font-size-16'>Image size should be between 32KB to 5MB.</p>");
      }
    } else {
      alert("This browser does not support FileReader. Can not show image preview.");
    }
  });

  //Save Cropped Image
  $('#saveImage').on('click', function() {
  	//alert($("input[name='profile_img']").val());
    basic.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function (resp) {
    	$('#updateProfile').append('<input type="text" value="'+resp+'" name="cropimg" />')
      	// $('#pImgForm').submit();
    });
  });
  //Cancel cropped image
  $('#cancelImage').on('click', function() {
    $("input[name='profile_img']").val('');
    if($("input[name='cropimg']").length > 0) $("input[name='cropimg']").remove();
    image_err.html();
  });*/
</script>

  <!-- profile details update -->
    <script type="text/javascript">
        var userData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };
        
        $('body').on('click', '#update_btn', function(event) {
            var first_name = $('body').find('input[name="first_name"]').val();
            var last_name = $('body').find('input[name="last_name"]').val();
            var mobile_number = $('body').find('input[name="mobile_number"]').val();
            var profile_img = $('body').find('input[name="profile_img"]').val();

            $('body').find('#op').empty();
            $('body').find('#np').empty();
            $('body').find('#cnp').empty();

            userData['first_name'] = first_name;
            userData['last_name'] = last_name;
            userData['mobile_number'] = mobile_number;
            userData['profile_img'] = profile_img;
            
            $.ajax({
                url: '<?php echo base_url(); ?>login/update_profile/',
                type: 'POST',
                dataType:"json",
                data: userData,
                error: function() {
                    // $('body').find('#cp_succ').append('<p style="background-color: #F35462; color: #FFFFFF; padding: 10px;">Could not establish connection to server. Please refresh the page and try again.</p>').delay(5000).fadeOut(400);
                },
                success: function(data) {
                    debbuger
                    // if(data.status > 0){
                    //     $('body').find('#op').html(data.old_pass);
                    //     $('body').find('#np').html(data.new_pass);
                    //     $('body').find('#cnp').html(data.cnew_pass);
                    // }
                    // if(data.c_status > 0){
                    //     $('body').find('#cp_succ').append('<p style="background-color: #6cc00c; color: #FFFFFF; padding: 10px;">'+data.msg+'</p>').delay(5000).fadeOut(400);
                    //     window.location.replace("<?php echo base_url(); ?>auth/logout");
                    // }
                }
            });

        });
    </script>