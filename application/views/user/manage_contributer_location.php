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
                      <li class="breadcrumb-item"><a href="#">Users</a></li>
                      <li class="breadcrumb-item active"> Manage Contributer Location</li>
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
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="label-text-1">Location Details</label>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Country</label>
                                    <select class="form-control" id="country" name="country">
                                        <option value="" selected="true">....Select....</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Location Type</label>
                                    <select class="form-control" id="loc_type" name="loc_type">
                                        <option value="">....Select....</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div id="uai_locations" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label-text-1">UAI</label>
                                                <select class="form-control" id="uai" name="uai">
                                                    <option value="" selected="true">....Select....</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label-text-1">Sub Location</label>
                                                <select class="form-control" id="sub_loc" name="sub_loc">
                                                    <option value="" selected="true">....Select....</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="cluster_locations" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label-text-1">Cluster</label>
                                                <select class="form-control" id="cluster" name="cluster">
                                                    <option value="" selected="true">....Select....</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
    let elem = $(this);
    let loc_type = $('[name="loc_type"]').val();
    let country = $('[name="country"]').val();
    // contributer = $('[name="contributer"]').val();
    $('#mapContributerForm').find('.error').empty();
    if(!elem.val() || elem.val().toString().length === 0 || !country || country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
        $('#mapContributerForm').find('.error').html('Please select both contributer and country and location type to get the location details.');
        return false;
    }

    // Call fn to get location data
    getLocationByCountry(loc_type, country);
});
// Handle contributer change
$('body').on('change', '[name="contributer"]', function(event) {
    contributer = $(this).val();
    $('#mapContributerForm').find('.error').empty();
    getLocationByUser(contributer);
    
});
// Handle country change
$('body').on('change', '[name="country"]', function(event) {    
    let loc_type = $('[name="loc_type"]').val(),
    country = $(this).val(),
    contributer = $('[name="contributer"]').val();
    
    $('.treeview').empty();
    $('#mapContributerForm').find('.error').empty();
    if(!loc_type || loc_type.toString().length === 0 || country.toString().length === 0 || !contributer || contributer.toString().length === 0) {
        return false;
    }else{

        if($('#yourID').css('display') == 'none'){
            
            // Call fn to get location data
            getLocation(loc_type, country, contributer);
        }else{
            $('#uai_locations').css('display','none');
            $('#cluster_locations').css('display','none');
            let locHtml = `<option value="" selected >select Location Type</option>`;
            locHtml += `<option value="uai" >UAI</option>`;
            locHtml += `<option value="cluster">Cluster</option>`;
            let uaiHtml = `<option value="">select UAI</option>`;
            let subLocHtml = `<option value="">select Sub Location</option>`;
            let clusterHtml = `<option value="">select Cluster</option>`;
            $('#uai').html(uaiHtml);
            $('#sub_loc').html(subLocHtml);
            $('#cluster').html(clusterHtml);
            $('#loc_type').html(locHtml);
        }
        
    }
    

    

    $('#sub_loc').html('<option value="">Select Sub Location</option>');
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
                    HTML += `<div class="row"><div class="col-md-6">`;
                    HTML += `<select name="cluster_id" class="form-control" id="cluster_id">`;
                    // Show all clustes
                    for (var i = 0; i < response.clusters.length; i++) {
                        let cluster = response.clusters[i];
                        let checked = response.assigned.clusters.includes(cluster.cluster_id) ? 'selected' : '';

                        HTML += `<option value="${cluster.cluster_id}" ${checked}>${cluster.name}</option>`;
                    }
                    HTML += `</select>`;
                    HTML += `</div></div>`;
                }
            } else if(elem.val() == 'uai') {
                if(response.uais.length > 0) {
                    HTML += `<div class="row"><div class="col-md-6">`;
                    HTML += `<select name="uai_id" class="form-control" id="uai_id">`;
                    // Show all clustes
                    for (var i = 0; i < response.uais.length; i++) {
                        let uai = response.uais[i];
                        let checked = response.assigned.sub_locs.includes(uai.sub_locs['sub_loc_id']) ? 'selected' : '';

                        HTML += `<option value="${uai.uai_id}" ${checked}>${uai.uai}</option>`;
                    }
                    HTML += `</select>`;
                    HTML += `</div>`;

                    HTML += `<div class="col-md-6">`;
                    HTML += `<select name="sub_loc_id" class="form-control" id="sub_loc_id">`;
                    // Show all sub locations
                    for (var uaiIndex = 0; uaiIndex < response.uais.length; uaiIndex++) {
                        let uai = response.uais[uaiIndex];
                        for (var slocIndex = 0; slocIndex < uai.sub_locs.length; slocIndex++) {
                                let sloc = uai.sub_locs[slocIndex];
                                let checked = response.assigned.sub_locs.includes(sloc.sub_loc_id) ? 'selected' : '';

                            HTML += `<option value="${sloc.sub_loc_id}" ${checked}>${sloc.location_name}</option>`;
                        }
                    }
                    HTML += `</select>`;
                    HTML += `</div></div>`;

                }
            }
            $('.treeview').html(HTML);
        }
    });
}
function getLocationByUser(contributer) {
    //send ajax request to get location details
    $('#uai_locations').css('display','none');
    $('#cluster_locations').css('display','none');
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
            let sub_locs = response.sub_locs
            let userClusters = response.clusters
            let countries = response.countries
            let uai_list = response.uai_list
            let sub_loc_list = response.sub_loc_list
            let cluster_list = response.cluster_list
            if(userCountries[0]?.length > 0){
                // document.getElementById("country").disabled = true;
                // document.getElementById("loc_type").disabled = true;
            }
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
            let locHtml = `<option value="">select Location Type</option>`;
            let uaiHtml = `<option value="">select UAI</option>`;
            let subLocHtml = `<option value="">select Sub Location</option>`;
            let clusterHtml = `<option value="">select Cluster</option>`;
            if(userUais[0]?.length > 0 || userClusters[0]?.length > 0){
                if(userUais[0]?.length > 0){
                    locHtml += `<option value="uai" selected>UAI</option>`;
                    locHtml += `<option value="cluster">Cluster</option>`;
                    $('#uai_locations').css('display','block');
                    $('#cluster_locations').css('display','none');
                    for (let i = 0; i < uai_list.length; i++) {
                        const uai = uai_list[i];
                        uaiHtml += `<option value="${uai['uai_id']}"  ${userUais.includes(uai['uai_id']) ? 'selected' : ''}>${uai['uai']}</option>`;
                    }
                    for (let j = 0; j < sub_loc_list.length; j++) {
                        const sub_loc = sub_loc_list[j];
                        if(userUais.includes(sub_loc['uai_id'])){
                            subLocHtml += `<option value="${sub_loc['sub_loc_id']}"  ${sub_locs.includes(sub_loc['sub_loc_id']) ? 'selected' : ''}>${sub_loc['location_name']}</option>`;
                        }
                        
                    }
                    
                }
                if(userClusters[0]?.length > 0){
                    locHtml += `<option value="uai">UAI</option>`;
                    locHtml += `<option value="cluster"  selected>Cluster</option>`;
                    $('#uai_locations').css('display','none');
                    $('#cluster_locations').css('display','block');
                    for (let i = 0; i < cluster_list.length; i++) {
                        const cluster = cluster_list[i];
                        clusterHtml += `<option value="${cluster['cluster_id']}"  ${userClusters.includes(cluster['cluster_id']) ? 'selected' : ''}>${cluster['name']}</option>`;
                        
                    }
                }
                $('#uai').html(uaiHtml);
                $('#sub_loc').html(subLocHtml);
                $('#cluster').html(clusterHtml);

            }else{
                locHtml += `<option value="uai">UAI</option>`;
                locHtml += `<option value="cluster">Cluster</option>`;
            }
            $('#loc_type').html(locHtml);
            
            
            
        }
    });
}
function getLocationByCountry(loc_type, country) {
    //send ajax request to get location details
    $('#uai_locations').css('display','none');
    $('#cluster_locations').css('display','none');
    ajaxData['country'] = country;
    // ajaxData['loc_type'] = loc_type;
    $('#mapContributerForm').find('button').prop('disabled', true);
    $('#mapContributerForm').find('button[type="submit"]').html('Please Wait... Getting Location Details');
    $.ajax({
        url: '<?php echo base_url(); ?>users/get_location_by_country',
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
            let uai_list = response.uais;
            let sub_loc_list = response.slocs;
            let cluster_list = response.clusters;
            let uaiHtml = `<option value="">select UAI</option>`;
            let subLocHtml = `<option value="">select Sub Location</option>`;
            let clusterHtml = `<option value="">select Cluster</option>`;
            if(loc_type == "uai"){
                if(uai_list?.length > 0){
                    $('#uai_locations').css('display','block');
                    $('#cluster_locations').css('display','none');
                    for (let i = 0; i < uai_list.length; i++) {
                        const uai = uai_list[i];
                        uaiHtml += `<option value="${uai['uai_id']}">${uai['uai']}</option>`;
                        
                    }
                    // for (let i = 0; i < sub_loc_list.length; i++) {
                    //     const sub_loc = sub_loc_list[i];
                    //     subLocHtml += `<option value="${sub_loc['sub_loc_id']}">${sub_loc['location_name']}</option>`;
                        
                    // }
                }
                
                $('#uai').html(uaiHtml);
                $('#sub_loc').html(subLocHtml);
                

            }else{
                if(cluster_list?.length > 0){
                    $('#uai_locations').css('display','none');
                    $('#cluster_locations').css('display','block');
                    for (let i = 0; i < cluster_list.length; i++) {
                        const cluster = cluster_list[i];
                        clusterHtml += `<option value="${cluster['cluster_id']}">${cluster['name']}</option>`;
                        
                    }
                }
                $('#cluster').html(clusterHtml);
            }
           
        }
    });
}

$('#uai').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
            $.ajax('<?=base_url()?>users/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_loc').html(data);
                }
            });  
        } 
		else{
            $('#sub_loc').html('<option value="">Select Sub Location</option>');
        }   
    });

//Handle form submit
$('body').on('submit', '#mapContributerForm', function(event) {
    event.preventDefault();
    let loc_type = $('[name="loc_type"]').val();
    let country = $('[name="country"]').val();
    if(  !country || country.toString().length === 0){
        $('#mapContributerForm').find('.error').html('Please select country  update the location details.');
                
    } else if(!loc_type || loc_type.toString().length === 0 ){
        $('#mapContributerForm').find('.error').html('Please select  location type to update the location details.');
    } else{

        if(loc_type == "cluster"){
            let cluster = $('[name="cluster"]').val();
            if(  !cluster || cluster.toString().length === 0 ){
                $('#mapContributerForm').find('.error').html('Please select Cluster to update the location details.');
                return false;
            }
        } else if (loc_type == "uai"){
            let sub_loc = $('[name="sub_loc"]').val();
            let uai = $('[name="uai"]').val();
            if(  !sub_loc || sub_loc.toString().length === 0 || !uai || uai.toString().length === 0 ){
                $('#mapContributerForm').find('.error').html('Please select both uai and sub location to update the location details.');
                return false;
            }
        }
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

        
            
       
        
    }
    
});
</script>
