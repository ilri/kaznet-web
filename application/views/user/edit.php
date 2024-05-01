<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }

  ul {
    list-style-type: none;
    margin: 3px;
  }
  ul.checktree li:before {
    height: 1em;
    width: 12px;
    border-bottom: 1px dashed;
    content: "";
    display: inline-block;
    top: -0.3em;
  }
  ul.checktree li.blocks {
    margin-right: 50px;
    vertical-align: top;
    display: inline-block;
  }
  ul.checktree li { border-left: 1px dashed; }
  ul.checktree li.blocks:last-child { margin-right: 0; }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>include/vendors/checkbox-tree/css/styles.css">

<!-- user personal edit modal -->
<div id="UserEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit User Personal Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 ajax_message error"></div>
        </div>
        <?php echo form_open('', array('id' => 'EditUserForm', 'class' => 'form-group')); ?>
          <div class="row">
            <div class="col-md-6">
              <label>First name</label> <span class="text-danger">*</span>
              <input type="text" name="fname" class="form-control" placeholder="Enter First name">
              <span id="fname_error" class="error"></span>
            </div>
            <div class="col-md-6">
              <label>Last name</label> <span class="text-danger">*</span>
              <input type="text" name="lname" class="form-control" placeholder="Enter Last name">
              <span id="lname_error" class="error"></span>
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

<!-- user professional edit modal -->
<div id="UserProfessionalEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit User Professional Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 ajax_message error"></div>
        </div>
        <?php echo form_open('', array('id' => 'EditUserProfForm', 'class' => 'form-group')); ?>
          <?php if($this->session->userdata('role') < 4) { ?>
          <div class="row">
            <div class="col-md-12"><label for="user_role">Select Type of User</label></div>
            <div class="form-group col-md-6">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="user_type" id="partnerUser" value="partner">
                <label class="custom-control-label" for="partnerUser">Partner User</label>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="user_type" id="orgUser" value="organization">
                <label class="custom-control-label" for="orgUser">Organization(ICRISAT) User</label>
              </div>
            </div>
          </div>
          <?php } ?>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_role">Select Role<span style="color:red;">*</span></label>
              <select class="form-control" name="user_role"></select>
              <p class="user_role error" style="color: red;"></p>
            </div>

            <div class="form-group col-md-6">
              <label for="user_project">Select Project<span style="color:red;">*</span></label>
              <select class="form-control" name="user_project[]" multiple></select>
              <p class="user_project error" style="color: red;"></p>
            </div>
          </div>

          <div class="form-group agency hidden">
            <label for="user_agency">Select Agency<span style="color:red;">*</span></label>
            <select class="form-control" name="user_agency"></select>
            <p class="user_agency error" style="color: red;"></p>
          </div>

          <div class="form-group locations"></div>
          
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
<!-- user professional edit modal ends -->

<div class="app-content content" style="margin-left: 0px;">
  <div class="content-wrapper">
    <div class="content-body" style="margin-bottom: 30px;">
      <div class="row">
        <div class="col-12">          
          <div class="card">
            <div class="card-content collapse show">
              <div class="card-header">
                <h4 class="card-title">All Users</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Sl.no</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email id</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($users) > 0){
                        foreach ($users as $ukey => $user) { ?>
                          <tr data-user_id="<?php echo $user['user_id']; ?>">
                            <td><?php echo ($ukey+1); ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['email_id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['role_name']; ?></td>
                            <td>
                              <a href="javascript:void(0);" class="edit">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i> Personal
                              </a>
                              <?php if($user['role_id'] == 3 || $user['role_id'] == 4 || $user['role_id'] == 5) { ?>
                              <span class="mx-1">|</span>
                              <a href="javascript:void(0);" class="editProf">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i> Professional
                              </a>
                              <?php } ?>
                            </td>
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
</div>

<script src="<?php echo base_url(); ?>include/vendors/checkbox-tree/js/checktree.js"></script>
<script src="<?php echo base_url(); ?>includeout/bootstrap-select/bootstrap-select.js"></script>
<script type="text/javascript">
$(function(){
  $("[name='user_project[]']").selectpicker({
    actionsBox: true
  });
  
  // Define global variable ajaxData
  var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };
  
  // Handle edit and editProf button click
  $('body').on('click', '.edit', function(event){
    $elem = $(this);
    $('.ajax_message').css('display', 'block');
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
        $('#EditUserForm').find('button').prop('disabled', false);
        $('#EditUserForm').find('button[type="submit"]').html('Update');
        var csrfData = JSON.parse(data.responseText);
        ajaxData[csrfData.csrfName] = csrfData.csrfHash;
        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
          $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
        }
      },
      error: function() {
        $('.ajax_message').html('<div class="alert alert-danger">Could not establish connection to server. Please refresh the page and try again.</div>');
      },
      success: function(response){
        $('[name="fname"]').val(response.user_details.first_name);
        $('[name="lname"]').val(response.user_details.last_name);
      }
    });
  }).on('click', '.editProf', function(event){
    $elem = $(this);
    $('.ajax_message').css('display', 'block');
    var user_id = $elem.closest('tr').data('user_id');
    $('#UserProfessionalEditModal').find('.error').empty();
    $('#UserProfessionalEditModal').modal('show');
    $('#EditUserProfForm').data('user_id', user_id);
    $('#EditUserProfForm').find('button').prop('disabled', true);
    $('#EditUserProfForm').find('button[type="submit"]').html('Please Wait... Getting User Details');
    
    //send ajax request to get user data to edit
    ajaxData['user_id'] = user_id;
    $.ajax({
      url: '<?php echo base_url(); ?>Users/get_user_details',
      type: 'POST',
      dataType : 'json',
      data: ajaxData,
      complete: function(data) {
        $('#EditUserProfForm').find('button').prop('disabled', false);
        $('#EditUserProfForm').find('button[type="submit"]').html('Update');
        var csrfData = JSON.parse(data.responseText);
        ajaxData[csrfData.csrfName] = csrfData.csrfHash;
        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
          $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
        }
      },
      error: function() {
        $('.ajax_message').html('<div class="alert alert-danger">Could not establish connection to server. Please refresh the page and try again.</div>');
      },
      success: function(response){
        var form = $('#EditUserProfForm'),
        userDetails = response.user_details;
        
        if(!userDetails.partner) {
          form.find('[name="user_type"][value="partner"]').prop('checked', true);
        } else {
          if(userDetails.partner.status == 1) {
            form.find('[name="user_type"][value="partner"]').prop('checked', true);
          } else {
            form.find('[name="user_type"][value="organization"]').prop('checked', true);
          }
        }
        var user_type = $('[name="user_type"]:checked').val();
        if($('[name="user_type"]').length === 0) user_type = 'partner';

        var projHTML = '';
        for(var project of response.projects) {
          var selected = userDetails.projects.includes(project.project_id) ? ' selected' : '';
          projHTML += '<option value="'+project.project_id+'"'+selected+'>'+project.project_name+'</option>';
        }
        $('[name="user_project[]"]').html(projHTML).selectpicker('refresh');

        var roleHTML = '<option value="">-- Select --</option>';
        for(var role of response.roles) {
          var selected = (userDetails.role_id == role.role_id) ? ' selected' : '';
          if(user_type == 'organization') {
            if(role.role_id == 3 || role.role_id == 5) {
              roleHTML += '<option value="'+role.role_id+'"'+selected+'>'+role.role_name+'</option>';
            }
          } else if(user_type == 'partner') {
            if(role.role_id == 4 || role.role_id == 5) {
              roleHTML += '<option value="'+role.role_id+'"'+selected+'>'+role.role_name+'</option>';
            }
          }
        }
        $('[name="user_role"]').html(roleHTML);
        var user_role = $('[name="user_role"]').val();

        if(user_type == 'organization') {
          $('.agency').addClass('hidden');
        } else if(user_type == 'partner') {
          if(user_role.length === 0 || user_role == 3) $('.agency').addClass('hidden');
          else $('.agency').removeClass('hidden');
        }
        var partners = [];
        for(var partner of response.partners) {
          if(user_type == 'organization') {
            if(partner.status == 2) partners.push(partner);
          } else if(user_type == 'partner') {
            if(partner.status == 1) partners.push(partner);
          }
        }
        var partnerHTML = '<option value="">-- Select --</option>';
        for(var partner of partners) {
          var selected = (userDetails.partner.partner_id == partner.partner_id) ? ' selected' : '';
          partnerHTML += '<option value="'+partner.partner_id+'"'+selected+'>'+partner.partner_name+'</option>'
        }
        $('[name="user_agency"]').html(partnerHTML);

        var locationHTML = `<label>Tag Locations To User<span style="color:red;">*</span></label>`;
        for(country of response.locations) {
          locationHTML += `<ul class="checktree">
            <li>
              <input id="country_${country.id}" type="checkbox" />
              <label for="country_${country.id}">${country.country}</label>
              <ul>`;
              for(state of country.states) {
                locationHTML += `<li>
                  <input id="state_${state.id}" type="checkbox" />
                  <label for="state_${state.id}">${state.state}</label>
                  <ul>`;
                  for(district of state.districts) {
                    locationHTML += `<li>
                      <input id="district_${district.id}" type="checkbox" />
                      <label for="district_${district.id}">${district.district}</label>
                      <ul>`;
                      for(block of district.blocks) {
                        locationHTML += `<li class="blocks">
                          <input id="block_${block.id}" type="checkbox" />
                          <label for="block_${block.id}">${block.block}</label>
                          <ul>`;
                          for(village of block.villages) {
                            var checked = userDetails.locations.includes(village.id) ? 'checked' : '';
                            locationHTML += `<li>
                              <input id="village_${village.id}" type="checkbox" name="villages[]" value="${village.id}" ${checked}/>
                              <label for="village_${village.id}">${village.village}</label>
                            </li>`;
                          }
                          locationHTML += `</ul>
                        </li>`;
                      }
                      locationHTML += `</ul>
                    </li>`;
                  }
                  locationHTML += `</ul>
                </li>`;
              }
              locationHTML += `</ul>
            </li>
          </ul>
          <p class="villages error" style="color: red;"></p>`;
        }
        $('.locations').html(locationHTML);
        $('ul.checktree').checktree();
      }
    });
  });

  


  // Handle user_role and user_type on change to show agency & locations
  $('body').on('change', '[name="user_role"]', function(event) {
    var user_role = $(this).val(),
    user_type = $('[name="user_type"]:checked').val();
    if($('[name="user_type"]').length === 0) user_type = 'partner';
    
    if(user_type == 'organization') {
      $('.agency').addClass('hidden');
    } else if(user_type == 'partner') {
      if(user_role.length === 0 || user_role == 3) $('.agency').addClass('hidden');
      else $('.agency').removeClass('hidden');
    }
  }).on('change', '[name="user_type"]', function(event) {
    var elem = $(this),
    roles = <?php echo json_encode($all_roles); ?>,
    projects = <?php echo json_encode($projects); ?>;

    var roleHTML = '<option value="">-- Select --</option>';
    for(role of roles) { if(elem.val() == 'organization') {
      if(role.role_id == 3 || role.role_id == 5) {
        roleHTML += '<option value="'+role.role_id+'">'+role.role_name+'</option>';
      }
    } else if(elem.val() == 'partner') {
      if(role.role_id == 4 || role.role_id == 5) {
        roleHTML += '<option value="'+role.role_id+'">'+role.role_name+'</option>';
      }
    }}

    var projHTML = '';
    for(project of projects) {
      projHTML += '<option value="'+project.project_id+'">'+project.project_name+'</option>';
    }

    $('[name="user_role"]').html(roleHTML).val('').trigger('change');
    $('[name="user_project[]"]').html(projHTML);
    if(projects.length === 1) {$('.selectpicker').selectpicker('render');
      $('[name="user_project[]"]').val(projects[0].project_id);
    } else {
      $('[name="user_project[]"]').val(null);
    }
    $('[name="user_project[]"]').selectpicker('render');
    $('[name="user_project[]"]').trigger('change');
  });

  // Handle user_project on change to get agency
  $('[name="user_project[]"]').on('change', function(event) {
    var elem = $(this),
    user_type = $('[name="user_type"]:checked').val(),
    partnerHTML = '<option value="">-- Select --</option>';
    $('[name="user_agency"]').html(partnerHTML).val('').trigger('change');
    if($('[name="user_type"]').length === 0) user_type = 'partner';
    if(elem.val().length === 0) return false;
    
    $('button').prop('disabled', true);
    $('button[type="submit"]').html('Getting Agencies...');
    ajaxData['project_id'] = elem.val();
    $.ajax({
      url: '<?php echo base_url(); ?>projects/project_partners',
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
        $('.ajax_message').html('<div class="alert alert-danger">Could not establish connection to server. Please refresh the page and try again.</div>');
        $('button').prop('disabled', false);
        $('button[type="submit"]').html('Add User');
      },
      success: function(response){
        $('button').prop('disabled', false);
        $('button[type="submit"]').html('Add User');
        if(response.status == 0 || response.status == 2){
          $('.ajax_message').html('<div class="alert alert-danger">'+response.msg+'</div>').delay(3000).fadeOut();
          $('html,body').animate({
            scrollTop: $(".ajax_message").offset().top - 300
          }, 500);
          return false;
        }
        
        var partners = [];
        for(partner of response.partners) {
          if(user_type == 'organization') {
            if(partner.status == 2) partners.push(partner);
          } else if(user_type == 'partner') {
            if(partner.status == 1) partners.push(partner);
          }
        }
        for(partner of partners) {
          partnerHTML += '<option value="'+partner.partner_id+'">'+partner.partner_name+'</option>'
        }
        $('[name="user_agency"]').html(partnerHTML);

        if(partners.length === 1)
        $('[name="user_agency"]').val(partners[0].partner_id).trigger('change');
      }
    });
  });

  // Handle user_agency on change to get agency locations
  $('[name="user_agency"]').on('change', function(event) {
    var elem = $(this),
    user_type = $('[name="user_type"]:checked').val();
    if($('[name="user_type"]').length === 0) user_type = 'partner';
    
    if(elem.val().length === 0) {
      if(user_type == 'partner') {
        $('.locations').html('<h4 class="text-center">Select An Agency To View Operating Locations</h4>');
      } else {
        $('.locations').html('<h4 class="text-center">Select A Project To View Operating Locations</h4>');
      }
      return false;
    }
    
    $('button').prop('disabled', true);
    $('button[type="submit"]').html('Getting Agency Locations...');
    ajaxData['user_type'] = user_type;
    ajaxData['partner_id'] = elem.val();
    $.ajax({
      url: '<?php echo base_url(); ?>partners/partner_locations',
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
        $('.ajax_message').html('<div class="alert alert-danger">Could not establish connection to server. Please refresh the page and try again.</div>');
        $('button').prop('disabled', false);
        $('button[type="submit"]').html('Add User');
      },
      success: function(response){
        $('button').prop('disabled', false);
        $('button[type="submit"]').html('Add User');
        if(response.status == 0){
          $('.ajax_message').html('<div class="alert alert-danger">'+response.msg+'</div>').delay(3000).fadeOut();
          $('html,body').animate({
            scrollTop: $(".ajax_message").offset().top - 300
          }, 500);
          return false;
        }
        
        var locationHTML = `<label>Tag Locations To User<span style="color:red;">*</span></label>`;
        for(country of response.countries) {
          locationHTML += `<ul class="checktree">
            <li>
              <input id="country_${country.id}" type="checkbox" />
              <label for="country_${country.id}">${country.country}</label>
              <ul>`;
              for(state of country.states) {
                locationHTML += `<li>
                  <input id="state_${state.id}" type="checkbox" />
                  <label for="state_${state.id}">${state.state}</label>
                  <ul>`;
                  for(district of state.districts) {
                    locationHTML += `<li>
                      <input id="district_${district.id}" type="checkbox" />
                      <label for="district_${district.id}">${district.district}</label>
                      <ul>`;
                      for(block of district.blocks) {
                        locationHTML += `<li class="blocks">
                          <input id="block_${block.id}" type="checkbox" />
                          <label for="block_${block.id}">${block.block}</label>
                          <ul>`;
                          for(village of block.villages) {
                            locationHTML += `<li>
                              <input id="village_${village.id}" type="checkbox" name="villages[]" value="${village.id}" />
                              <label for="village_${village.id}">${village.village}</label>
                            </li>`;
                          }
                          locationHTML += `</ul>
                        </li>`;
                      }
                      locationHTML += `</ul>
                    </li>`;
                  }
                  locationHTML += `</ul>
                </li>`;
              }
              locationHTML += `</ul>
            </li>
          </ul>
          <p class="villages error" style="color: red;"></p>`;
        }
        $('.locations').html(locationHTML);
        $('ul.checktree').checktree();
      }
    });
  });

  


  //Handle user personal and professional edit form submit
  $('body').on('submit', '#EditUserForm', function(event) {
    event.preventDefault();
    $('.error').empty();
    $('.ajax_message').css('display', 'block');
    var fname = $('[name="fname"]').val();
    var lname = $('[name="lname"]').val();
    // var role = $('[name="role"]').val();
    var user_id = $(this).data('user_id');
    var error = false;

    var form = $(this);
    $('input[type="text"]', form).each(function(index) {
      var elem = $(this);
      elem.val($.trim(elem.val()));
    });

    if($.trim(fname).length == 0){
      error = true;
      $('#fname_error').html('First name is mandatory');
    }

    if($.trim(lname).length == 0){
      error = true;
      $('#lname_error').html('Last name is mandatory');
    }

    if(!error){
      ajaxData['user_id'] = user_id;
      ajaxData['fname'] = fname;
      ajaxData['lname'] = lname;
      // ajaxData['role'] = role;
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
          $('.ajax_message').html('<div class="alert alert-danger">Could not establish connection to server. Please refresh the page and try again.</div>');
        },
        success: function(response){
          $('.ajax_message').html('<div class="alert alert-success">'+response.msg+'</div>').fadeOut(3000);
          location.reload();
        }
      });
    }
  }).on('submit', '#EditUserProfForm', function(event) {
    event.preventDefault();
    var form = $(this);
    form.find('.error').empty();
    form.find('button').prop('disabled', true);
    form.find('button[type="submit"]').html('Please wait...');

    var formData = new FormData($(this)[0]);
    formData.append('user_id', form.data('user_id'));
    $.ajax({
      url: '<?php echo base_url(); ?>users/update_user_details_professional/',
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
        form.find('button').prop('disabled', false);
        form.find('button[type="submit"]').html('Update');
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

          form.find('button').prop('disabled', false);
          form.find('button[type="submit"]').html('Update');
        }

        // If validation error exists
        if(data.status > 0) {
          for(var key in data) {
            var errorContainer = form.find(`.${key}.error`);
            if(errorContainer.length !== 0) {
              errorContainer.html(data[key]);
            }
          }
          form.find('button').prop('disabled', false);
          form.find('button[type="submit"]').html('Update');
        }

        if(data.updatestatus == 1) {
          // If update completed
          $.toast({
            heading: 'Success!',
            text: data.msg,
            icon: 'success',
            afterHidden: function () {
              window.location.href = '<?php echo base_url(); ?>users/edit';
            }
          });
        } else if(data.updatestatus == 0) {
          $.toast({
            heading: 'Error!',
            text: data.msg,
            icon: 'error'
          });
          form.find('button').prop('disabled', false);
          form.find('button[type="submit"]').html('Update');
        }
      }
    });
  });
});
</script>
