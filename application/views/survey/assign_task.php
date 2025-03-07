<link href="<?php echo base_url(); ?>include/assets/css/bootstrap-select.min.css" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->
<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }
  /* respondent css */
  .tree ul {
            list-style: none;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .tree ul:before {
            content: "";
            display: block;
            border-left: 1px solid #ccc;
            height: 100%;
            position: absolute;
            top: 0;
            left: 16px;
        }

        .tree li {
            margin: 0;
            padding: 0 3em;
            position: relative;
            line-height: 2.5em;
            font-size: 14px;
        }

        .tree li:before {
            content: "";
            display: block;
            border-top: 1px solid #ccc;
            border-right: 1px solid #ccc;
            width: 12px;
            display: none;
            height: 12px;
            background: #fff;
            position: absolute;
            top: 1em;
            left: -6px;
            border-radius: 50%;
        }

        .tree li:after {
            content: "";
            display: block;
            border-top: 1px solid #ccc;
            width: 6%;
            position: absolute;
            top: 1em;
            left: 16px;
        }

        .tree ul li span {
            font-weight: 500;
            padding-left: 9px;
        }
</style>



    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Task Management</a></li>
                        <li class="breadcrumb-item active">Assign Task</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <?php echo form_open('', array('id' => 'assignTaskForm', 'autocomplete' => 'off')); ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Task Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="task_type">
                                        <?php foreach ($tasks_types as $key => $tasks_type) { ?>
                                        <option value="<?php echo $tasks_type['type']; ?>" <?php if($task_type && $task_type == $tasks_type['type']) echo 'selected="true"'; else if($key == 0) echo 'selected="true"'; ?>><?php echo $tasks_type['type']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Task Name <span class="text-danger">*</span></label>
                                    <!-- <select class="form-control" name="task">
                                        <option value="" selected="true">....Select....</option>
                                    </select> -->
                                    <select class="form-control selectpicker" name="tasks[]" title="Search and select task(s)" data-live-search="true" multiple>
                                    </select>
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Start Date <span class="text-danger">*</span></label>
                                    <input type="date"  name="start_date" class="form-control datepicker">
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">End Date <span class="text-danger">*</span></label>
                                    <input type="date" name="end_date" class="form-control enddate">
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="border-bottom mt-3 mb-3"></div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12  mt-3 mb-4">
                                        <label class="label-text-1">Location Details</label>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label class="label-text-1">Country <span class="text-danger">*</span></label>
                                            <select class="form-control" name="country">
                                                <option value="" selected="true">....Select....</option>
                                                <?php foreach ($countries as $key => $country) { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="error d-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-1">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="loc_type" value="uai">
                                                <label class="form-check-label" for="inlineRadio1">UAI</label>
                                            </div><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="loc_type" value="cluster">
                                                <label class="form-check-label" for="inlineRadio2">Cluster</label>
                                            </div>
                                            <span class="error d-block"></span>
                                        </div>
                                    </div>
                                    
                            

                                    <div class="col-sm-12 col-md-5 col-lg-7">
                                        <div id="uai" class="clusteruai_data uai">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label class="label-text-1">Unit Area of Identification <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="uai">
                                                            <option value="" selected="true">....Select....</option>
                                                        </select>
                                                        <span class="error d-block"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label class="label-text-1">Sub Location <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="sub_loc">
                                                            <option value="" selected="true">....Select....</option>
                                                        </select>
                                                        <span class="error d-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--uai location end-->
                                        <div id="cluster" class="clusteruai_data cluster">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="label-text-1">Cluster <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="cluster">
                                                            <option value="" selected="true">....Select....</option>
                                                        </select>
                                                        <span class="error d-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--clustor location end-->
                                    </div>
                                    
                                </div>
                                
                                <div class="border-bottom mt-3 mb-3"></div>
                            

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                                        <label class="label-text-1">Assignee Details</label>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label class="label-text-1">Select Contributor <span class="text-danger">*</span></label><br>
                                            <select class="form-control selectpicker" name="contributer[]" title="....Select...." id="contributer" multiple>
                                                <!-- <option value="" >....Select....</option> -->
                                            </select>
                                            <span class="error d-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8"></div>

                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group" style="display: none;">
                                            <label class="label-text-1">Respondent(s)</label><br>
                                            <div class="tree">
                                                <div class="respondents"></div>
                                            </div>
                                            <!-- <div class="form-control respondents" style="height: 41px!important;">smpl rt2, Test Sample, rsp sprint1, Respondent7 Test</div> -->
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="label-text-1">Select Market(s) <span class="text-danger">*</span></label><br>
                                            <div class="dropdown bootstrap-select show-tick form-control"> <select class="form-control selectpicker" name="markets[]" title="Search and select maket(s)" data-live-search="true" multiple="" tabindex="-98"></select></div>
                                            <span class="error d-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            <!--<div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                                <label class="label-text-1">Location Details</label>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                                <div class="form-group">
                                    <label class="label-text-1">Country <span class="text-danger">*</span></label>
                                    <select class="form-control" name="country">
                                        <option value="" selected="true">....Select....</option>
                                        <?php foreach ($countries as $key => $country) { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                                <div class="form-group">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="loc_type" value="uai">UAI
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="loc_type" value="cluster">Cluster
                                        </label>
                                    </div>
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div id="cluster" class="clusteruai_data cluster">
                                  <div class="row">
                                      <div class="col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                              <label class="label-text-1">Cluster <span class="text-danger">*</span></label>
                                              <select class="form-control" name="cluster">
                                                  <option value="" selected="true">....Select....</option>
                                              </select>
                                              <span class="error d-block"></span>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                                <div id="uai" class="clusteruai_data uai">
                                  <div class="row">
                                      <div class="col-sm-12 col-md-6 col-lg-6">
                                          <div class="form-group">
                                              <label class="label-text-1">Unit Area of Identification <span class="text-danger">*</span></label>
                                              <select class="form-control" name="uai">
                                                  <option value="" selected="true">....Select....</option>
                                              </select>
                                              <span class="error d-block"></span>
                                          </div>
                                      </div>
                                      <div class="col-sm-12 col-md-6 col-lg-6">
                                          <div class="form-group">
                                              <label class="label-text-1">Sub Location <span class="text-danger">*</span></label>
                                              <select class="form-control" name="sub_loc">
                                                  <option value="" selected="true">....Select....</option>
                                              </select>
                                              <span class="error d-block"></span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="border-bottom mt-3 mb-3"></div>
                            </div>

                            

                            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                                <label class="label-text-1">Assignee Details</label>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Select Contributor <span class="text-danger">*</span></label><br>
                                    <select class="form-control" name="contributer">
                                        <option value="" selected="true">....Select....</option>
                                    </select>
                                    <span class="error d-block"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group" style="display:none;">
                                    <label class="label-text-1">Respondent(s)</label><br>
                                    <div class="form-control respondents" style="height: auto !important;"></div>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label class="label-text-1">Select Market(s) <span class="text-danger">*</span></label><br>
                                    <select class="form-control selectpicker" name="markets[]" title="Search and select maket(s)" data-live-search="true" multiple>
                                    </select>
                                    <span class="error d-block"></span>
                                </div>
                            </div>-->
                            <div class="col-sm-12">
                                <div class="border-bottom mt-3 mb-3"></div>
                            </div>

                            <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="label-text-1">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="label-text-1">End Date</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value=""> Make it recurrent
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom mt-3 mb-3"></div>
                            </div> -->


                            <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-8 col-lg-8">
                                        <label class="label-text-1">Share As</label>
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="" checked>Notification
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value=""> Email
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h6 class="error"></h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-submit text-white ml-2">Assign Task</button>
                                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
<script type="text/javascript">

$(function(){
    $('.selectpicker').selectpicker();
    $('[name="task_type"]').trigger('change');
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByClassName("datepicker")[0].setAttribute('min', today);
    document.getElementsByClassName("enddate")[0].setAttribute('min', today);

});

// window.onload=function(){//from ww  w . j  a  va2s. c  o  m
//     var today = new Date().toISOString().split('T')[0];
//     document.getElementsByClassName("datepicker")[0].setAttribute('min', today);
// }

// Define global variable ajaxData
var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

// Handle task_type change
$('body').on('change', '[name="task_type"]', function(event) {
    let task_type = $(this).val(),
    task = $('[name="tasks[]"]');
    // $('[name="task"]').html('<option value="" selected="true">....Select....</option>');
    $('#assignTaskForm').find('h6.error').empty();
    task.empty();
    task.selectpicker('refresh');

    let loc_type = $('[name="loc_type"]:checked');
    if(loc_type.val() == 'cluster') {
        $('[name="cluster"]').trigger('change');
    } else if(loc_type.val() == 'uai') {
        $('[name="sub_loc"]').trigger('change');
    }

    // Get contributer role details
    ajaxData['task_type'] = task_type;
    $('#assignTaskForm').find('button[type="submit"]').html('Please Wait...');
    $('#assignTaskForm').find('button[type="submit"]').prop('disabled', true);
    $.ajax({
        url: '<?php echo base_url(); ?>survey/get_tasks_by_type',
        type: 'POST',
        dataType : 'json',
        data: ajaxData,
        complete: function(data) {
            $('#assignTaskForm').find('button[type="submit"]').html('Assign Task');
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
                    $('#assignTaskForm').find('button[type="submit"]').prop('disabled', false);
                }
            });
        },
        success: function(response) {
            $('#assignTaskForm').find('button[type="submit"]').prop('disabled', false);

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

            // let HTML = '<option value="" selected="true">....Select....</option>';
            let HTML = '';
            for (var i = 0; i < response.tasks.length; i++) {
              let task = response.tasks[i];
              HTML += `<option value="${task.id}">${task.title}</option>`;
            }
            // $('[name="task"]').html(HTML);
            task.html(HTML);
            task.selectpicker('refresh');

            <?php if($task && strlen($task) > 0) { ?>
                let selectedTask = '<?php echo $task; ?>';
                task.selectpicker('val', selectedTask);
            <?php } ?>
        }
    });
});

// Handle location type change
$('body').on('change', '[name="loc_type"]', function(event) {
    let elem = $(this),
    country = $('[name="country"]').val();
    
    $(".clusteruai_data").hide();
    
    let uai = $('[name="uai"]'),
    cluster = $('[name="cluster"]'),
    sub_loc = $('[name="sub_loc"]');

    // Empty All Dropdown
    uai.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    cluster.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    uai.val('');
    cluster.val('');

    $('#assignTaskForm').find('h6.error').empty();

    if(elem.filter(':checked').length > 0) {
        $("#" + elem.filter(':checked').val()).show();

        if(!country || country.toString().length === 0) {
            $('#assignTaskForm').find('h6.error').html('Please select country to get the location details.');
            return false;
        }

        // Call fn to get location data
        getLocation(uai, cluster, sub_loc);
    }
});
// Handle country change
$('body').on('change', '[name="country"]', function(event) {
    let loc_type = $('[name="loc_type"]:checked').val(),
    country = $('[name="country"]').val();
    
    let uai = $('[name="uai"]'),
    cluster = $('[name="cluster"]'),
    sub_loc = $('[name="sub_loc"]');

    $('#assignTaskForm').find('h6.error').empty();
    // Empty All Dropdown
    uai.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    cluster.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    uai.val('');
    cluster.val('');

    if(!loc_type || loc_type.toString().length === 0) {
        $('#assignTaskForm').find('h6.error').html('Please select location type to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocation(uai, cluster, sub_loc);
});
// Handle uai change
$('body').on('change', '[name="uai"]', function(event) {
    let uai = $(this),
    cluster = $('[name="cluster"]'),
    sub_loc = $('[name="sub_loc"]'),
    country = $('[name="country"]').val();

    $('#assignTaskForm').find('h6.error').empty();

    if(!country || country.toString().length === 0) {
        $('#assignTaskForm').find('h6.error').html('Please select country to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocation(uai, cluster, sub_loc);
});
function getLocation(uai, cluster, sub_loc) {
    sub_loc.html('<option value="" selected="true">....Select....</option>');
    sub_loc.val('');
    
    //send ajax request to get location details
    ajaxData['loc_type'] = $('[name="loc_type"]:checked').val();
    ajaxData['country'] = $('[name="country"]').val();
    if(uai.val() && uai.val().toString().length > 0) {
      ajaxData['uai'] = uai.val();
      sub_loc.html('<option value="" selected="true">Please Wait... Loading Data</option>');
    } else {
        delete ajaxData.uai;
    }
    
    $('#assignTaskForm').find('button').prop('disabled', true);
    $.ajax({
        url: '<?php echo base_url(); ?>survey/get_location',
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
                    $('#assignTaskForm').find('button').prop('disabled', false);

                    let HTML = `<option value="" selected="true">....Select....</option>`;
                    // Assign initial HTML
                    if($('[name="loc_type"]:checked').val() == 'uai') {
                        if(uai.val() && uai.val().toString().length > 0) {
                            sub_loc.html(HTML);
                            sub_loc.val('');
                        } else {
                            uai.html(HTML);
                            uai.val('');
                        }
                    } else if($('[name="loc_type"]:checked').val() == 'cluster') {
                        cluster.html(HTML);
                        cluster.val('');
                    }
                }
            });
        },
        success: function(response) {
            $('#assignTaskForm').find('button').prop('disabled', false);

            let HTML = `<option value="" selected="true">....Select....</option>`;
            // Assign initial HTML
            if($('[name="loc_type"]:checked').val() == 'uai') {
                if(uai.val() && uai.val().toString().length > 0) {
                    sub_loc.html(HTML);
                    sub_loc.val('');
                } else {
                    uai.html(HTML);
                    uai.val('');
                }
            } else if($('[name="loc_type"]:checked').val() == 'cluster') {
                cluster.html(HTML);
                cluster.val('');
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
            if($('[name="loc_type"]:checked').val() == 'uai') {
                if(uai.val() && uai.val().toString().length > 0) {
                    sub_loc.html(HTML);
                    sub_loc.val('');
                } else {
                    uai.html(HTML);
                    uai.val('');
                }
            } else if($('[name="loc_type"]:checked').val() == 'cluster') {
                cluster.html(HTML);
                cluster.val('');
            }
        }
    });
}

// Handle cluster change
$('body').on('change', '[name="cluster"]', function(event) {
    let cluster = $(this);

    // Call fn to get respondent data
    getContributer(cluster.val());
});
// Handle sub location change
$('body').on('change', '[name="sub_loc"]', function(event) {
    let sub_loc = $(this);

    // Call fn to get Contributer data
    getContributer(sub_loc.val());
});
function getContributer(location) {
    let loc_type = $('[name="loc_type"]:checked'),
    contributer = $('[name="contributer[]"]'),
    // respondent = $('.respondents'),
    market = $('[name="markets[]"]');

    //send ajax request to get location details
    ajaxData['location'] = location;
    ajaxData['loc_type'] = loc_type.val();
    
    $('#assignTaskForm').find('button').prop('disabled', true);
    $('.selectpicker').selectpicker('refresh');
    contributer.html('<option value="" selected="true">....Select....</option>');
    $.ajax({
        url: '<?php echo base_url(); ?>survey/get_contributers',
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
                    $('#assignTaskForm').find('button').prop('disabled', false);
                    market.empty();
                    respondent.empty();
                    ajaxData['respondents'] = [];
                    $('.selectpicker').selectpicker('refresh');
                    contributer.html('<option value="" selected="true">....Select....</option>');
                }
            });
        },
        success: function(response) {
            $('#assignTaskForm').find('button').prop('disabled', false);

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


            let HTML = `<option value="">....Select....</option>`;
            // Set contributers
            for (var i = 0; i < response.contributers.length; i++) {
                let contributer = response.contributers[i];
                HTML += `<option value="${contributer.user_id}">${contributer.first_name} ${contributer.last_name}</option>`;
            }
            contributer.html(HTML);

           
            $('.selectpicker').selectpicker('refresh');
        }
    }); 
    let contributer1 = $('[name="contributer[]"]');
    contributer1.html('<option value="" >....Select....</option>');
    $('.selectpicker').selectpicker('refresh'); 
    $('.respondents').empty();
    $('.respondents').closest('.form-group').css('display', 'none'); 
}

$('body').on('change', '[name="contributer[]"]', function(event) {
    let contributer = $(this);

    // Call fn to get Respondents data
    getRespondents(contributer.val());
});

function getRespondents() {
    let loc_type = $('[name="loc_type"]:checked');
    let contributer = $('[name="contributer[]"]');
    // let loc_type = $('[name="loc_type"]:checked'),
    respondent = $('.respondents'),
    market = $('[name="markets[]"]');

    //send ajax request to get location details
    if(loc_type.val() == 'uai'){
        ajaxData['location'] = $('[name="sub_loc"]').val();
    }else{
        ajaxData['location'] = $('[name="cluster"]').val();
    }
    ajaxData['loc_type'] = loc_type.val();
    ajaxData['contributer'] = contributer.val();

    let task_type = $('[name="task_type"]');
    if(task_type.val().toLowerCase() == 'household task') {
        market.closest('.form-group').removeAttr('style');
        respondent.closest('.form-group').removeAttr('style');

        market.closest('.form-group').css('display', 'none');
    } else if(task_type.val().toLowerCase() == 'market task') {
        market.closest('.form-group').removeAttr('style');
        respondent.closest('.form-group').removeAttr('style');
        
        respondent.closest('.form-group').css('display', 'none');
    }
    
    $('#assignTaskForm').find('button').prop('disabled', true);
    market.empty();
    respondent.empty();
    ajaxData['respondents'] = [];
    $('.selectpicker').selectpicker('refresh');
    // contributer.html('<option value="" selected="true">....Select....</option>');
    $.ajax({
        url: '<?php echo base_url(); ?>survey/get_respondents',
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
                    $('#assignTaskForm').find('button').prop('disabled', false);
                    market.empty();
                    respondent.empty();
                    ajaxData['respondents'] = [];
                    
                }
            });
        },
        success: function(response) {
            $('#assignTaskForm').find('button').prop('disabled', false);

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

            let body = [], values = [];
            // Set respondents
            for (var i = 0; i < response.respondents.length; i++) {
                let resp = response.respondents[i];
                values.push(resp.data_id);
            }
            ajaxData['respondents'] = values;
            if(response.respondents.length > 0) {
                reHTML = `<ul>`;
                for (let j = 0; j < response.contributers.length; j++) {
                    let contri = response.contributers[j];
                    reHTML +=`<li><span>${contri.first_name+' '+contri.last_name}</span><ul>`;
                            for (var i = 0; i < response.respondents.length; i++) {
                                let resp = response.respondents[i];
                                if(resp.added_by == contri.user_id){
                                    reHTML +=`<li>${resp.first_name+' '+resp.last_name}</li>`;
                                }
                            }                               
                    reHTML +=`</ul></li>`;
                }
                reHTML +=`</ul>`;


                respondent.html(reHTML);
            } else {
                respondent.html('No respondent registered for the above location combination.');
            }
            

            HTML = ``;
            // Set markets
            for (var i = 0; i < response.markets.length; i++) {
                let mark = response.markets[i];
                HTML += `<option value="${mark.market_id}">${mark.name}</option>`;
            }
            market.html(HTML);
            $('.selectpicker').selectpicker('refresh');
        }
    });
}

//Handle form submit
$('body').on('submit', '#assignTaskForm', function(event) {
    event.preventDefault();
    $('.error').empty();

    let task_type = $('[name="task_type"]'),
    tasks = $('[name="tasks[]"]'),
    start_date = $('[name="start_date"]'),
    end_date = $('[name="end_date"]'),
    country = $('[name="country"]'),
    loc_type = $('[name="loc_type"]:checked'),
    cluster = $('[name="cluster"]'),
    uai = $('[name="uai"]'),
    sub_loc = $('[name="sub_loc"]'),
    contributer = $('[name="contributer[]"]'),
    markets = $('[name="markets[]"]');
    let fields = [task_type, tasks, start_date, end_date, country, contributer];
    
    let fieldErr = 0;
    for(field of fields) {
        if(!field.val() || field.val().length === 0) {
            fieldErr++;
            field.closest('.form-group').find('.error').html('Field is mandatory.');
        }
    }
    if(!loc_type || !loc_type.length || !loc_type.val() || loc_type.val().length === 0) {
        fieldErr++;
        $('[name="loc_type"]').closest('.form-group').find('.error').html('Field is mandatory.');
    }

    if(loc_type.val() == 'cluster') {
        if(!cluster.val() || cluster.val().length === 0) {
            fieldErr++;
            cluster.closest('.form-group').find('.error').html('Field is mandatory.');
        }
        console.log('fieldErr', fieldErr);
    } else if(loc_type.val() == 'uai') {
        if(!uai.val() || uai.val().length === 0) {
            fieldErr++;
            uai.closest('.form-group').find('.error').html('Field is mandatory.');
        }
        if(!sub_loc.val() || sub_loc.val().length === 0) {
            fieldErr++;
            sub_loc.closest('.form-group').find('.error').html('Field is mandatory.');
        }
    }
    if(task_type.val().toLowerCase() == 'market task') {
        if(!markets.val() || markets.val().length === 0) {
            fieldErr++;
            markets.closest('.form-group').find('.error').html('Field is mandatory.');
        }
    }
    
    if(fieldErr > 0) return false;
    
    if(start_date.val() && start_date.val().length > 0 && end_date.val() && end_date.val().length > 0) {
        if(moment(end_date.val()).isBefore(moment(start_date.val()))) {
            $('#assignTaskForm').find('h6.error').html('Start date must be a date before end date.');
            return false;
        }
    }

    formData = new FormData($(this)[0]);
    for(resp of ajaxData['respondents']) {
        formData.append('respondents[]', resp);
    }
    $('#assignTaskForm').find('button').prop('disabled', true);
    $.ajax({
        url: '<?php echo base_url(); ?>survey/assign_task_respondent',
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
            $('#assignTaskForm').find('button').prop('disabled', false);
        },
        error: function() {
          $('#assignTaskForm').find('button').prop('disabled', false);
          $.toast({
              heading: 'Network Error!',
              text: 'Could not establish connection to server. Please refresh the page and try again.',
              icon: 'error'
          });
        },
        success: function(data) {
            var data = JSON.parse(data);
            $('#assignTaskForm').find('button').prop('disabled', false);

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
                    text: data.msg +`<br>`+data.msg1,
                    icon: 'success',
                    hideAfter: "15000"
                });
                $('[name="uai"]').val('');
                $('[name="cluster"]').val('');
                $('[name="sub_loc"]').val('');
                
                $('[name="markets[]"]').empty();
                $('[name="markets[]"]').closest('.form-group').css('display', 'none');
                
                $('.respondents').empty();
                $('.respondents').closest('.form-group').css('display', 'none');
                
                $('#assignTaskForm')[0].reset();
                $('[name="loc_type"]').trigger('change');
                $('[name="task_type"]').trigger('change');
                $('.selectpicker').selectpicker('refresh');
            } else if(data.status == 0) {
                $.toast({
                    heading: 'Error!',
                    text: data.msg && data.msg.length > 0 ? data.msg +`<br>`+data.msg1 : 'Unable to assign task(s).',
                    icon: 'error',
                    hideAfter: "20000"
                });
            }else if(data.status == 2) {
                $.toast({
                    heading: 'Info!',
                    text: data.msg && data.msg.length > 0 ? data.msg +`<br>`+data.msg1+`<br>`+data.msg2 : 'Unable to assign task(s).',
                    icon: 'info',
                    hideAfter: "30000"
                });
            }
        }
    });
});
</script>
