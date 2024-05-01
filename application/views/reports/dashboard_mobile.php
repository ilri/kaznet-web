<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="<?php echo base_url(); ?>include/assets/images/faavicon.webp" sizes="32x32">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/jquery.toast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/sweetalert.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/style.css">
    
        <script src="<?php echo base_url(); ?>include/assets/js/jquery.slim.min.js"></script>
        <script src="<?php echo base_url(); ?>include/js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/jquery.toast.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/sweetalert.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/dataTables.bootstrap4.min.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script> -->
    <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>
      <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <style>
        .nav-tabs.dashboard-nav .nav-item.show .nav-link,
        .nav-tabs.dashboard-nav .nav-link.active {
            color: #495057;
            background-color: transparent !important;
            border-color: #84837E #84837E #84837E !important;
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 500;
            font-size: 18px;
            line-height: 25px;
            padding: 10px 30px !important;
            color: #6d1024 !important;
        }

        .nav-tabs.dashboard-nav .nav-link {
            margin-bottom: -1px;
            background: transparent;
            font-family: 'Poppins';
            font-style: normal;
            padding: 10px 30px !important;
            font-weight: 400;
            font-size: 16px !important;
            line-height: 24px;
            color: #6d10248c !important;
            border: 1px solid transparent;
            border-top-left-radius: 5px !important;
            border-top-right-radius: 5px !important;
        }

        .chart-title {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 25px;
            color: #000000;
        }

        .card-shadow {
            background: #FFFFFF;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .h-386px {
            height: 386px;
            min-height: 386px;
        }

        .map_height {
            width: 100%;
            height: 300px;
        }

        .primary-vl {
            border-left: 4px solid #5877A3;
            height: 30px;
        }

        .primary-v2 {
            border-left: 4px solid #E49443;
            height: 30px;
        }

        .primary-v3 {
            border-left: 4px solid #6A9F58;
            height: 30px;
        }

        .primary-v4 {
            border-left: 4px solid #F1A2A7;
            height: 30px;
        }

        .primary-v5 {
            border-left: 4px solid #6FA1E7;
            height: 30px;
        }

        .primary-v6 {
            border-left: 4px solid #FFB6BA;
            height: 30px;
        }

        .primary-v7 {
            border-left: 4px solid #C8E76F;
            height: 30px;
        }

        .primary-v8 {
            border-left: 4px solid #CDCDCD;
            height: 30px;
        }

        .primary-v9 {
            border-left: 4px solid #F7BA1E;
            height: 30px;
        }

        .primary-v10 {
            border-left: 4px solid #14C9C9;
            height: 30px;
        }

        .primary-v11 {
            border-left: 4px solid #FFB6BA;
            height: 30px;
        }

        .w-100px {
            width: 100px;
        }

        .chart-legend-title {
            width: 100px !important;
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 22px;
            align-items: center;
            color: #4E5969;
        }

        .large-bold {
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 28px;
            color: #1D2129;
        }
        #new_map_kml {
            height: 540px;
            width: 100%;
        }
        .leaflet-popup-content {
            margin: 13px 19px;
            line-height: 1.4;
            width: auto !important;
            white-space: nowrap;
        }
        .highcharts-tooltip span {
            height:auto !important;
            width:140px !important;
            max-width:200px !important;
            overflow:auto !important;
            white-space:normal !important; 
        }
    </style>
    <div class="container-fluid">
        <!-- <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div> -->

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs dashboard-nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab"
                                            href="#dashboardUsers">Market</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="tab_2"
                                            href="#dashboardHousehold">Markets</a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="tab_3"
                                            href="#dashboardMarket">Market</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="tab_4" 
                                            href="#dashboardRangeland">Rangeland</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_5" data-toggle="tab"
                                            href="#taskPayment">Task & Payment</a>
                                    </li> -->
                                </ul>
                                <!-- Tab panes -->
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="tab-content mt-4">
                                    <div class="tab-pane active" id="dashboardUsers">
                                        <!-- Map start -->
                                        <div class="row">
                                            <div class="col-sm-12 col-md-10 col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Country<span class="text-danger"> *</span></label>
                                                            <select class="form-control" id="country_id" name="country_id">
                                                                <option value="">Select Country</option>
                                                                <?php 
                                                                foreach($lkp_country as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['country_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Market<span class="text-danger"> *</span></label>
                                                            <select class="form-control selectpicker" id="market_id" name="market_id" multiple>
                                                                <option value="">Select Market</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Timeline</label>
                                                            <select class="form-control" id="timeline_id" name="timeline_id">
                                                                <option value="">Select Timeline</option>
                                                                <?php
                                                                    // Get the current month and year
                                                                    $currentMonth = date('m');
                                                                    $currentYear = date('Y');

                                                                    // Loop to generate options for the latest six months
                                                                    for ($i = 0; $i < 6; $i++) {
                                                                        $monthText = date('F Y', mktime(0, 0, 0, $currentMonth - $i, 1, $currentYear));
                                                                        $monthValue = date('Y-m', mktime(0, 0, 0, $currentMonth - $i, 1, $currentYear));
                                                                        echo "<option value='$monthValue'>$monthText</option>";
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                                                <!-- <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button> -->
                                                <button class="btn btn-submit-active text-white get_data" id="get_data_t1" disabled style="background-color:gray">Submit</button>
                                            </div>
                                        </div>
                                        
                                        <!-- Map End -->
                                        <div class="div_survey_deatils_view"><b>Please select Country and Market filters</div>
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script>
    $(function(){
        // getSurveyDeatilsViewT1();
        // $( '.selectpicker' ).multiselect();

        loginrole = 1;
	});
    // $( document ).ready(function() {
    //     $('.get_data').trigger('click');
    // });
    $('body').on('click', '#get_data_t1', function(){
        		getSurveyDeatilsViewT1();
	});
    
    $('body').on('click', '#tab_2', function(){
        		getSurveyDeatilsViewT2();
	});
    $('.reset').on('click', function(){
		location.reload();
	});

	 $('#country_id').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            // $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
            //     type: 'POST',  // http method
            //     data: { country_id: country_id },  // data to submit
            //     success: function (data) {
            //         $('#cluster_id').html(data);
            //     }
            // });

			// $.ajax('<?=base_url()?>reports/getUaiByCountry', {
            //     type: 'POST',  // http method
            //     data: { country_id: country_id },  // data to submit
            //     success: function (data) {
            //         $('#uai_id').html(data);
            //     }
            // });
            $.ajax('<?=base_url()?>reports/getMarketsByUaiCountry1', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#market_id').html(data);
                    $( '.selectpicker' ).multiselect( 'refresh' );
                }
            });
            // if(loginrole==1){
                // $('.get_data').css("background-color","rgb(111, 27, 40)");
			    // $('.get_data').prop("disabled",false);
            // }
        }else{
			$('.get_data').css("background-color","rgb(147, 148, 150)");
			$('.get_data').prop("disabled",true);
            $('#cluster_id').html('<option value="">Select Cluster</option>');
            $('#uai_id').html('<option value="">Select UAI</option>');
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
            
        }   
     });
     $('#market_id').on('change', function(){
        var market_id=$(this).val();
        
        var country_id=$('select[name="country_id"]').val();
        if(market_id != '' && country_id != '')
        {
            if(market_id.length>3){
                alert("Max Markets you can select is only 3");
                $('#market_id').val("");
                $('.get_data').css("background-color","rgb(147, 148, 150)");
                $('.get_data').prop("disabled",true);
            }else{
                $('.get_data').css("background-color","rgb(111, 27, 40)");
                $('.get_data').prop("disabled",false);
            }
        }else{
            
                $('.get_data').css("background-color","rgb(147, 148, 150)");
                $('.get_data').prop("disabled",true);
           
        }
     });
	 $('#cluster_id').on('change', function(){
        var cluster_id=$(this).val();
        if(cluster_id != '')
        {
			$('.get_data').css("background-color","rgb(111, 27, 40)");
			$('.get_data').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getContributerByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    $('#contributor_id').html(data);
					$('#uai_id').html('<option value="">Select UAI</option>');
					$('#sub_location_id').html('<option value="">Select Sub Location</option>');
                }
            });
			if(survey_type=="Market Task"){
				$.ajax('<?=base_url()?>reports/getMarketsByCluster', {
					type: 'POST',  // http method
					data: { cluster_id: cluster_id },  // data to submit
					success: function (data) {
						$('#market_id').html(data);
					}
				});
			}
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data').css("background-color","rgb(147, 148, 150)");
			    $('.get_data').prop("disabled",true);
            }
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
            $('#market_id').html('<option value="">Select Market</option>');
        }   
     });

	$('#uai_id').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
			$('.get_data').css("background-color","rgb(111, 27, 40)");
			$('.get_data').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_location_id').html(data);
                }
            });
			if(survey_type=="Market Task"){
				$.ajax('<?=base_url()?>reports/getMarketsByUai', {
					type: 'POST',  // http method
					data: { uai_id: uai_id },  // data to submit
					success: function (data) {
						$('#market_id').html(data);
                        $('#cluster_id').html('<option value="">Select Cluster</option>');
					}
				});
			}
            
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data').css("background-color","rgb(147, 148, 150)");
			    $('.get_data').prop("disabled",true);
            }
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });
	$('#sub_location_id').on('change', function(){
        var sub_location_id=$(this).val();
        if(sub_location_id != '')
        {
            $.ajax('<?=base_url()?>reports/getContributorBySubLocation', {
                type: 'POST',  // http method
                data: { sub_location_id: sub_location_id },  // data to submit
                success: function (data) {
                    $('#contributor_id').html(data);
					$('#cluster_id').html('<option value="">Select Cluster</option>');
                }
            });
        } 
		else{
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });
	$('#contributor_id').on('change', function(){
        var contributor_id=$(this).val();
		var page_id=0;
        if(contributor_id != '')
        {
            $.ajax('<?=base_url()?>reports/getRespondentByContributor', {
                type: 'POST',  // http method
                data: { contributor_id: contributor_id, page_id: page_id },  // data to submit
                success: function (data) {
                    $('#respondent_id').html(data);
                }
            });
        } 
		else{
            // $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });

    

        /*  Sagar wrote code for loading dashboards from here*/

        function getSurveyDeatilsViewT1(){
            // alert("called");
            // showLoader();
            var country_id=$('select[name="country_id"]').val();
            var timeline_id=$('select[name="timeline_id"]').val();
            var sub_location_id=$('select[name="sub_location_id"]').val();
            var cluster_id=$('select[name="cluster_id"]').val();
            var start_date=$('input[name="start_date"]').val();
            var end_date=$('input[name="end_date"]').val();
            
            var selectElement = document.getElementById("market_id");
    
            // Initialize an empty array to store the selected values
            var selectedValues = [];
            
            // Loop through the options and check if each is selected
            for (var i = 0; i < selectElement.options.length; i++) {
                var option = selectElement.options[i];
                if (option.selected) {
                    selectedValues.push(option.value); // Add selected value to the array
                }
            }
            // var selectedValuesString = "";
            // for (var i = 0; i < selectElement.options.length; i++) {
            //     var option = selectElement.options[i];
            //     if (option.selected) {
            //         if (selectedValuesString !== "") {
            //             selectedValuesString += ", "; // Add a comma and space if not the first value
            //         }
            //         selectedValuesString += option.value; // Add selected value to the string
            //     }
            // }
            var query_data = {
                // filter_survey: filter,
                country_id : country_id,
                timeline_id : timeline_id,
                sub_location_id : sub_location_id,
                cluster_id : cluster_id,
                market_id : selectedValues,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date

            };
                $('.div_survey_deatils_view').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_users_1_mobile/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){	            	
                        // $('#beneficiary_data').find('.loading').remove();
                        // $.toast({
                        // 	heading: 'Network Error!',
                        // 	text: 'Could not establish connection to server. Please refresh the page and try again.',
                        // 	icon: 'error'
                        // });
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `
                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <!-- Contributor Graphs start -->
                                    <h4>Number of Animals Sold </h4>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Camel</h4>
                                                        <div class="map_height" id="camel_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cattle</h4>
                                                        <div class="map_height" id="cattle_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Goats</h4>
                                                        <div class="map_height" id="goats_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sheep</h4>
                                                        <div class="map_height" id="sheep_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </br><h4>Selling Price</h4>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Camel</h4>
                                                        <div class="map_height" id="camel_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cattle</h4>
                                                        <div class="map_height" id="cattle_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Goats</h4>
                                                        <div class="map_height" id="goats_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sheep</h4>
                                                        <div class="map_height" id="sheep_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <br/><h4>Body Condition of Animals Traded</h4>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Camel</h4>
                                                        <div class="map_height" id="camel_animal_trade"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cattle</h4>
                                                        <div class="map_height" id="cattle_animal_trade"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Goats</h4>
                                                        <div class="map_height" id="goats_animal_trade"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sheep</h4>
                                                        <div class="map_height" id="sheep_animal_trade"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </br><h4>Prices of Index Commodities</h4>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Camel Milk (Liter)</h4>
                                                        <div class="map_height" id="camel_index_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cattle Milk (Liter)</h4>
                                                        <div class="map_height" id="cattle_index_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Maize (KG)</h4>
                                                        <div class="map_height" id="maize_index_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sugar (KG)</h4>
                                                        <div class="map_height" id="sugar_index_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Rice (KG)</h4>
                                                        <div class="map_height" id="rice_index_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>                            
                                `;
                            $('.div_survey_deatils_view').html(HTML_GENERAL);
                            monthsimple_grouped_barchart('camel_volumes', response.fielddata_camel_volumes, response.market_name_list, 'Number');
                            monthsimple_grouped_barchart('cattle_volumes', response.fielddata_cattle_volumes, response.market_name_list, 'Number');
                            monthsimple_grouped_barchart('goats_volumes', response.fielddata_goats_volumes, response.market_name_list, 'Number');
                            monthsimple_grouped_barchart('sheep_volumes', response.fielddata_sheep_volumes, response.market_name_list, 'Number');
                            line_graph('camel_selling_price', response.fielddata_camel_selling_price, response.market_name_list, 'in Local Currency');
                            line_graph('cattle_selling_price', response.fielddata_cattle_selling_price, response.market_name_list, 'in Local Currency');
                            line_graph('goats_selling_price', response.fielddata_goats_selling_price, response.market_name_list, 'in Local Currency');
                            line_graph('sheep_selling_price', response.fielddata_sheep_selling_price, response.market_name_list, 'in Local Currency');
                            line_graph('camel_index_price', response.fielddata_camel_index_price, response.market_name_list, 'in Local Currency');
                            line_graph('cattle_index_price', response.fielddata_cattle_index_price, response.market_name_list, 'in Local Currency');
                            line_graph('maize_index_price', response.fielddata_maize_index_price, response.market_name_list, 'in Local Currency');
                            line_graph('sugar_index_price', response.fielddata_sugar_index_price, response.market_name_list, 'in Local Currency');
                            line_graph('rice_index_price', response.fielddata_rice_index_price, response.market_name_list, 'in Local Currency');
                            monthsimple_grouped_barchart('camel_animal_trade', response.fielddata_camel_animal_trade, response.body_conditions, 'Number');
                            monthsimple_grouped_barchart('cattle_animal_trade', response.fielddata_cattle_animal_trade, response.body_conditions, 'Number');
                            monthsimple_grouped_barchart('goats_animal_trade', response.fielddata_goats_animal_trade, response.body_conditions1, 'Number');
                            monthsimple_grouped_barchart('sheep_animal_trade', response.fielddata_sheep_animal_trade, response.body_conditions1, 'Number');
                           
                        }
                    }
                }).always(function(response) {
                // setTimeout(() => hideLoader(), 1000);
            });
        }

        function line_graph(divid, data, categoriesdata, yaxis_units){
             // Check if all values in the array are zeros
             const isAllZeros = data.every(code => code.data.every(value => value === 0));
            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                
                data = groupByName(data);
                
                Highcharts.chart(divid, {

                    // title: {
                    //     text: 'camel',
                    //     align: 'left'
                    // },
                    title: {
                        text: null // Set the title to null or an empty string to hide it
                    },
                    credits: {
                    enabled: false
                    },
                    yAxis: {
                        title: {
                            text: 'in Local Currency'
                        }
                    },

                    xAxis: {
                        categories: categoriesdata,
                        // categories: ['week1','week2','week3','week4'],
                        accessibility: {
                            description: 'Months of the year'
                        }
                    },

                    // legend: {
                    //     layout: 'vertical',
                    //     align: 'right',
                    //     verticalAlign: 'middle'
                    // },

                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                            // pointStart: 2010
                        }
                    },
                    series: data,
                    // series: [{
                    //     name: 'Market1',
                    //     data: [43934, 48656, 65165, 81827, ]
                    // }, {
                    //     name: 'Market2',
                    //     data: [24916, 37941, 29742, 29851, ]
                    // }, {
                    //     name: 'Market3',
                    //     data: [30916, 97041, 89722, 29851, ]
                    // }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                // legend: {
                                //     layout: 'horizontal',
                                //     align: 'center',
                                //     verticalAlign: 'bottom'
                                // }
                            }
                        }]
                    }

                });
            }

        }

        function monthsimple_grouped_barchart(divid, data, categories, yaxis_units){
            
            var ftype= '';
            if(divid =='average_liters_milk_per_day' ||divid =='average_Selling_Price' ){
                ftype= '{point.y:.1f}';
            }else{
                ftype= '{point.y}';
            }
             // Assuming your graph data is stored in an array called 'data'
            // Check if all values in the array are zeros
            const isAllZeros = data.every(code => code.data.every(value => value === 0));

            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                data = groupByName(data);
                // Create your Highcharts chart with the actual data
                Highcharts.chart(divid, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        // categories: [
                        //     'Camel',
                        //     'Goat',
                        //     'Sheep',               
                        //     'Cattle',  
                        // ],
                        categories: categories,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: yaxis_units
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                            }
                        }
                    },
                    series: data
                    // series: [{
                    //     name: 'Deaths occurred in your mature herded',
                    //     color: '#165DFF',
                    //     data: [49.9, 71.5, 106.4, 83.6]

                    // }, {
                    //     name: 'Deaths occurred in your young herded',
                    //     color: '#F7BA1E',
                    //     data: [83.6, 78.8, 98.5, 49.9]

                    // }]
                });
            }
        }

        function monthsimple_piechart(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name} : </b> <b>{point.percentage:.1f}%</b>'
                        },
                        showInLegend: false
                    }
                },
                // plotOptions: {
                //     series: {
                //         borderWidth: 0,
                //         dataLabels: {
                //             enabled: true,
                //             color: '#000',
                //             format: '{point.y:.1f}', 
                //             y: -5, 
                        
                //         }
                //     }
                // },
                // legend: {
                //     enabled: true,
                //     // layout: 'vertical',
                //     // align: 'right',
                //     // width: 200,
                //     // verticalAlign: 'middle',
                //     // useHTML: true,
                //     // labelFormatter: function() {
                //     //     return '<div style="text-align: left; width:130px;float:left;">' + this.name + '</div><div style="width:40px; float:left;text-align:right;">' + this.y + '%</div>';
                //     // }
                //     labelFormatter: function() {
                //         return this.name + " (" + (this.y/total*100).toFixed(2) + "%)";
                //     }
                // },
                series: [{
                    name: yaxis_units,
                    data: data
                    // data: [{
                    //     name: 'Male',
                    //     color: '#6FA1E7',
                    //     y: 30,
                    // }, {
                    //     name: 'Female',
                    //     color: '#FFB6BA',
                    //     y: 20,
                    // }]
                }]
            });
        }

        function monthsimple_barchart(divid, data, yaxis_units){
            // Assuming your graph data is stored in an array called 'data'
            // Check if all values in the array are zeros
            const isAllZeros = data.every(code => code.y === 0);

            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                // Create your Highcharts chart with the actual data
                Highcharts.chart(divid, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        align: 'left',
                        text: ''
                    },
                    subtitle: {
                        align: 'left',
                        text: ''
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: yaxis_units
                        }

                    },
                    // legend: {
                    //     enabled: true
                    // },
                    exporting: {
                        enabled: true
                    },
                    credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            showInLegend: false,
                            dataLabels: {
                                enabled: true,
                                color: '#000',
                                format: '{point.y}', 
                                y: -5, 
                            
                            }
                        }
                    },
                    // plotOptions: {
                    //     column: {
                    //         stacking: 'normal',
                    //         pointPadding: 0,
                    //         groupPadding: 0,
                    //         dataLabels: {
                    //             enabled: false
                    //         }
                    //     }
                    // },
                    // point: {
                    //     events: {
                    //         mouseOut: function () {
                    //             this.series.chart.pointer.prevKDPoint = null;
                    //         }
                    //     }
                    // },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },
                    series: [
                        { 
                            name: yaxis_units,
                            colorByPoint: true,
                            // data: data
                            // data: data.filter(b => b.y != 0).map(a=>a.y)
                            data: data.filter(d => d.y != 0)
                            
                        }
                    ],
                });
            }
        }

        function groupByName(data) {
            // alert ("called");
            const namesData = new Map();

            data.forEach((item) => {
                const name = item.name;
                const data = item.data;

                if (!namesData.has(name)) {
                namesData.set(name, { name, data: [] });
                }

                namesData.get(name).data.push(data);
            });

            const result = [...namesData.values()].map((entry) => {
                const { name, data } = entry;

                if (data.length <= 1) {
                entry.data = data[0];
                } else {
                entry.data = data.reduce((accumulator, currentArray) => {
                    currentArray.forEach((value, i) => {
                    accumulator[i] = (accumulator[i] || 0) + value;
                    });
                    return accumulator;
                }, []);
                // entry.data = entry.data.map((value) => value / data.length);
                entry.data = entry.data.map((value) => +(value / data.length).toFixed(0));
                }

                return entry;
            });

            return result;
        }
        /*  Sagar wrote code for loading dashboards upto here*/
</script>

