<link href="<?php echo base_url(); ?>include/assets/css/bootstrap-select.min.css" rel="stylesheet" />
<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }
  .treeview {
        float: left;
        width: 100%;
        background-color: #f5f5f5;
        padding: 15px 30px 30px;
    }

    .treeview ul {
        float: left;
        width: 100%;
        position: relative;
    }

    .treeview ul li {
        float: left;
        width: 100%;
        border-left: 1px solid #C6C6C6 !important;
        padding: 9px 0px;
        list-style-type: none;
    }

    .treeview ul li div {
        float: left;
        width: 100%;
        font-family: Arial;
        font-size: 15px;
        color: #444;
        line-height: 1.5;
        padding-left: 33px;
        position: relative;
        bottom: -20px;
    }

    .treeview ul li div:before {
        content: "";
        width: 30px;
        height: 1px;
        background-color: #C6C6C6 !important;
        position: absolute;
        top: 50%;
        bottom: 50%;
        left: 0;
    }

    .treeview ul li ul {
        margin: 20px 0;
    }

    .treeview ul li ul li {
        border-left-color: #aaa;
        margin-left: 50px;
        width: calc(100% - 50px);
    }

    .treeview ul li ul li div {
        color: #444;
        padding-left: 15px;
    }

    .treeview ul li ul li div:before {
        background-color: #aaa;
        width: 10px;
    }
</style>



    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="#">User</a></li>
                      <li class="breadcrumb-item active"> Manage User Location</li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                    <?php echo form_open('', array('id' => 'mapContributerForm', 'autocomplete' => 'off')); ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="<?php echo base_url(); ?>users/manage" class="btn btn-outline-dark-back text-dark"><span> <img src="<?php echo base_url(); ?>include/assets/images/collapse-arrow.svg"></span> Back</a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="label-text-1">Select User</label>
                                    <select class="form-control selectpicker" name="contributer" title="Search and select user" data-live-search="true">
                                        <?php if($user_id == '') { ?>
                                        <!-- <option value="" selected="true">....Select....</option> -->
                                        <?php } if(count($contributers) > 0) { ?>
                                        <optgroup label="Countributers">
                                            <?php foreach ($contributers as $key => $user) { ?>
                                            <option value="<?php echo $user['user_id']; ?>" <?php echo($user['user_id'] == $user_id ? "selected":"") ?> ><?php echo $user['username']; ?>(<?php echo $user['first_name'].' '.$user['last_name']; ?>)</option>
                                            <?php } ?>
                                        </optgroup>
                                        <?php } if(count($cluster_admins) > 0) { ?>
                                        <optgroup label="Cluster Admins">
                                            <?php foreach ($cluster_admins as $key => $user) { ?>
                                            <option value="<?php echo $user['user_id']; ?>" <?php echo($user['user_id'] == $user_id ? "selected":"") ?>><?php echo $user['username']; ?>(<?php echo $user['first_name'].' '.$user['last_name']; ?>)</option>
                                            <?php } ?>
                                        </optgroup>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="label-text-1">Location Details</label>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="label-text-1">Country</label>
                                    <select class="form-control" name="country">
                                        <option value="" selected="true">....Select....</option>
                                        <?php foreach ($countries as $key => $country) { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="d-block label-text-1">Location Type</label>
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
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="treeview">
                                </div>

                                <h6 class="error"></h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-submit text-white" type="submit">Update</button>
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
<script type="text/javascript">
  
$(function(){
    $('.selectpicker').selectpicker();
    
    let contributer = $('[name="contributer"]');
    if(contributer.val() != '') contributer.trigger('change');
});

// Define global variable ajaxData
var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

// Handle location type change
$('body').on('change', '[name="loc_type"]', function(event) {
    let elem = $(this),
    country = $('[name="country"]').val(),
    contributer = $('[name="contributer"]').val();
    
    $('.treeview').empty();
    $('#mapContributerForm').find('.error').empty();
    if(!elem.val() || elem.val().toString().length === 0 || !country || country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
        $('#mapContributerForm').find('.error').html('Please select both contributer and country and location type to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocation(elem, country, contributer);
});
// Handle contributer change
$('body').on('change', '[name="contributer"]', function(event) {
    let elem = $('[name="loc_type"]:checked'),
    country = $('[name="country"]').val(),
    contributer = $(this).val();
    
    $('.treeview').empty();
    $('#mapContributerForm').find('.error').empty();
    if(!elem.val() || elem.val().toString().length === 0 || !country || country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
        // $('#mapContributerForm').find('.error').html('Please select both contributer and country and location type to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocation(elem, country, contributer);

    // let contributer = $(this).val(),
    // country = $('[name="country"]').val();
    // $('.treeview').empty();
    // $('#mapContributerForm').find('.error').empty();

    // if(!country || country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
    //     $('#mapContributerForm').find('.error').html('Please select both contributer and country to get the location details.');
    // }

    // // Select cluster as default
    // $('[name="loc_type"][value="cluster"]').prop('checked', true);
    // $('[name="loc_type"]').trigger('change');

    // // Get contributer role details
    // ajaxData['contributer'] = contributer;
    // $('#mapContributerForm').find('button').prop('disabled', true);
    // $.ajax({
    //     url: '<?php echo base_url(); ?>users/get_user_role',
    //     type: 'POST',
    //     dataType : 'json',
    //     data: ajaxData,
    //     complete: function(data) {
    //         $('#mapContributerForm').find('button[type="submit"]').html('Update');
    //         var csrfData = JSON.parse(data.responseText);
    //         ajaxData[csrfData.csrfName] = csrfData.csrfHash;
    //         if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
    //             $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
    //         }
    //     },
    //     error: function() {
    //         $.toast({
    //             heading: 'Network Error!',
    //             text: 'Could not establish connection to server. Please refresh the page and try again.',
    //             icon: 'error',
    //             afterHidden: function () {
    //                 $('#mapContributerForm').find('button').prop('disabled', false);
    //             }
    //         });
    //     },
    //     success: function(response) {
    //         $('#mapContributerForm').find('button').prop('disabled', false);

    //         // If session error exists
    //         if(response.session_err == 1) {
    //             $.toast({
    //                 heading: 'Session Error!',
    //                 text: response.msg,
    //                 icon: 'error'
    //             });
    //             return false;
    //         }

    //         if(response.status == 0) {
    //             $.toast({
    //                 heading: 'Error!',
    //                 text: response.msg,
    //                 icon: 'error'
    //             });
    //             return false;
    //         }

    //         if(response.role == 6) {
    //             $('[name="loc_type"][value="uai"]').prop('disabled', true);
    //         } else {
    //             $('[name="loc_type"][value="uai"]').prop('disabled', false);
    //         }
    //     }
    // });
});
// Handle country change
$('body').on('change', '[name="country"]', function(event) {
    let elem = $('[name="loc_type"]:checked'),
    country = $(this).val(),
    contributer = $('[name="contributer"]').val();
    
    $('.treeview').empty();
    $('#mapContributerForm').find('.error').empty();
    if(!elem.val() || elem.val().toString().length === 0 || country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
        // $('#mapContributerForm').find('.error').html('Please select both contributer and country and location type to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocation(elem, country, contributer);
});
function getLocation(elem, country, contributer) {
    //send ajax request to get location details
    ajaxData['loc_type'] = elem.val();
    ajaxData['country'] = country;
    ajaxData['contributer'] = contributer;
    $('#mapContributerForm').find('button').prop('disabled', true);
    $('#mapContributerForm').find('button[type="submit"]').html('Please Wait... Getting Location Details');
    $.ajax({
        url: '<?php echo base_url(); ?>users/get_location_for_mapping',
        type: 'POST',
        dataType : 'json',
        data: ajaxData,
        complete: function(data) {
            $('#mapContributerForm').find('button[type="submit"]').html('Update');
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
                    $('#mapContributerForm').find('button').prop('disabled', false);
                }
            });
        },
        success: function(response) {
            $('#mapContributerForm').find('button').prop('disabled', false);

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

            let HTML = `<h4 class="error text-center">No location registered under this country.<h4>`;
            if(elem.val() == 'cluster') {
                if(response.clusters.length > 0) {
                    HTML = `<ul>`;
                    // Show all clustes
                    for (var i = 0; i < response.clusters.length; i++) {
                        let cluster = response.clusters[i];
                        let checked = response.assigned.clusters.includes(cluster.cluster_id) ? 'checked' : '';

                        HTML += `<li>
                            <div>
                                <span>
                                    <input type="checkbox" name="location[]" value="${cluster.cluster_id}" ${checked}>
                                    ${cluster.name}
                                </span>
                            </div>
                        </li>`;
                    }
                    HTML += `</ul>`;
                }
            } else if(elem.val() == 'uai') {
                if(response.uais.length > 0) {
                    HTML = `<ul>`;
                    // Show all uais
                    for (var uaiIndex = 0; uaiIndex < response.uais.length; uaiIndex++) {
                        let uai = response.uais[uaiIndex];
                        HTML += `<li>
                            <div>
                                ${uai.uai}
                            </div><ul>`;

                            // Show all sub locations
                            for (var slocIndex = 0; slocIndex < uai.sub_locs.length; slocIndex++) {
                                let sloc = uai.sub_locs[slocIndex];
                                let checked = response.assigned.sub_locs.includes(sloc.sub_loc_id) ? 'checked' : '';
                                
                                HTML += `<li>
                                    <div>
                                        <span>
                                            <input type="checkbox" name="location[]" value="${sloc.sub_loc_id}" ${checked}>
                                            ${sloc.location_name}
                                        </span>
                                    </div>
                                </li>`;
                            }

                        HTML += `</ul></li>`;
                    }
                    HTML += `</ul>`;
                }
            }
            $('.treeview').html(HTML);
        }
    });
}

//Handle form submit
$('body').on('submit', '#mapContributerForm', function(event) {
    event.preventDefault();
    $('.error').empty();
    $('#mapContributerForm').find('button').prop('disabled', true);

    formData = new FormData($(this)[0]);
    $.ajax({
        url: '<?php echo base_url(); ?>users/map_contributer_location',
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
            $('#mapContributerForm').find('button').prop('disabled', false);
            $.toast({
                heading: 'Network Error!',
                text: 'Could not establish connection to server. Please refresh the page and try again.',
                icon: 'error'
            });
        },
        success: function(data) {
            var data = JSON.parse(data);
            $('#mapContributerForm').find('button').prop('disabled', false);

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
                    icon: 'success'
                });
            } else if(data.status == 0) {
                $.toast({
                    heading: 'Error!',
                    text: data.msg,
                    icon: 'error'
                });
            }
        }
    });
});
</script>
