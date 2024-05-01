<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }
  .disabled_link{
    pointer-events: none;
    background-color:"gray" !important;
  }
  .dataTables_filter {
    display: block !important;
  }
  .export_align{
		text-align: right !important;
	}
  #export_sub{
		background-color: rgb(111, 27, 40);
		color:#fff;
	}
	#export_sub:hover{
		/* background-color: rgb(111, 27, 40); */
		color:#fff;
	}
</style>

<!-- user personal edit modal -->
<div id="UserEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit User Personal Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?php echo form_open('', array('id' => 'EditUserForm', 'class' => 'form-group')); ?>
          <div class="row">
            <div class="col-md-6 form-group">
              <label>First Name</label> <span class="text-danger">*</span>
              <input type="text" name="fname" class="form-control" placeholder="Enter First name">
              <span id="fname_error" class="error"></span>
            </div>
            <div class="col-md-6 form-group">
              <label>Last Name</label> <span class="text-danger">*</span>
              <input type="text" name="lname" class="form-control" placeholder="Enter Last name">
              <span id="lname_error" class="error"></span>
            </div>
            <div class="col-md-6 form-group">
              <label>Phone Number</label> <span class="text-danger">*</span>
              <input type="text" name="mobile_number" class="form-control" placeholder="Enter Phone number">
              <span id="phone_error" class="error"></span>
            </div>
            <div class="col-md-6 form-group">
              <label>Email Id</label> <span class="text-danger">*</span>
              <input type="text" name="email" class="form-control" placeholder="Enter Email id">
              <span id="email_error" class="error"></span>
            </div>
            <div class="col-md-6 form-group">
              <label>Username</label> <span class="text-danger">*</span>
              <input type="text" name="username" class="form-control" placeholder="Enter Username" readonly>
              <span id="username_error" class="error"></span>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success float-right mr-1">Update</button>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- user personal edit modal ends -->

<!-- Main content -->
  <div class="container-fluid">
      <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
              <nav>
                  <ol class="breadcrumb mb-0 bg-transparent">
                      <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
                      <li class="breadcrumb-item"><a href="#">Users</a></li>
                      <li class="breadcrumb-item active"> Manage User</li>
                  </ol>
              </nav>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="card mt-3 border-0">
                <div class=" export_align">
                  <button type="button" class="btn btn-sm hidden"  id="export_sub" onclick="exportXcel()">Export data</button>
                </div>
                  <ul class="nav nav-tabs border-bottom-0 bg-transparent mb-3">
                      <li class="nav-item"><a class="nav-link active" href="#contributer" data-toggle="tab">Contributors</a></li>
                      <li class="nav-item"><a class="nav-link" href="#clusteradmin" data-toggle="tab">Cluster Admins</a></li>
                      <li class="nav-item"><a class="nav-link" href="#dissemination" data-toggle="tab">Dissemination Users</a></li>
                  </ul>
              
                  <div class="tab-content">

                      <!-- Contributers Tab -->
                      <div class="tab-pane active" id="contributer">
                          <div class="table-responsive">
                              <table id="example1" class="table table-striped" style="width:100%">
                                  <thead class="bg-dataTable">
                                      <tr>
                                          <th>No</th>
                                          <th>Contributor Name</th>
                                          <th>Phone Number</th>
                                          <th>Email ID</th>
                                          <th>User Name</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                          <th>Location</th>
                                          <th>Added Date</th>
                                          <!-- <th>Respondent</th> -->
                                          <!-- <th>No of locations </th> -->
                                          <!-- <th>No of respondents</th> -->
                                          <!-- <th>Assign Task </th> -->
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php if(count($contributers) > 0){
                                      foreach ($contributers as $ukey => $user) { ?>
                                        <tr data-user_id="<?php echo $user['user_id']; ?>">
                                          <td><?php echo ($ukey+1); ?></td>
                                          <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
                                          <td><?php echo $user['mobile_number']; ?></td>
                                          <td><?php echo $user['email_id']; ?></td>
                                          <td><?php echo $user['username']; ?></td>
                                          <td>
                                          <?php if($user['status'] == 1) { ?>
                                            <span class="text-success">Active</span>
                                          <?php }else if($user['status'] == -1) { ?>
                                            <span class="text-danger">Deleted</span>
                                          <?php }else if($user['status'] == 2) { ?>
                                            <span class="text-danger">Rejected</span>
                                          <?php } else { ?>
                                            <span class="text-danger">Inactive</span>
                                          <?php } ?>
                                          </td>
                                          <?php if(($this->session->userdata('role') == 1) || ($this->session->userdata('login_id') == $user['added_by'])){ ?>
                                          <td>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle drop-arrow"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Option <img class="pl-2" src="<?php echo base_url(); ?>include/assets/images/down-arrow.svg" />
                                                </span>
                                                <div class="dropdown-menu tbl-drop border-0" aria-labelledby="dropdownMenuButton">
                                                <?php if( $user['status'] != -1){ ?>
                                                    <a class="dropdown-item edit" href="javascript:void(0);">Edit</a>
                                                   <?php } ?>
                                                  <?php if($this->session->userdata('role') == 1 && $user['status'] != -1){ ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="javascript:void(0);" class="dropdown-item activation" data-status="<?php echo $user['status'] == 1 ? 0 : 1; ?>">
                                                        <?php if($user['status'] == 1) { ?>
                                                        Deactivate
                                                        <?php } else { ?>
                                                         Activate
                                                        <?php } ?>
                                                      </a>
                                                    <?php if($user['status'] == 0) { ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="javascript:void(0);" class="dropdown-item reject">
                                                        Reject
                                                      </a>
                                                    <?php  } ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="javascript:void(0);" class="dropdown-item resetpass">
                                                        Reset Password
                                                      </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item delete" href="javascript:void(0);" >Delete</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                          </td>
                                          
                                          <?php } else {?>
                                            <td>N/A</td>
                                          <?php }?>
                                          <td>
                                            <?php if($user['status'] == 1) { ?>
                                              <!-- <span class="mr-2">10</span> -->
                                              <a href="<?php echo base_url(); ?>users/manage_contributer_location/<?php echo $user['user_id'] ?>" class="btn btn-outline-dark mt-0 <?php echo($user['status'] == 1 ? '':'disabled_link') ?>">Manage Location</a>
                                              <?php } ?>
                                          </td>
                                          <td><?php echo $user['added_datetime']; ?></td>
                                          <!-- <td>
                                              <a href="<?php echo base_url(); ?>users/manage_respondent/<?php echo $user['user_id'] ?>" class="btn btn-outline-dark mt-0 mr-2">Manage Respondents</a>
                                          </td> -->
                                          <!-- <td>
                                              <a href="<?php echo base_url(); ?>survey/assign_task"
                                                  class="btn btn-outline-dark mt-0 mr-2">Assign Task</a>
                                          </td> -->
                                        </tr>
                                      <?php }
                                    }else{ ?>
                                      <tr>
                                        <td colspan="7">No users found</td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>

                      <!-- Cluster admins Tab -->
                      <div class="tab-pane" id="clusteradmin">
                          <div class="table-responsive">
                              <table id="example2" class="table table-striped" style="width:100%">
                                  <thead class="bg-dataTable">
                                      <tr>
                                          <th>No</th>
                                          <th>Admin Name</th>
                                          <th>Phone Number</th>
                                          <th>Email ID</th>
                                          <th>User Name</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                          <th>Location</th>
                                          <th>Added Date</th>
                                          <!-- <th>No of locations </th> -->
                                          <!-- <th>No of respondents</th> -->
                                          <!-- <th>Assign Task </th> -->
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php if(count($cluster_admins) > 0){
                                      foreach ($cluster_admins as $ukey => $user) { ?>
                                        <tr data-user_id="<?php echo $user['user_id']; ?>">
                                          <td><?php echo ($ukey+1); ?></td>
                                          <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
                                          <td><?php echo $user['mobile_number']; ?></td>
                                          <td><?php echo $user['email_id']; ?></td>
                                          <td><?php echo $user['username']; ?></td>
                                          <td>
                                          <?php if($user['status'] == 1) { ?>
                                            <span class="text-success">Active</span>
                                          <?php }else if($user['status'] == -1) { ?>
                                            <span class="text-danger">Deleted</span>
                                          <?php }else if($user['status'] == 2) { ?>
                                            <span class="text-danger">Rejected</span>
                                          <?php } else { ?>
                                            <span class="text-danger">Inactive</span>
                                          <?php } ?>
                                          </td>
                                          <?php if(($this->session->userdata('role') == 1) || ($this->session->userdata('login_id') == $user['added_by'])){ ?>
                                              <td>
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle drop-arrow"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Option <img class="pl-2" src="<?php echo base_url(); ?>include/assets/images/down-arrow.svg" />
                                                    </span>
                                                    <div class="dropdown-menu tbl-drop border-0" aria-labelledby="dropdownMenuButton">
                                                    <?php if( $user['status'] != -1){ ?>
                                                        <a class="dropdown-item edit" href="javascript:void(0);">Edit</a>
                                                      <?php } ?>
                                                      <?php if($this->session->userdata('role') == 1 && $user['status'] != -1){ ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="javascript:void(0);" class="dropdown-item activation" data-status="<?php echo $user['status'] == 1 ? 0 : 1; ?>">
                                                            <?php if($user['status'] == 1) { ?>
                                                            Deactivate
                                                            <?php } else { ?>
                                                            Activate
                                                            <?php } ?>
                                                          </a>
                                                        <?php if($user['status'] == 0) { ?>
                                                        <!-- <div class="dropdown-divider"></div>
                                                        <a href="javascript:void(0);" class="dropdown-item reject">
                                                            Reject
                                                          </a> -->
                                                        <?php  } ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="javascript:void(0);" class="dropdown-item resetpass">
                                                            Reset Password
                                                          </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete" href="javascript:void(0);" >Delete</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                              </td>
                                              
                                          <?php } else {?>
                                            <td>N/A</td>
                                          <?php }?>
                                          <td>
                                            <?php if($user['status'] == 1) { ?>
                                              <a href="<?php echo base_url(); ?>users/manage_cluster_location/<?php echo $user['user_id'] ?>" class="btn btn-outline-dark mt-0 <?php echo($user['status'] == 1 ? '':'disabled_link') ?>">Manage Location</a>
                                              <?php } ?>
                                          </td>
                                          <td><?php echo $user['added_datetime']; ?></td>
                                          <!-- <td>
                                              <a href="<?php echo base_url(); ?>survey/assign_task"
                                                  class="btn btn-outline-dark mt-0 mr-2">Assign Task</a>
                                          </td> -->
                                        </tr>
                                      <?php }
                                    }else{ ?>
                                      <tr>
                                        <td colspan="7">No users found</td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <!-- Cluster admins Tab -->
                      <div class="tab-pane" id="dissemination">
                          <div class="table-responsive">
                              <table id="example3" class="table table-striped" style="width:100%">
                                  <thead class="bg-dataTable">
                                      <tr>
                                          <th>No</th>
                                          <th>Admin Name</th>
                                          <th>Phone Number</th>
                                          <th>Email ID</th>
                                          <th>User Name</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                          <th>Added Date</th>
                                          <!-- <th>Location</th> -->
                                          <!-- <th>No of locations </th> -->
                                          <!-- <th>No of respondents</th> -->
                                          <!-- <th>Assign Task </th> -->
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php if(count($disseminations) > 0){
                                      foreach ($disseminations as $ukey => $user) { ?>
                                        <tr data-user_id="<?php echo $user['user_id']; ?>">
                                          <td><?php echo ($ukey+1); ?></td>
                                          <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
                                          <td><?php echo $user['mobile_number']; ?></td>
                                          <td><?php echo $user['email_id']; ?></td>
                                          <td><?php echo $user['username']; ?></td>
                                          <td>
                                          <?php if($user['status'] == 1) { ?>
                                            <span class="text-success">Active</span>
                                          <?php }else if($user['status'] == -1) { ?>
                                            <span class="text-danger">Deleted</span>
                                          <?php }else if($user['status'] == 2) { ?>
                                            <span class="text-danger">Rejected</span>
                                          <?php } else { ?>
                                            <span class="text-danger">Inactive</span>
                                          <?php } ?>
                                          </td>
                                          <?php if(($this->session->userdata('role') == 1) || ($this->session->userdata('login_id') == $user['added_by'])){ ?>
                                              <td>
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle drop-arrow"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Option <img class="pl-2" src="<?php echo base_url(); ?>include/assets/images/down-arrow.svg" />
                                                    </span>
                                                    <div class="dropdown-menu tbl-drop border-0" aria-labelledby="dropdownMenuButton">
                                                    <?php if( $user['status'] != -1){ ?>
                                                        <a class="dropdown-item edit" href="javascript:void(0);">Edit</a>
                                                      <?php } ?>
                                                      <?php if($this->session->userdata('role') == 1 && $user['status'] != -1){ ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="javascript:void(0);" class="dropdown-item activation" data-status="<?php echo $user['status'] == 1 ? 0 : 1; ?>">
                                                            <?php if($user['status'] == 1) { ?>
                                                            Deactivate
                                                            <?php } else { ?>
                                                            Activate
                                                            <?php } ?>
                                                          </a>
                                                        <!-- <?php if($user['status'] == 0) { ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="javascript:void(0);" class="dropdown-item reject">
                                                            Reject
                                                          </a>
                                                        <?php  } ?> -->
                                                        <div class="dropdown-divider"></div>
                                                        <a href="javascript:void(0);" class="dropdown-item resetpass">
                                                            Reset Password
                                                          </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete" href="javascript:void(0);" >Delete</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                              </td>
                                              
                                          <?php } else {?>
                                            <td>N/A</td>
                                          <?php }?>
                                          <!-- <td>
                                            <?php if($user['status'] == 1) { ?>
                                              <a href="<?php echo base_url(); ?>users/manage_cluster_location/<?php echo $user['user_id'] ?>" class="btn btn-outline-dark mt-0 <?php echo($user['status'] == 1 ? '':'disabled_link') ?>">Manage Location</a>
                                              <?php } ?>
                                          </td> -->
                                          <!-- <td>
                                              <a href="<?php echo base_url(); ?>survey/assign_task"
                                                  class="btn btn-outline-dark mt-0 mr-2">Assign Task</a>
                                          </td> -->
                                          <td><?php echo $user['added_datetime']; ?></td>
                                        </tr>
                                      <?php }
                                    }else{ ?>
                                      <tr>
                                        <td colspan="7">No users found</td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script>
    $(document).ready(function () {
        $('#example1').DataTable({
          ordering: false,
          searching: true
        });
        $('#example2').DataTable({
          ordering: false,
          searching: true
        });
        $('#example3').DataTable({
          ordering: false,
          searching: true
        });
    });
</script>
<script type="text/javascript">
  
$(function(){ });

// Define global variable ajaxData
var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

// Handle edit and editProf button click
$('body').on('click', '.edit', function(event){
  $elem = $(this);
  var user_id = $elem.closest('tr').data('user_id');
  $('#UserEditModal').find('.error').empty();
  $('#UserEditModal').modal('show');
  $('#EditUserForm').data('user_id', user_id);
  $('#EditUserForm').find('button').prop('disabled', true);
  $('#EditUserForm').find('button[type="submit"]').html('Please Wait... Getting User Details');
  
  //send ajax request to get user data to edit
  ajaxData['user_id'] = user_id;
  $.ajax({
    url: '<?php echo base_url(); ?>Users/get_user_details',
    type: 'POST',
    dataType : 'json',
    data: ajaxData,
    complete: function(data) {
      $('#EditUserForm').find('button[type="submit"]').html('Update');
      var csrfData = JSON.parse(data.responseText);
      ajaxData[csrfData.csrfName] = csrfData.csrfHash;
      if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
      }
    },
    error: function() {
      $.toast({
        heading: 'Network Error!',
        text: 'Could not establish connection to server. Please refresh the page and try again.',
        icon: 'error',
        afterHidden: function () {
          $('#EditUserForm').find('button').prop('disabled', false);
          $('#UserEditModal').modal('hide');
        }
      });
    },
    success: function(response){
      $('#EditUserForm').find('button').prop('disabled', false);
      $('[name="fname"]').val(response.user_details.first_name);
      $('[name="lname"]').val(response.user_details.last_name);
      $('[name="mobile_number"]').val(response.user_details.mobile_number);
      $('[name="email"]').val(response.user_details.email_id);
      $('[name="username"]').val(response.user_details.username);
    }
  });
});

//Handle user edit form submit
$('body').on('submit', '#EditUserForm', function(event) {
  event.preventDefault();
  $('.error').empty();
  var fname = $('[name="fname"]').val();
  var lname = $('[name="lname"]').val();
  var mobile_number = $('[name="mobile_number"]').val();
  var email = $('[name="email"]').val();
  var username = $('[name="username"]').val();
  var user_id = $(this).data('user_id');
  var error = false;
  var textregex = new RegExp("^[a-zA-Z ]*$");
  var form = $(this);
  $('input[type="text"]', form).each(function(index) {
    var elem = $(this);
    elem.val($.trim(elem.val()));
  });
  $('input[type="email"]', form).each(function(index) {
    var elem = $(this);
    elem.val($.trim(elem.val()));
  });

  if($.trim(fname).length == 0){
    error = true;
    $('#fname_error').html('First name is mandatory');
  }else if($.trim(fname).length < 2){
    error = true;
			$('#fname_error').html('Minimum 2 characters required in first name');
		}else if (!textregex.test($.trim(fname))) {
      error = true;
			$('#fname_error').html('First name can contain only alphabets');
		}

  if($.trim(lname).length == 0){
    error = true;
    $('#lname_error').html('Last name is mandatory');
  }else if($.trim(lname).length < 2){
    error = true;
    $('#lname_error').html('Minimum 2 characters required in last name');
			
		}else if (!textregex.test($.trim(lname))) {
			error = true;
    $('#lname_error').html('Last name can contain only alphabets');
			
		}
  if($.trim(mobile_number).length == 0){
    error = true;
    $('#phone_error').html('Mobile Number is mandatory');
  }else if($.trim(mobile_number).length != 13) {
    error = true;
			$('#phone_error').html('Please provide a valid Mobile Number.');
			
		}else if(!isValidMobileNumber(mobile_number)) {
      error = true;
			$('#phone_error').html('Please provide a valid Mobile Number.');
			
		}

  if($.trim(email).length == 0){
    error = true;
    $('#email_error').html('Email Id is mandatory');
  }else if(!isValidEmailAddress(email)) {
    error = true;
    $('#email_error').html('Please provide a valid emailid.');
		}

  if($.trim(username).length == 0){
    error = true;
    $('#username_error').html('Username is mandatory');
  }

  if(!error){
    ajaxData['user_id'] = user_id;
    ajaxData['fname'] = fname;
    ajaxData['lname'] = lname;
    ajaxData['mobile_number'] = mobile_number;
    ajaxData['email'] = email;
    ajaxData['username'] = username;
    $.ajax({
      url: '<?php echo base_url(); ?>Users/update_user_details',
      type: 'POST',
      dataType : 'json',
      data: ajaxData,
      complete: function(data) {
        var csrfData = JSON.parse(data.responseText);
        ajaxData[csrfData.csrfName] = csrfData.csrfHash;
        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
          $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
        }
      },
      error: function() {
        $.toast({
          heading: 'Network Error!',
          text: 'Could not establish connection to server. Please refresh the page and try again.',
          icon: 'error'
        });
      },
      success: function(response){
        $.toast({
          heading: 'Success!',
          text: response.msg,
          icon: 'success',
          afterHidden: function () {
            window.location.reload();
          }
        });
      }
    });
  }
});

function isValidMobileNumber(mobile) {
        // var pattern = /^[0-9]{13,13}$/;
		var pattern = /^[+]?[0-9]{12,12}$/;
        return pattern.test(mobile);
    }
function isValidEmailAddress(emailAddress) {
    var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(emailAddress);
}

// Activating and Deactivating User
$('body').on('click', '.activation', function(){
  var elem = $(this);
  elem.addClass('disabled');
  if(elem.data('status') == 0) {
    elem.html('Please Wait.... Deactivating User.');
  } else {
    elem.html('Please Wait.... Activating User.');
  }
  changeUserStatus(elem);
});
function changeUserStatus(elem){
  ajaxData['status'] = elem.data('status');
  ajaxData['user_id'] = elem.closest('tr').data('user_id');
  
  $.ajax({
    url: '<?php echo base_url(); ?>users/active_deactive_user/',
    data: ajaxData,
    type: 'POST',
    dataType: 'json',
    complete: function(data) {
      var csrfData = JSON.parse(data.responseText);
      ajaxData[csrfData.csrfName] = csrfData.csrfHash;
      if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
      }
    },
    error: function() {
      $.toast({
        heading: 'Network Error!',
        text: 'Could not establish connection to server. Please refresh the page and try again.',
        icon: 'error'
      });
      elem.removeClass('disabled');
      if(elem.data('ststus') == 0) elem.html('<i class="fa fa-ban text-danger" aria-hidden="true"></i> Deactivate');
      else elem.html('<i class="fa fa-check text-success" aria-hidden="true"></i> Activate');
    },
    success: function(data) {
      if(data.status == 0) {
        $.toast({
          heading: 'Error!',
          text: data.msg,
          icon: 'error'
        });
        elem.removeClass('disabled');
        if(elem.data('ststus') == 0) elem.html('<i class="fa fa-ban text-danger" aria-hidden="true"></i> Deactivate');
        else elem.html('<i class="fa fa-check text-success" aria-hidden="true"></i> Activate');
        return false;
      }
      
      $.toast({
        heading: 'Success!',
        text: data.msg,
        icon: 'success',
        afterHidden: function () {
          window.location.reload();
        }
      });
    }
  });
}

// Resseting user's password to Default
$('body').on('click', '.resetpass', function(event) {
  var elem = $(this);
  swal({
    title: "Are you sure?",
    text: "The User's password will be reset to 'Mpro@123'",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, reset it!"
  }, function() {
    elem.addClass('disabled');
    elem.html('Please Wait.... Resetting User Password.');
    resetPassword(elem);
  });
});
function resetPassword(elem){
  ajaxData['user_id'] = elem.closest('tr').data('user_id');
  
  $.ajax({
    url: '<?php echo base_url(); ?>users/reset_user_password/',
    data: ajaxData,
    type: 'POST',
    dataType: 'json',
    complete: function(data) {
      var csrfData = JSON.parse(data.responseText);
      ajaxData[csrfData.csrfName] = csrfData.csrfHash;
      if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
      }
    },
    error: function() {
      $.toast({
        heading: 'Network Error!',
        text: 'Could not establish connection to server. Please refresh the page and try again.',
        icon: 'error'
      });
      elem.removeClass('disabled');
      elem.html('<i class="fa password" aria-hidden="true"></i> Reset Password');
    },
    success: function(data) {
      elem.removeClass('disabled');
      elem.html('<i class="fa password" aria-hidden="true"></i> Reset Password');
      
      if(data.status == 0) {
        $.toast({
          heading: 'Error!',
          text: data.msg,
          icon: 'error'
        });
        return false;
      }

      $.toast({
        heading: 'Success!',
        text: data.msg,
        icon: 'success'
      });
    }
  });
}
// Rejecte user
$('body').on('click', '.reject', function(event) {
  var elem = $(this);
  swal({
    title: "Are you sure?",
    text: "You want to Reject the User Account request?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, reject it!"
  }, function() {
    elem.addClass('disabled');
    elem.html('Please Wait.... Rejecting User.');
    rejectUser(elem);
  });
});
function rejectUser(elem){
  ajaxData['user_id'] = elem.closest('tr').data('user_id');
  
  $.ajax({
    url: '<?php echo base_url(); ?>users/reject_user/',
    data: ajaxData,
    type: 'POST',
    dataType: 'json',
    complete: function(data) {
      var csrfData = JSON.parse(data.responseText);
      ajaxData[csrfData.csrfName] = csrfData.csrfHash;
      if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
      }
    },
    error: function() {
      $.toast({
        heading: 'Network Error!',
        text: 'Could not establish connection to server. Please refresh the page and try again.',
        icon: 'error'
      });
      elem.removeClass('disabled');
      elem.html('<i class="fa rejected" aria-hidden="true"></i> Reject');
    },
    success: function(data) {
      elem.removeClass('disabled');
      elem.html('<i class="fa rejected" aria-hidden="true"></i> Reject');
      
      if(data.status == 0) {
        $.toast({
          heading: 'Error!',
          text: data.msg,
          icon: 'error'
        });
        return false;
      }

      $.toast({
        heading: 'Success!',
        text: data.msg,
        icon: 'success',
        afterHidden: function () {
          window.location.reload();
        }
      });
    }
  });
}
// Delete user
$('body').on('click', '.delete', function(event) {
  var elem = $(this);
  swal({
    title: "Are you sure?",
    text: "You want to Delete the User Account?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!"
  }, function() {
    elem.addClass('disabled');
    elem.html('Please Wait.... Deleting User.');
    deleteUser(elem);
  });
});
function deleteUser(elem){
  ajaxData['user_id'] = elem.closest('tr').data('user_id');
  
  $.ajax({
    url: '<?php echo base_url(); ?>users/delete_user/',
    data: ajaxData,
    type: 'POST',
    dataType: 'json',
    complete: function(data) {
      var csrfData = JSON.parse(data.responseText);
      ajaxData[csrfData.csrfName] = csrfData.csrfHash;
      if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
      }
    },
    error: function() {
      $.toast({
        heading: 'Network Error!',
        text: 'Could not establish connection to server. Please refresh the page and try again.',
        icon: 'error'
      });
      elem.removeClass('disabled');
      elem.html('<i class="fa deleted" aria-hidden="true"></i> Delete');
    },
    success: function(data) {
      elem.removeClass('disabled');
      elem.html('<i class="fa deleted" aria-hidden="true"></i> Delete');
      
      if(data.status == 0) {
        $.toast({
          heading: 'Error!',
          text: data.msg,
          icon: 'error'
        });
        return false;
      }

      $.toast({
        heading: 'Success!',
        text: data.msg,
        icon: 'success',
        afterHidden: function () {
          window.location.reload();
        }
      });
    }
  });
}
</script>

<!-- export data js -->
<script src="<?php echo base_url(); ?>include/js/xlsx.full.min.js"></script>
<script>
	function exportToXcel(name,data){
		const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, name);
        XLSX.writeFile(wb, name+'.xlsx');
	}
	function exportXcel() {
		$("#export_sub").prop('disabled', true);
        $("#export_sub").html("Please wait ...");

		// var country_id = $('select[name="country_id"]').val();
		// var uai_id = $('select[name="uai_id"]').val();
		// var sub_location_id = $('select[name="sub_location_id"]').val();
		// var cluster_id = $('select[name="cluster_id"]').val();
		// var contributor_id = $('select[name="contributor_id"]').val();
		// var respondent_id = $('select[name="respondent_id"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			roles: '9',
		};
		
		$.ajax({
			// url: "<?php echo base_url(); ?>reports/get_submited_data/<?php echo $this->uri->segment(3); ?>",
			url: "<?php echo base_url(); ?>users/get_user_data/",
			data: query_data,
			type: "POST",
			dataType: "JSON",
			error: function() {
				$.toast({
					heading: 'Error!',
					text: response.msg,
					icon: 'error'
				});
			},
			success: function(response) {
				if (response.status == 0) {
					$.toast({
						heading: 'Error!',
						text: response.msg,
						icon: 'error'
					});
					$('#submited_body').html('<h4 class="text-center">No data Found</h4>');
					return false;
				}
				var role = response.user_role;
				var fields = response.fields;
				var submitedData = response.contributers;
				// var lkp_country = response.lkp_country;
				// var lkp_cluster = response.lkp_cluster;
				// var lkp_uai = response.lkp_uai;
				// var lkp_sub_location = response.lkp_sub_location;
				// var lkp_location_type = response.lkp_location_type;
				// var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				// var respondent_name = response.respondent_name;
				// var lkp_market = response.lkp_market;
				// var lkp_transect_pastures = response.lkp_transect_pasture;
				// var lkp_lr_body_condition = response.lkp_lr_body_condition;
				// var lkp_sr_body_condition = response.lkp_sr_body_condition;
				// var lkp_animal_type = response.lkp_animal_type;
				// var lkp_animal_herd_type = response.lkp_animal_herd_type;
				// var lkp_food_groups = response.lkp_food_groups;
				// var lkp_transect_pasture = response.lkp_transect_pasture;
				// var lkp_dry_wet_pasture = response.lkp_dry_wet_pasture;
				// var lkp_transport_means = response.lkp_transport_means;

				// var myArray = $.makeArray({ foo: "bar", hello: "world
				var verified_list = $.makeArray({"1":"Submitted","2":"Approved","3":"Rejected"});
				const lkpData = {};
				const imageData = {};
				const lkpDataMultiple = {};

				// const countries = {};
				// for (let sid = 0; sid < lkp_country.length; sid++) {
				// 	const element = lkp_country[sid];
				// 	countries[element.country_id] = element.name;
				// }
				// const uais = {};
				// for (let uaiid = 0; uaiid < lkp_uai.length; uaiid++) {
				// 	const element = lkp_uai[uaiid];
				// 	uais[element.uai_id] = element.uai;
				// }
				// const subLocations = {};
				// for (let dsid = 0; dsid < lkp_sub_location.length; dsid++) {
				// 	const element = lkp_sub_location[dsid];
				// 	subLocations[element.sub_loc_id] = element.location_name;
				// }
				// const clusters = {};
				// for (let cid = 0; cid < lkp_cluster.length; cid++) {
				// 	const element = lkp_cluster[cid];
				// 	clusters[element.cluster_id] = element.name;
				// }

				// const locationtypes = {};
				// for (let bk = 0; bk < lkp_location_type.length; bk++) {
				// 	const element = lkp_location_type[bk];
				// 	locationtypes[element.location_id] = element.name;
				// }
				// const markets = {};
				// for (let gn = 0; gn < lkp_market.length; gn++) {
				// 	const element = lkp_market[gn];
				// 	markets[element.market_id] = element.name;
				// }
				// const animaltypelactatings = {};
				// for (let vkey = 0; vkey < lkp_animal_type_lactating.length; vkey++) {
				// 	const element = lkp_animal_type_lactating[vkey];
				// 	animaltypelactatings[element.animal_type_lactating_id] = element.name;
				// }
				
				// const lrBodyConditions = {};
				// for (let cp = 0; cp < lkp_lr_body_condition.length; cp++) {
				// 	const element = lkp_lr_body_condition[cp];
				// 	lrBodyConditions[element.id] = element.name;
				// }
				// const srBodyConditions = {};
				// for (let cp = 0; cp < lkp_sr_body_condition.length; cp++) {
				// 	const element = lkp_sr_body_condition[cp];
				// 	srBodyConditions[element.id] = element.name;
				// }
				// const animalTypes = {};
				// for (let cp = 0; cp < lkp_animal_type.length; cp++) {
				// 	const element = lkp_animal_type[cp];
				// 	animalTypes[element.animal_type_id] = element.name;
				// }
				// const animalHerdTypes = {};
				// for (let cp = 0; cp < lkp_animal_herd_type.length; cp++) {
				// 	const element = lkp_animal_herd_type[cp];
				// 	animalHerdTypes[element.id] = element.name;
				// }
				// const foodGroups = {};
				// for (let cp = 0; cp < lkp_food_groups.length; cp++) {
				// 	const element = lkp_food_groups[cp];
				// 	foodGroups[element.id] = element.name;
				// }
				// const transectPastures = {};
				// for (let cp = 0; cp < lkp_transect_pasture.length; cp++) {
				// 	const element = lkp_transect_pasture[cp];
				// 	transectPastures[element.id] = element.name;
				// }
				// const dryWetPastures = {};
				// for (let cp = 0; cp < lkp_dry_wet_pasture.length; cp++) {
				// 	const element = lkp_dry_wet_pasture[cp];
				// 	dryWetPastures[element.id] = element.name;
				// }
				// const transportMeans = {};
				// for (let cp = 0; cp < lkp_transport_means.length; cp++) {
				// 	const element = lkp_transport_means[cp];
				// 	transportMeans[element.transport_id] = element.name;
				// }

				// const branchs = {};
				// for (let bkey = 0; bkey < branch_list.length; bkey++) {
				// 	const element = branch_list[bkey];
				// 	branchs[element.branch_id] = element.branch_name;
				// }
				// const banks = {};
				// for (let bnkey = 0; bnkey < bank_list.length; bnkey++) {
				// 	const element = bank_list[bnkey];
				// 	banks[element.bank_id] = element.bank_name;
				// }

				let xcelData = [];
				let xcelHeader = [];
				let tableHeaderFields = [];

				
				
				xcelHeader.push("S.No.")
				tableHeaderFields.push('sno')
				xcelHeader.push("Name")
				tableHeaderFields.push('first_name')
				// if(survey_id == 5 || survey_id == 7 || survey_id == 11){
				// 	xcelHeader.push("Market")
				// 	tableHeaderFields.push('market_id')
				// }else if(survey_id == 9 ){
				// 	xcelHeader.push("Transect Pastures")
				// 	tableHeaderFields.push('contributor_name')
				// }else{
				// 	xcelHeader.push("Respondent")
				// 	tableHeaderFields.push('respondent')
				// }

				
				// xcelHeader.push(...['Country','UAI','Sub Location','Cluster']);
				// tableHeaderFields.push(...['country_id','uai_id','sub_location_id','cluster_id']);
				
				for (const key in fields) {
					const label = fields[key]['label'];
					const type = fields[key]['type'];
					const subtype = fields[key]['subtype'];
					// if(type?.startsWith('lkp_') ){
					// 	if(type == 'lkp_country'){
					// 		lkpData['field_'+fields[key]['field_id']] = countries;
					// 	}else if(type == 'lkp_uai'){
					// 		lkpData['field_'+fields[key]['field_id']] = uais;
					// 	}else if(type == 'lkp_sub_location'){
					// 		lkpData['field_'+fields[key]['field_id']] = subLocations;
					// 	}else if(type == 'lkp_cluster'){
					// 		lkpData['field_'+fields[key]['field_id']] = clusters;
					// 	}else if(type == 'lkp_location_type'){
					// 		lkpData['field_'+fields[key]['field_id']] = locationtypes;
					// 	}else if(type == 'lkp_market'){
					// 		lkpData['field_'+fields[key]['field_id']] = markets;
					// 	}else if(type == 'lkp_animal_type_lactating'){
					// 		lkpData['field_'+fields[key]['field_id']] = animaltypelactatings;
					// 		lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
					// 	}else if(type == 'lkp_lr_body_condition'){
					// 		lkpData['field_'+fields[key]['field_id']] = lrBodyConditions;
					// 	}else if(type == 'lkp_sr_body_condition'){
					// 		lkpData['field_'+fields[key]['field_id']] = srBodyConditions;
					// 	}else if(type == 'lkp_animal_type'){
					// 		lkpData['field_'+fields[key]['field_id']] = animalTypes;
					// 		lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
					// 	}else if(type == 'lkp_animal_herd_type'){
					// 		lkpData['field_'+fields[key]['field_id']] = animalHerdTypes;
					// 		lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
					// 	}else if(type == 'lkp_food_groups'){
					// 		lkpData['field_'+fields[key]['field_id']] = foodGroups;
					// 		lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
					// 	}else if(type == 'lkp_transect_pasture'){
					// 		lkpData['field_'+fields[key]['field_id']] = transectPastures;
					// 	}else if(type == 'lkp_dry_wet_pasture'){
					// 		lkpData['field_'+fields[key]['field_id']] = dryWetPastures;
					// 	}else if(type == 'lkp_transport_means'){
					// 		lkpData['field_'+fields[key]['field_id']] = transportMeans;
					// 	}else if(type == 'lkp_branch_details'){
					// 		lkpData['field_'+fields[key]['field_id']] = branchs;
					// 	}else if(type == 'lkp_farmer_bank_details'){
					// 		lkpData['field_'+fields[key]['field_id']] = banks;
					// 	}
					// }
					if(type=='file' && subtype == 'image'){
						imageData['field_'+fields[key]['field_id']]="<?php echo base_url(); ?>uploads/survey/";
					}
					// if(type?.startsWith('checkbox') ){
					// 	if(type == 'checkbox-group'){
					// 		lkpData['field_'+fields[key]['field_id']] = banks;
					// 	}
					// }
					if(label != "Declaration"){
						// if (type == 'kml') {
						// 		// tableHead += `<th>`+label+`</th>`;
						// 		xcelHeader.push(label)
						// 		tableHeaderFields.push('field_'+fields[key]['field_id']);
							
						// }else{
						// 	// tableHead += `<th>`+label+`</th>`;
						
							xcelHeader.push(label)
							tableHeaderFields.push('field_'+fields[key]['field_id']);

						// }
					}
				}
				// tableHead += `<th>Uploaded By</th><th>Uploaded Datetime</th>`;
				xcelHeader.push(...['Phone number','Email ID','Username','Role','Status','Uploaded Date']);
				tableHeaderFields.push(...['mobile_number','email_id','username','role_name','status','added_datetime']);


				if(submitedData.length > 0){
					const xcelBody = [];
					// var tableBody ="";
					
					for (let i=0; i<submitedData.length; i++){
						const elemnt = submitedData[i];
						const row = [];
						elemnt.sno = i+1;
						// elemnt.country_id = countries[elemnt.country_id] || elemnt.country_id || "N/A";
						// elemnt.uai_id = uais[elemnt.uai_id] || elemnt.uai_id || "N/A";
						// elemnt.sub_location_id = subLocations[elemnt.sub_location_id] || elemnt.sub_location_id || "N/A";
						// elemnt.cluster_id = clusters[elemnt.cluster_id] || elemnt.cluster_id || "N/A";
						// elemnt.pa_verified_status = verified_list[0][elemnt.pa_verified_status] || elemnt.pa_verified_status || "N/A";
						for (let k = 0; k < tableHeaderFields.length; k++) {
							const key = tableHeaderFields[k];
							if(lkpData[key]){
								var Multiple_options = '';
								if(!lkpDataMultiple[key]){
									row.push(lkpData[key][elemnt[key]] || elemnt[key] || "N/A");									
								}else{
									var field_val_array = elemnt[key].split("&#44;");
									for (let j = 0; j < field_val_array.length; j++) {
										const f_loop_key = field_val_array[j];
										Multiple_options += ''+lkpData[key][f_loop_key]+',';
									}
									row.push(Multiple_options|| lkpData[key][elemnt[key]] || elemnt[key] || "N/A");
								}
							}else{
								if(imageData[key]){
									const imgvalue=''+imageData[key]+''+elemnt[key];
									row.push(imgvalue || elemnt[key] || 'N/A');
								}else{
                  if(key=='status'){
                    var rstatus = "";
                    if(elemnt[key]==0){
                      rstatus ="Inactive";
                    }else if(elemnt[key]==1){
                      rstatus ="Active";
                    }else if(elemnt[key]==-1){
                      rstatus ="Deleted";
                    }else if(elemnt[key]==2){
                      rstatus ="Rejected";
                    }else{
                      rstatus ="N/A";
                    }
                    row.push(rstatus || rstatus || 'N/A');
                  }else if(key=='first_name'){
                    var name ="";
                    name = elemnt[key]+" "+elemnt['last_name'];
                    row.push(name || name || 'N/A');
                  }else{
                    row.push(elemnt[key] || elemnt[key] || 'N/A');
                  }
								}
							}
						}
						xcelBody.push(row);
					}
					xcelData.push(xcelHeader)
					xcelData.push(...xcelBody)
					exportToXcel('Users List', xcelData);
					$("#export_sub").prop('disabled', false);
                	$("#export_sub").html("Export data");
				}else{
					// comment
				}
			}
		});		
	}
</script>
