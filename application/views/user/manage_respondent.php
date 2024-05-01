<link href="<?php echo base_url(); ?>include/assets/css/bootstrap-select.min.css" rel="stylesheet" />
<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }
</style>

<!-- Main content -->
  <div class="container-fluid">
      <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
              <nav>
                  <ol class="breadcrumb mb-0 bg-transparent">
                      <li class="breadcrumb-item">
                          <a href="#">Manage Contributers</a>
                      </li>
                      <li class="breadcrumb-item active"> Manage Respondents</li>
                  </ol>
              </nav>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="card mt-3 border-0">
                  <div class="card-body">
                      <?php echo form_open('', array('class' => 'row', 'id' => 'mapRespondentForm', 'autocomplete' => 'off')); ?>
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <div class="d-flex justify-content-end align-items-center">
                                  <a href="<?php echo base_url(); ?>users/manage" class="btn btn-outline-dark-back text-dark"><span><img src="<?php echo base_url(); ?>include/assets/images/collapse-arrow.svg"></span> Back</a>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <div class="form-group">
                                  <label class="label-text-1">Select Contributors</label>
                                  <select class="form-control" name="contributer">
                                      <?php if($user_id == '') { ?>
                                      <option value="" selected="true">....Select....</option>
                                      <?php } ?>
                                      <?php foreach ($contributers as $key => $user) { ?>
                                      <option value="<?php echo $user['user_id']; ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <div class="form-group">
                                  <label class="label-text-1">Select Cluster and UAI</label><br>
                                  <select class="form-control" id="cluster_uai" name="loc_type">
                                      <option value="" selected="true">....Select....</option>
                                      <option value="cluster">Cluster</option>
                                      <option value="uai">UAI</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <div id="cluster" class="clusteruai_data cluster">
                                  <div class="row">
                                      <div class="col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                              <label class="label-text-1">Cluster</label>
                                              <select class="form-control" name="cluster">
                                                  <option value="" selected="true">....Select....</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div id="uai" class="clusteruai_data uai">
                                  <div class="row">
                                      <div class="col-sm-12 col-md-6 col-lg-6">
                                          <div class="form-group">
                                              <label class="label-text-1">Unit Area of Identification</label>
                                              <select class="form-control" name="uai">
                                                  <option value="" selected="true">....Select....</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-sm-12 col-md-6 col-lg-6">
                                          <div class="form-group">
                                              <label class="label-text-1">Sub Location</label>
                                              <select class="form-control" name="sub_loc">
                                                  <option value="" selected="true">....Select....</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                              <label class="label-text-1">Task Assignment Details</label>
                              <div class="repeatable p-2 mt-1" style="border:1px solid;border-radius:5px;">
                                  <div class="row">
                                      <div class="form-group col-sm-6">
                                          <label class="label-text-1">Select Task</label><br>
                                          <select class="form-control" name="task">
                                              <option value="" selected="true">....Select....</option>
                                              <?php foreach ($tasks as $key => $task) { ?>
                                              <option value="<?php echo $task['id']; ?>"><?php echo $task['title']; ?></option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-sm-6">
                                          <label class="label-text-1">Select Respondents</label><br>
                                          <select class="form-control selectpicker" name="respondents[]" title="Search and select respondent(s)" data-live-search="true" multiple>
                                          </select>
                                      </div>
                                      <div class="form-group col-sm-6">
                                          <label class="label-text-1">Start Date</label>
                                          <input type="date" name="start_date" class="form-control">
                                      </div>
                                      <div class="form-group col-sm-6">
                                          <label class="label-text-1">End Date</label>
                                          <input type="date" name="end_date" class="form-control">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <h6 class="error"></h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <div class="d-flex justify-content-end">
                                  <button class="btn btn-submit text-white" type="submit">Update</button>
                              </div>
                          </div>
                      <?php echo form_close(); ?>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>include/assets/js/bootstrap-select.min.js"></script>
<script>
  $(document).ready(function () {
      $('.selectpicker').selectpicker();
  });

  // Define global variable ajaxData
  var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

  // Handle location type change
  $('body').on('change', '[name="loc_type"]', function(event) {
    let loc_type = $(this),
    contributer = $('[name="contributer"]');

    $(".clusteruai_data").hide();
    $('#mapRespondentForm').find('.error').empty();
    if(loc_type.val().toString().length == 0 || contributer.val().toString().length == 0) {
      $('#mapRespondentForm').find('.error').html('Please select both contributer and location type to get the location details.');
      return false;
    }
    
    $("#" + loc_type.val()).show();
    let uai = $('[name="uai"]'),
    cluster = $('[name="cluster"]'),
    sub_loc = $('[name="sub_loc"]');

    // Empty All Dropdown
    uai.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    cluster.html('<option value="" selected="true">Please Wait... Loading Data</option>');

    // Call fn to get location data
    getLocation(uai, cluster, sub_loc);
  });
  // Handle contributer change
  $('body').on('change', '[name="contributer"]', function(event) {
    let loc_type = $('[name="loc_type"]'),
    contributer = $(this);

    $(".clusteruai_data").hide();
    $('#mapRespondentForm').find('.error').empty();
    if(loc_type.val().toString().length == 0 || contributer.val().toString().length == 0) {
      $('#mapRespondentForm').find('.error').html('Please select both contributer and location type to get the location details.');
      return false;
    }
    
    $("#" + loc_type.val()).show();
    let uai = $('[name="uai"]'),
    cluster = $('[name="cluster"]'),
    sub_loc = $('[name="sub_loc"]');

    // Empty All Dropdown
    uai.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    cluster.html('<option value="" selected="true">Please Wait... Loading Data</option>');

    // Call fn to get location data
    getLocation(uai, cluster, sub_loc);
  });
  // Handle uai change
  $('body').on('change', '[name="uai"]', function(event) {
    let uai = $(this),
    cluster = $('[name="cluster"]'),
    sub_loc = $('[name="sub_loc"]');

    // Call fn to get location data
    getLocation(uai, cluster, sub_loc);
  });
  function getLocation(uai, cluster, sub_loc) {
    sub_loc.html('<option value="" selected="true">....Select....</option>');
    
    //send ajax request to get location details
    ajaxData['loc_type'] = $('[name="loc_type"]').val();
    ajaxData['contributer'] = $('[name="contributer"]').val();
    if(uai.val() && uai.val().toString().length > 0) {
      ajaxData['uai'] = uai.val();
      sub_loc.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    }
    
    $('#mapRespondentForm').find('button').prop('disabled', true);
    $.ajax({
        url: '<?php echo base_url(); ?>users/get_assigned_location',
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
                icon: 'error',
                afterHidden: function () {
                    $('#mapRespondentForm').find('button').prop('disabled', false);

                    let HTML = `<option value="" selected="true">....Select....</option>`;
                    // Assign initial HTML
                    if($('[name="loc_type"]').val() == 'uai') {
                      if(uai.val() && uai.val().toString().length > 0) {
                        sub_loc.html(HTML);
                      } else {
                        uai.html(HTML);
                      }
                    } else if($('[name="loc_type"]').val() == 'cluster') {
                      cluster.html(HTML);
                    }
                }
            });
        },
        success: function(response) {
            $('#mapRespondentForm').find('button').prop('disabled', false);

            let HTML = `<option value="" selected="true">....Select....</option>`;
            // Assign initial HTML
            if($('[name="loc_type"]').val() == 'uai') {
              if(uai.val() && uai.val().toString().length > 0) {
                sub_loc.html(HTML);
              } else {
                uai.html(HTML);
              }
            } else if($('[name="loc_type"]').val() == 'cluster') {
              cluster.html(HTML);
            }

            // If session error exists
            if(response.session_err == 1) {
                $.toast({
                    heading: 'Session Error!',
                    text: response.msg,
                    icon: 'error'
                });
                return false;
            }

            if(response.status == 0) {
                $.toast({
                    heading: 'Error!',
                    text: response.msg,
                    icon: 'error'
                });
                return false;
            }

            // Generate further HTML
            for (var i = 0; i < response.locations.length; i++) {
              let location = response.locations[i];
              HTML += `<option value="${location.id}">${location.name}</option>`;
            }
            // Assign complete HTML
            if($('[name="loc_type"]').val() == 'uai') {
              if(uai.val() && uai.val().toString().length > 0) {
                sub_loc.html(HTML);
              } else {
                uai.html(HTML);
              }
            } else if($('[name="loc_type"]').val() == 'cluster') {
              cluster.html(HTML);
            }
        }
    });
  }

  // Handle cluster change
  $('body').on('change', '[name="cluster"]', function(event) {
    let cluster = $(this);

    // Call fn to get respondent data
    getRespondent(cluster.val());
  });
  // Handle sub location change
  $('body').on('change', '[name="sub_loc"]', function(event) {
    let sub_loc = $(this);

    // Call fn to get respondent data
    getRespondent(sub_loc.val());
  });
  function getRespondent(location) {
    let loc_type = $('[name="loc_type"]'),
    contributer = $('[name="contributer"]'),
    respondent = $('[name="respondents[]"]');

    //send ajax request to get location details
    ajaxData['location'] = location;
    ajaxData['loc_type'] = $('[name="loc_type"]').val();
    ajaxData['contributer'] = $('[name="contributer"]').val();
    
    $('#mapRespondentForm').find('button').prop('disabled', true);
    respondent.empty();
    $('.selectpicker').selectpicker('refresh');
    $.ajax({
        url: '<?php echo base_url(); ?>users/get_assigned_repondent',
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
                icon: 'error',
                afterHidden: function () {
                    $('#mapRespondentForm').find('button').prop('disabled', false);
                    respondent.empty();
                    $('.selectpicker').selectpicker('refresh');
                }
            });
        },
        success: function(response) {
            $('#mapRespondentForm').find('button').prop('disabled', false);

            let HTML = ``;
            // Assign initial HTML
            // respondent.html(HTML);

            // If session error exists
            if(response.session_err == 1) {
                $.toast({
                    heading: 'Session Error!',
                    text: response.msg,
                    icon: 'error'
                });
                return false;
            }

            if(response.status == 0) {
                $.toast({
                    heading: 'Error!',
                    text: response.msg,
                    icon: 'error'
                });
                return false;
            }

            // Generate and assign further HTML
            for (var i = 0; i < response.respondents.length; i++) {
              let respondent = response.respondents[i];
              HTML += `<option value="${respondent.data_id}">${respondent.first_name} ${respondent.last_name}</option>`;
            }
            respondent.html(HTML);
            $('.selectpicker').selectpicker('refresh');
        }
    });
  }


  //Handle form submit
  $('body').on('submit', '#mapRespondentForm', function(event) {
      event.preventDefault();
      $('.error').empty();
      $('#mapRespondentForm').find('button').prop('disabled', true);

      formData = new FormData($(this)[0]);
      $.ajax({
          url: '<?php echo base_url(); ?>users/assign_task_respondent',
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
              $('#mapRespondentForm').find('button').prop('disabled', false);
              $.toast({
                  heading: 'Network Error!',
                  text: 'Could not establish connection to server. Please refresh the page and try again.',
                  icon: 'error'
              });
          },
          success: function(data) {
              var data = JSON.parse(data);
              $('#mapRespondentForm').find('button').prop('disabled', false);

              // If session error exists
              if(data.session_err == 1) {
                  $.toast({
                      heading: 'Session Error!',
                      text: data.msg,
                      icon: 'error'
                  });
              }

              if(data.status == 1) {
                  // If update completed
                  $.toast({
                      heading: 'Success!',
                      text: data.msg,
                      icon: 'success',
                      hideAfter: "10000"
                  });
                  $('#mapRespondentForm')[0].reset();
                  $('[name="respondents[]"]').html('');
                  $('.selectpicker').selectpicker('refresh');
              } else if(data.status == 0) {
                  $.toast({
                      heading: 'Error!',
                      text: data.msg,
                      icon: 'error',
                      hideAfter: "10000"
                  });
              }
          }
      });
  });
</script>
