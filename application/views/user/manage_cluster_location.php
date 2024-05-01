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
                      <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
                      <li class="breadcrumb-item"><a href="#">Users</a></li>
                      <li class="breadcrumb-item active"> Manage Cluster Admin Location</li>
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
                                        <?php } if(count($cluster_admins) > 0) { ?>
                                        <optgroup label="Cluster Admins">
                                            <?php 
                                            foreach ($cluster_admins as $key => $user) { ?>
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
                                    <select class="form-control" id="country" name="country"  >
                                        <option value="" selected="true">....Select....</option>
                                        <!-- <?php if(!empty($locations)){
                                            $unique_country_id = array_unique(array_column($locations, 'country_id'));
                                            foreach ($countries as $key => $country) { 
                                                if(in_array($country['country_id'],$unique_country_id)){
                                                    ?>
                                                    <option value="<?php echo $country['country_id']; ?>" <?php echo(in_array($country['country_id'],$unique_country_id)?'selected' : ''); ?>><?php echo $country['name']; ?></option>
                                                    <?php 
                                                }
                                            } ?>
                                       <?php }else{ ?>
                                            <?php foreach ($countries as $key => $country) { ?>
                                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                            <?php } ?>
                                      <?php } ?> -->
                                        
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="d-block label-text-1">Location Type</label>
                                    <?php if(!empty($locations)){
                                            $unique_uai_id = array_unique(array_column($locations, 'uai_id'));
                                            $unique_cluster_id = array_unique(array_column($locations, 'cluster_id'));
                                         } ?>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" id="uai" class="form-check-input" name="loc_type" value="uai" <?php echo(count($unique_uai_id)> 0 ? 'checked': ''); ?> >UAI
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" id="cluster" class="form-check-input" name="loc_type" value="cluster" <?php echo(count($unique_cluster_id)> 0 ? 'checked': ''); ?>>Cluster
                                        </label>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="treeview" id="uai_treeview"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="treeview" id="cluster_treeview"></div>
                                    </div>
                                </div>
                                <!-- <h6 class="error"></h6> -->
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


// Handle contributer change
$('body').on('change', '[name="contributer"]', function(event) {
    contributer = $(this).val();
    $('.treeview').empty();
    $('#mapContributerForm').find('.error').empty();
    getLocationByUser(contributer);
    
});
// Handle country change
$('body').on('change', '[name="country"]', function(event) {
    country = $(this).val();
    contributer = $('[name="contributer"]').val();
    
    $('.treeview').empty();
    $('#mapContributerForm').find('.error').empty();
    if(country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
        // $('#mapContributerForm').find('.error').html('Please select both contributer and country and location type to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocation(country, contributer);
});
function getLocation(country, contributer) {
    //send ajax request to get location details
    // ajaxData['loc_type'] = elem.val();
    ajaxData['country'] = country;
    ajaxData['contributer'] = contributer;
    $('#mapContributerForm').find('button').prop('disabled', true);
    $('#mapContributerForm').find('button[type="submit"]').html('Please Wait... Getting Location Details');
    $.ajax({
        url: '<?php echo base_url(); ?>users/get_location_for_cluster',
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

            // let HTML = `<h4 class="error text-center">No location registered under this country.<h4>`;
            let clusterHTML = `<h4 class="text-center">Cluster<h4>`;
            let uaiHTML = `<h4 class="text-center">UAI<h4>`;
            // if(elem.val() == 'cluster') {
                if(response.clusters.length > 0) {
                    clusterHTML += `<ul>`;
                    // Show all clustes
                    for (var i = 0; i < response.clusters.length; i++) {
                        let cluster = response.clusters[i];
                        let checked = response.assigned.clusters.includes(cluster.cluster_id) ? 'checked' : '';

                        clusterHTML += `<li>
                            <div>
                                <span>
                                    <input type="checkbox" name="cluster_location[]" value="${cluster.cluster_id}" ${checked}>
                                    ${cluster.name}
                                </span>
                            </div>
                        </li>`;
                    }
                    clusterHTML += `</ul>`;
                }
            // } else if(elem.val() == 'uai') {
                if(response.uais.length > 0) {
                    uaiHTML += `<ul>`;
                    // Show all uais
                    for (var uaiIndex = 0; uaiIndex < response.uais.length; uaiIndex++) {
                        let uai = response.uais[uaiIndex];
                        uaiHTML += `<li>
                            <div>
                                ${uai.uai}
                            </div><ul>`;

                            // Show all sub locations
                            for (var slocIndex = 0; slocIndex < uai.sub_locs.length; slocIndex++) {
                                let sloc = uai.sub_locs[slocIndex];
                                let checked = response.assigned.sub_locs.includes(sloc.sub_loc_id) ? 'checked' : '';
                                
                                uaiHTML += `<li>
                                    <div>
                                        <span>
                                            <input type="checkbox" name="uai_location[]" value="${sloc.sub_loc_id}" ${checked}>
                                            ${sloc.location_name}
                                        </span>
                                    </div>
                                </li>`;
                            }

                            uaiHTML += `</ul></li>`;
                    }
                    uaiHTML += `</ul>`;
                }
            // }
            $('#uai_treeview').html(uaiHTML);
            $('#cluster_treeview').html(clusterHTML);
        }
    });
}
function getLocationByUser(contributer) {
    //send ajax request to get location details
    ajaxData['user_id'] = contributer;
    $('#mapContributerForm').find('button').prop('disabled', true);
    $('#mapContributerForm').find('button[type="submit"]').html('Please Wait... Getting Location Details');
    $.ajax({
        url: '<?php echo base_url(); ?>users/get_location_by_user',
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
            let userCountries = response.country
            let userUais = response.uais
            let userClusters = response.clusters
            let countries = response.countries
            // let disablevalue ="";
            // if(userCountries[0]?.length > 0){
            //     document.getElementById("country").disabled = true;
            // }
            let Html = `<option value="">select country</option>`;
            if(userCountries[0]?.length > 0){
                for (let i = 0; i < countries.length; i++) {
                    const country = countries[i];
                    if(userCountries.includes(country['country_id'])){
                        Html += `<option value="${country['country_id']}"  ${userCountries.includes(country['country_id']) ? 'selected' : ''}>${country['name']}</option>`;
                    }
                }
                
            }else{
                for (let i = 0; i < countries.length; i++) {
                    const country = countries[i];
                    Html += `<option value="${country['country_id']}">${country['name']}</option>`;
                    
                }
            }
            $('#country').html(Html); 
            $('#country').trigger('change');
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
        url: '<?php echo base_url(); ?>users/map_cluster_location',
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
                    icon: 'success',
                    afterHidden: function () {
                        window.location.reload();
                    }
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
