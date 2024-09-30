<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
<!--     <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>
      <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script> -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <style>
	#img_element img{
		max-width: 100%;
		height:100%;
		max-height:100%;
		object-fit: contain;

	}
	.hidden{
		display: none;
	}
    /* pagination css start*/
	.dataTables_info{
		display: none;
	}
	.submited_pagination{
		display: flex;
		margin-bottom: 0px;
		justify-content: end;
		align-items: center;
		background-color: #D3E7DD;
	}
	.p1{
		padding: 10px 10px;
	}
	.s1{
		height: 33px;
    	border-radius: 5px;
    	text-align: center;
	}
	.text-danger{
		font-size: 14px;
	}
	/* pagination css end*/
    /*Loader css Added here */
	.imagediv_load {
		position: relative;
	}

	.loaders {
		margin: 0 auto;
		z-index: 10000;

	}

	.loaders img {
		-webkit-animation: rotation 2s infinite linear;
	}

	.loader-height {
		height: 450px;
	}

	.rotate {
		animation: rotation 2s infinite linear;
	}

	@keyframes rotation {
		from {
			transform: rotate(0deg);
		}

		to {
			transform: rotate(360deg);
		}
	}

	#mapview{
		margin-bottom: 30px;
	}
	.input_place {
		position: sticky;
		width: 450px;
		left: 7px;
		top: -6px;
	}
	.input_place input{
		border: 1px solid !important;
	}
	.search_icon{
		position: absolute;
		top: 9px;
		right: 9px;
		padding: 8px 13px;
		cursor: pointer;
		background-color: green;
		border-radius: 0 3px 3px 0;
	}
	.disabledTab{
		pointer-events: none;
	}

	.swal2-select {
		min-width: 50%;
		max-width: 100%;
		padding: 0.375em 0.625em;
		background: inherit;
		color: inherit;
		font-size: 14px !important;
	}
	.mt-10{
		margin-top:10px;
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
	#export_ap{
		background-color: rgb(111, 27, 40);
		color:#fff;
	}
	#export_ap:hover{
		/* background-color: rgb(111, 27, 40); */
		color:#fff;
	}
	#export_rej{
		background-color: rgb(111, 27, 40);
		color:#fff;
	}
	#export_rej:hover{
		/* background-color: rgb(111, 27, 40); */
		color:#fff;
	}
	
   
</style>
<style>
        /* Styles for loader */
		#overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5); /* semi-transparent */
			z-index: 1000;
			display: none;
		}

		#content {
			position: relative;
			z-index: 2000;
		}

		#loader {
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			z-index: 3000;
			display: none;
		}

		.spinner {
			border: 4px solid rgba(255, 255, 255, 0.3);
			border-top: 4px solid #ffffff;
			border-radius: 50%;
			width: 50px;
			height: 50px;
			animation: spin 1s linear infinite;
		}

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
    </style>
    <!-- Loader markup -->
    <div id="overlay"></div>
	<div id="loader">
		<div class="spinner ml-4"></div>
		<div style="color:white;"><b>Loading please wait...</b></div>
	</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-lg-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">Dissemination users<span class="text-danger"> *</span></label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option value="">Select Dissemination user</option>
                                        <?php 
                                        foreach($user_list as $key => $cvalue){ ?>
                                            <option value="<?=$cvalue['user_id'];?>"><?=$cvalue['first_name'];?> <?=$cvalue['last_name'];?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-md-6 col-lg-2">
                                <div class="form-group my-3">
                                    <label for="" class="label-text">Survey Start Date</label>
                                    <input type="date" name="start_date" class="form-control" placeholder="Date" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-2">
                                <div class="form-group my-3">
                                <label for="" class="label-text">Survey End Date</label>
                                <input type="date" name="end_date" class="form-control" placeholder="Date" />
                                </div>
                            </div>
                            <!-- <div class="col-sm-12 col-md-6 col-lg-3">
                                <div clas="row"> -->
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <button type="reset" class="btn btn-reset-active text-white reset mt-5">Reset</button>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <button class="btn btn-submit-active text-white get_data mt-5" id="get_data_t1" disabled style="background-color:gray">Submit</button>
                                    </div>
                                <!-- </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                            </div>
                            
                        </div>
                    </div>
                    <!-- <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                        <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                        <button class="btn btn-submit-active text-white mt-55px get_data" id="get_data_t1" disabled style="background-color:gray">Submit</button>
                    </div> -->
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <!-- Nav tabs -->
                                <!-- <ul class="nav nav-tabs dashboard-nav"> -->
                                <ul class="nav nav-tabs border-bottom-0 bg-transparent" id="dataTabId"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active " id="Submitted-tab" data-toggle="tab"
                                            data-target="#Submitted" type="button" role="tab"
                                            aria-controls="Submitted" aria-selected="false">Data</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="Approved-tab" data-toggle="tab"
                                            data-target="#Approved" type="button" role="tab"
                                            aria-controls="Approved" aria-selected="true">Dashboard</button>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab"
                                            href="#data">Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab"
                                            href="#graphs">Graphs</a>
                                    </li> -->
                                    
                                </ul>
                                <!-- Tab panes -->
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                
                                <div class="tab-content mt-4">
                                    <!-- <div class="tab-pane active" id="data"> -->
                                    <div class="tab-pane fade show active" id="Submitted" role="tabpanel"
									aria-labelledby="Submitted-tab">
                                        <!-- <div class="input_place p-2 hidden" id="text_submit_search">
                                            <div class="ml-auto">
                                            <input type="text" id="user_submit_search" class="search form-control approved_search" placeholder="( Markets, User name, UAI name, Category)">
                                            <span class="search_icon" onClick="searchSumitedFilter();"><i class="fa fa-search text-white"></i></span>
                                            </div>
                                        </div> -->
                                        <!-- <div class="div_survey_deatils_data_view"></div> -->
                                        <div class="table-responsive" style="height:290px;">
											<div class="loaders" id="info_data">
												<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
													<p class="text-color"><strong> Please select the Location in Filters to view data</strong></p>
												</div>
											</div>
                                            <table class="table table-striped" style="width:100%">
                                                <thead class="bg-dataTable" id="submited_head">
                                                </thead>
                                                <tbody id="submited_body">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="submited_pagination" id="submited_pagination"></div>
                                    </div>
                                    <!-- <div class="tab-pane" id="graphs"> -->
                                    <div class="tab-pane fade " id="Approved" role="tabpanel"
                                        aria-labelledby="Approved-tab">
                                        <div class="div_survey_deatils_view"></div>
                                            
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
<script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>
<script>
    $(function(){
        getSurveyDeatilsViewT1();
        loginrole = <?php echo $this->session->userdata('role')?>;
        // $('.get_data').css("background-color","rgb(111, 27, 40)");
		// $('.get_data').prop("disabled",false);
	});
    // $( document ).ready(function() {
    //     $('.get_data').trigger('click');
    // });
    $('body').on('click', '#get_data_t1', function(){
        		// getSurveyDeatilsViewT1();
	});
    
    $('.get_data').on('click', function(){
		let tabId = $("#dataTabId .active").attr("id");
		switch (tabId) {
			case 'Submitted-tab':
				getSurveyDeatilsViewT1();
                document.getElementById('user_submit_search').value = "";
				break;
			case 'Approved-tab':
				getSurveyDeatilsViewT2();
				break;
		
			default:
				break;
		}
	})
    $('#Submitted-tab').on('click', function(){
		getSurveyDeatilsViewT1();
        document.getElementById('user_submit_search').value = "";
	})
	$('#Approved-tab').on('click', function(){
		getSurveyDeatilsViewT2();
	})
    $('.reset').on('click', function(){
		location.reload();
	});
    $('#user_id').on('change', function(){
        $('.get_data').css("background-color","rgb(111, 27, 40)");
		$('.get_data').prop("disabled",false);
    });
    $('input[name="start_date"]').on('change', function(){
        $('.get_data').css("background-color","rgb(111, 27, 40)");
		$('.get_data').prop("disabled",false);
    });
    $('input[name="end_date"]').on('change', function(){
        $('.get_data').css("background-color","rgb(111, 27, 40)");
		$('.get_data').prop("disabled",false);
    });
	 $('#country_id').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id').html(data);
                }
            });

			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id').html(data);
                }
            });
            if(loginrole==1){
                $('.get_data').css("background-color","rgb(111, 27, 40)");
			    $('.get_data').prop("disabled",false);
            }
        }else{
			$('.get_data').css("background-color","rgb(147, 148, 150)");
			$('.get_data').prop("disabled",true);
            $('#cluster_id').html('<option value="">Select Cluster</option>');
            $('#uai_id').html('<option value="">Select UAI</option>');
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
            
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

        function getSurveyDeatilsViewT1(pageNo =1, recordperpage = 100, search_input = null){
            // alert("called");
            // showLoader();
            var user_id=$('select[name="user_id"]').val();
            // var uai_id=$('select[name="uai_id"]').val();
            // var sub_location_id=$('select[name="sub_location_id"]').val();
            // var cluster_id=$('select[name="cluster_id"]').val();
            var start_date=$('input[name="start_date"]').val();
            var end_date=$('input[name="end_date"]').val();
            
            var query_data = {
                // filter_survey: filter,
                user_id : user_id,
                // uai_id : uai_id,
                // sub_location_id : sub_location_id,
                // cluster_id : cluster_id,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date,
                pagination:{pageNo,recordperpage},
                search: {
                    search_input
                }

            };
            $("#info_data").css("display","none");
                // $('.submited_body').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
            $('#overlay').fadeIn();
            $('#loader').fadeIn();
            $.ajax({
                url : "<?php echo base_url(); ?>dashboard/d_feedback_get_data/",
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
                        $('#text_submit_search').removeClass('hidden');
                        var submitedData = response.user_feedback_data;
                        
                        var tableHead = `<tr>
                                                    <th>Sl.no</th>
                                                    <th>User Name</th>
                                                    <th>Category</th>
                                                    <th>country</th>
                                                    <th>UAI</th>
                                                    <th>Market</th>
                                                    <th>Last accessed Date Time</th>
                                                    <th>Feedback</th>
                                                </tr>`;
                        $('#submited_head').html(tableHead);
                        $('#submited_body').html("");
                        if(submitedData.length > 0){
                            var tableBody ="";
                            var loopcount=0;
                            var count = (pageNo*recordperpage-recordperpage+1);
                            
                            for (let k = 0; k < submitedData.length; k++) {
                            
                            // foreach ($user_feedback_data as $key => $value) {
                                
                                
                                // loopcount++;
                                
                                tableBody += `<tr>`;
                                // tableBody += `<td>`+loopcount+`</td>`;
                                tableBody += `<td>`+count++ +`</td>`;
                                tableBody += `<td>`+submitedData[k]['first_name']+` `+submitedData[k]['last_name']+`</td>`;
                                tableBody += `<td>`+submitedData[k]['category']+`</td>`;
                                tableBody += `<td>`+submitedData[k]['country_name']+`</td>`;
                                tableBody += `<td>`+submitedData[k]['uai_name']+`</td>`;
                                tableBody += `<td>`+submitedData[k]['market_name']+`</td>`;
                                tableBody += `<td>`+submitedData[k]['datetime']+`</td>`;
                                tableBody += `<td>`+submitedData[k]['avg_value']+`</td>`;
                                tableBody += `/<tr>`;
                            }
                            
                            $('#submited_body').append(tableBody);
                        }else{
                            $('#submited_body').html('<tr><td class="nodata" colspan="8"><h5 class="text-danger">No Data Found</h5></td></tr>');
                        }
                        
                        const curentPage = pageNo;
                        const totalRecordsPerPage = recordperpage;
                        const totalRecords= response.total_records;
                        const currentRecords = submitedData.length;
                        pagination.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))

                        $('#overlay').fadeOut();
					    $('#loader').fadeOut();
                    }
                }
            }).always(function(response) {
            // setTimeout(() => hideLoader(), 1000);
            });
        }
        const onPagination = (event) => { 
            var keywords = "";
            // var keywords = $('#user_submit_search').val();
            getSurveyDeatilsViewT1(+event.currentPage,+event.recordsPerPage,keywords);
            
        }
        // function searchSumitedFilter() {
        //     var keywords = $('#user_submit_search').val();
        //     getSurveyDeatilsViewT1(1, 100, keywords);
        // }
        const pagination = new Pagination('#submited_pagination',onPagination);
        function getSurveyDeatilsViewT2(){
            // alert("called");
            // showLoader();
            var user_id=$('select[name="user_id"]').val();
            // var uai_id=$('select[name="uai_id"]').val();
            // var sub_location_id=$('select[name="sub_location_id"]').val();
            // var cluster_id=$('select[name="cluster_id"]').val();
            var start_date=$('input[name="start_date"]').val();
            var end_date=$('input[name="end_date"]').val();
            
            var query_data = {
                // filter_survey: filter,
                user_id : user_id,
                // uai_id : uai_id,
                // sub_location_id : sub_location_id,
                // cluster_id : cluster_id,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date

            };
            // $('.div_survey_deatils_view').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
            $("#info_data").css("display","none");
            $('#overlay').fadeIn();
            $('#loader').fadeIn();
            $.ajax({
                url : "<?php echo base_url(); ?>dashboard/d_feedback_get_graphs_data/",
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
                                <h4>Ethipoia </h4></br>
                                <div class="row mt-4">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="card border-0 card-shadow">
                                            <div class="card-body">
                                                <h4 class="chart-title">Household</h4>
                                                <div class="map_height" id="number_of_ethiopia_hh_users" style="width:100%;height: 300px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="card border-0 card-shadow">
                                            <div class="card-body">
                                                <h4 class="chart-title">Markets</h4>
                                                <div class="map_height" id="number_of_ethiopia_market_users" style="width:100%;height: 300px;"> </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="card border-0 card-shadow">
                                            <div class="card-body">
                                                <h4 class="chart-title">Rangeland</h4>
                                                <div class="map_height" id="number_of_ethiopia_tfc_users" style="width:100%;height: 300px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h4>Kenya </h4></br>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="card border-0 card-shadow">
                                            <div class="card-body">
                                                <h4 class="chart-title">Household</h4>
                                                <div class="map_height" id="number_of_kenya_hh_users" style="width:100%;height: 300px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="card border-0 card-shadow">
                                            <div class="card-body">
                                                <h4 class="chart-title">Markets</h4>
                                                <div class="map_height" id="number_of_kenya_market_users" style="width:100%;height: 300px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="card border-0 card-shadow">
                                            <div class="card-body">
                                                <h4 class="chart-title">Rangeland</h4>
                                                <div class="map_height" id="number_of_kenya_tfc_users" style="width:100%;height: 300px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>                            
                            `;
                        $('.div_survey_deatils_view').html(HTML_GENERAL);
                        monthsimple_barchart('number_of_ethiopia_market_users', response.fielddata_ethiopia_market_users, 'Market wise No.of Dissemination users');
                        monthsimple_barchart('number_of_kenya_market_users', response.fielddata_kenya_market_users, 'Market wise No.of Dissemination users');
                        
                        monthsimple_barchart('number_of_ethiopia_hh_users', response.fielddata_ethiopia_hh_users, 'Household wise No.of Dissemination users');
                        monthsimple_barchart('number_of_ethiopia_tfc_users', response.fielddata_ethiopia_tfc_users, 'Rangeland wise No.of Dissemination users');
                        monthsimple_barchart('number_of_kenya_hh_users', response.fielddata_kenya_hh_users, 'Household wise No.of Dissemination users');
                        monthsimple_barchart('number_of_kenya_tfc_users', response.fielddata_kenya_tfc_users, 'Rangeland wise No.of Dissemination users');
                        
                    }
                    $('#overlay').fadeOut();
					$('#loader').fadeOut();
                }
            }).always(function(response) {
            // setTimeout(() => hideLoader(), 1000);
            });
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
                    text: 'No data available',
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

        function monthsimple_barchart_categories(divid, data, yaxis_units, categories){
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

        function simple_line_graph(divid, data, yaxis_units){
            Highcharts.chart(divid, {

                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                
                credits: {
                    enabled: false
                },
                // title: {
                //     text: 'Monthly Average Temperature'
                // },
                
                xAxis: {
                    // categories: ['Camel', 'Cattle', 'Goat', 'Sheep', 'None']
                    categories: ['Camel', 'Goat', 'Sheep', 'Cattle']
                },
                yAxis: {
                    title: {
                        text: yaxis_units
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: yaxis_units,
                    data : data
                    // data: [16.0, 18.2, 23.1, 27.9, 32.2, 36.4, 39.8, 38.4, 35.5, 29.2,
                    //     22.0, 17.8]
                }]

            });
        }
        function monthsimple_map(divid, data, yaxis_units){
            
            
            // Creating map options
            var mapOptions = {
                center: [16.506174, 80.648015],
                // center: [15.831629999999999, 80.34891333333333],
                zoom: 7
            }
            // Creating a map object
            var map = new L.map('new_map_kml', mapOptions);
            
            // Creating a Layer object
            var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
            
            // Adding layer to the map
            map.addLayer(layer);

            // Define the polygon data as an array of objects, where each object contains the latitude and longitude coordinates and a color value
            // var polygonData = [
            // {latlng: [[51.509865, -0.118092], [51.503054, -0.113215], [51.498383, -0.108409]], color: 'red'},
            // {latlng: [[51.496326, -0.100696], [51.499506, -0.090579], [51.506752, -0.087615]], color: 'green'},
            // {latlng: [[51.512161, -0.091058], [51.514597, -0.102563], [51.510745, -0.112013]], color: 'blue'}
            // ];
            var polygonData = data;
            

            // Create an array to hold the polygons
            var polygons = [];

            // Loop through the polygon data and create a polygon for each set of vertices
            for (var i = 0; i < polygonData.length; i++) {
                var latlng = polygonData[i].latlng;
                var color = polygonData[i].color;
                var popupdata = polygonData[i].popupdata;
                var popupdatavalue = popupdata[0]['name']+" ";
                var polygon = L.polygon(latlng, {color: color, fillOpacity: 0.5});
                // Define the HTML content for the popup
                var popupContent = '<h5>Pasture Details</h5><br/><div class="mb-3" style="font-size: 18px;">Pasture Name : ' + (popupdata[0]['name'])+'<br/>Pasture Type : ' + (popupdata[0]['type'])+'<br/>Animal Type : ' + (popupdata[0]['animal_type'])+'<br/>Forage Condition Type : ' + (popupdata[0]['forage_type'])+'<br/>Contributor Name : ' + (popupdata[0]['contributor_name'])+'<br/></div>';
                polygon.bindPopup(popupContent);
                // polygon.bindPopup('Pasturen Name : ' + (popupdata[0]['name']));
                // polygon.bindPopup('contributor Name : ' + (popupdata[0]['contributor_name']));
                polygons.push(polygon);
            }

            // Create a layer group to hold the polygons
            var polygonGroup = L.layerGroup(polygons);

            // Add the polygon group to a Leaflet map
            // var map = L.map('new_map_kml').setView([51.505, -0.09], 13);
            polygonGroup.addTo(map);
        }

        function monthsimple_linechart(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'spline',
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        marker: {
                            enabled: true,
                            radius: 2.5,
                            symbol: 'circle'
                        },
                        labels: {
                            enabled: false,
                            //radius: 2.5
                        }
                    }
                },
                legend: {
                    reversed: true,
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                series: data
                // series: [{
                //     name: 'Sheep',
                //     color: '#F7BA1E',
                //     data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
                // }, {
                //     name: 'Goats',
                //     color: '#14C9C9',
                //     data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
                // }, {
                //     name: 'Cattle',
                //     color: '#FFB6BA',
                //     data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
                // }, {
                //     name: 'Camels',
                //     color: '#165DFF',
                //     data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
                // },]
            });
        }

        function stacked_bar(divid, data, categories, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                
                xAxis: {
                    // categories: ['Arsenal', 'Chelsea', 'Liverpool', 'Manchester United']
                    categories: categories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Number'
                    },
                    stackLabels: {
                        enabled: true
                    }
                },
                
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'BPL',
                //     color: 'red',
                //     data: [3, 5, 1, 13]
                // }, {
                //     name: 'FA Cup',
                //     color: 'blue',
                //     data: [14, 8, 8, 12]
                // }, {
                //     name: 'CL',
                //     color: 'green',
                //     data: [0, 2, 6, 3]
                // }]
            });

        }
        function monthsimple_grouped_barchart(divid, data, yaxis_units){
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
                        categories: [
                            'Camel',
                            'Goat',
                            'Sheep',               
                            'Cattle',
                            // if(divid=="")   {
                            //    'none', 
                            // }  
                    ],
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
        function monthsimple_grouped_livestock_barchart(divid, data, yaxis_units){
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
                        categories: [
                            'Female',
                            'Male Castrated',
                            'Male Uncastrated', 
                            // if(divid=="")   {
                            //    'none', 
                            // }  
                    ],
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
        function monthsimple_grouped_yesno_barchart(divid, data, yaxis_units){
            var ftype= '';
            if(divid =='average_liters_milk_per_day' ||divid =='average_Selling_Price' ){
                ftype= '{point.y:.1f}';
            }else{
                ftype= '{point.y}';
            }
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
                    categories: [
                        // 'Yes',
                        // 'No',
                        'Age 0-5 (children)',
                        'Age 5-17',
                        'Age 18-65',
                        
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
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
        function monthsimple_grouped_barchart_1(divid, data, yaxis_units){
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
                    categories: [
                        'Camel',              
                        'Cattle',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
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
        function monthsimple_grouped_barchart_2(divid, data, yaxis_units){
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
                    categories: [
                        'Goat',
                        'Sheep',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
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
        function monthsimple_grouped_barchart_11(divid, data, yaxis_units){
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
                    categories: [
                        'Camel',              
                        'Goat',
                        'Sheep',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
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
        function monthsimple_grouped_barchart_22(divid, data, yaxis_units){
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
                    categories: [
                        'Cattle',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
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
        function monthsimple_bar_linechart(divid, bardata, linedata, yaxis_units){
            Highcharts.chart('average_liters_milk_per_day', {
                title: {
                    text: '',
                },
                xAxis: {
                    categories: ['Camel', 'Cattle', 'Goat', 'Sheep']
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ''
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            color: '#000',
                            format: '{point.y}', 
                            y: -5, 
                        
                        }
                    }
                },
                series: [{
                    type: 'column',
                    color: '#165DFF',
                    name: 'No.of litres of milk do you sell per day',
                    // data: [59, 83, 65, 228]
                    data: bardata
                }, {
                    type: 'spline',
                    color: '#14C9C9',
                    name: ' Current selling price of ONE litre of the milk sold',
                    // data: [47, 83.33, 70.66, 239.33],
                    data: linedata,
                },]
            });
        }
        function monthsimple_heat_map(xcategories, ycategories, divid, data, yaxis_units){
            var item_value='';
            if(divid == 'camel_mlilk_uai' || divid == 'camel_mlilk_cluster' || divid == 'cattle_milk_uai' || divid == 'cattle_milk_cluster' ) {
                item_value="litre Milk";
            }else {
                item_value="Kilogram";
            }
            Highcharts.chart(divid, {

                chart: {
                    type: 'heatmap',
                    // marginTop: 40,
                    // marginBottom: 80,
                    // plotBorderWidth: 1
                },


                title: {
                    text: ''
                },

                xAxis: {
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21']
                    categories: xcategories
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    labels: {
                        overflow: 'justify',
                        align: 'center',
                    },
                    // categories: ['Kargi', 'Korr', 'Merille', 'Ol turot','five','six','seven','eight'],
                    categories: ycategories,
                    title: null,
                    reversed: true
                },

                accessibility: {
                    point: {
                        descriptionFormatter: function (point) {
                            var ix = point.index + 1,
                                xName = getPointCategoryName(point, 'x'),
                                yName = getPointCategoryName(point, 'y'),
                                val = point.value;
                            return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                        }
                    }
                },

                // colorAxis: {
                //     min: 0,
                //     minColor: '#FFFFFF',
                //     maxColor: Highcharts.getOptions().colors[0]
                // },
                colorAxis: {
                    stops: [
                        [0, '#C8E76F'], //  for values <= 10
                        [0.5, '#F7BA1E'], // green for values between 10 and 20
                        [1, '#5978A3'] // red for values > 20
                    ]
                },
                    
                tooltip: {
                    formatter: function () {
                        return '<b>' + getPointCategoryName(this.point, 'x') + '</b> <br><b>' +
                            this.point.value + '</b> is price of one '+ item_value +' in this cluster<br><b>' + getPointCategoryName(this.point, 'y') + '</b>';
                    }
                },
                

                series: [{
                    // name: 'Camel Milk',
                    name: yaxis_units,
                    borderWidth: 0,
                    // data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                    data: data,
                    dataLabels: {
                        enabled: true,
                        color: '#000000'
                    }
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            yAxis: {
                                labels: {
                                    formatter: function () {
                                        return this.value.charAt(0);
                                    }
                                }
                            }
                        }
                    }]
                },
                
            });
        }
        function monthsimple_heat_map1(xcategories, ycategories, divid, data, yaxis_units){
            var item_value='';
            if(divid == 'camel_mlilk_uai' || divid == 'camel_mlilk_cluster' || divid == 'cattle_milk_uai' || divid == 'cattle_milk_cluster' ) {
                item_value="litre Milk";
            }else {
                item_value="Kilogram";
            }
            Highcharts.chart(divid, {

                chart: {
                    type: 'heatmap',
                    // marginTop: 40,
                    // marginBottom: 80,
                    // plotBorderWidth: 1
                },


                title: {
                    text: ''
                },

                xAxis: {
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21']
                    categories: xcategories
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    // categories: ['Kargi', 'Korr', 'Merille', 'Ol turot','five','six','seven','eight'],
                    categories: ycategories,
                    title: null,
                    reversed: true
                },

                accessibility: {
                    point: {
                        descriptionFormatter: function (point) {
                            var ix = point.index + 1,
                                xName = getPointCategoryName(point, 'x'),
                                yName = getPointCategoryName(point, 'y'),
                                val = point.value;
                            return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                        }
                    }
                },

                // colorAxis: {
                //     min: 0,
                //     minColor: '#FFFFFF',
                //     maxColor: Highcharts.getOptions().colors[0]
                // },
                colorAxis: {
                    stops: [
                        [0, '#C8E76F'], //  for values <= 10
                        [0.5, '#F7BA1E'], // green for values between 10 and 20
                        [1, '#5978A3'] // red for values > 20
                    ]
                },
                    
                tooltip: {
                    formatter: function () {
                        return null;
                    }
                },
                

                series: [{
                    // name: 'Camel Milk',
                    name: yaxis_units,
                    borderWidth: 0,
                    // data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                    data: data,
                    dataLabels: {
                        enabled: true,
                        color: '#000000'
                    }
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            yAxis: {
                                labels: {
                                    formatter: function () {
                                        return this.value.charAt(0);
                                    }
                                }
                            }
                        }
                    }]
                },
                
            });
        }
        function monthstacked_grouped_barchart(divid, xcategories, data1, data2, yaxis_units){
            // Highcharts.chart('sample_container', {
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    // categories: ['Jan', 'Feb', 'Mar']
                    categories: xcategories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    },
                    stackLabels: {
                        enabled: true,
                        format: '{total}',
                        style: {
                            fontWeight: 'bold',
                            // color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                enabled:false,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
            
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total People surveyed : ' + this.point.stackTotal + '';
                    }
                },
                stackLabels: {
                enabled: false,
                },
                plotOptions: {
                    column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %'
                    }
                    }
                },
                series: [{
                    name: 'People who ate <5 Food groups',
                color: '#F7BA1E',
                    // data: [200.3, 30, 0]
                    data: data1
                }, {
                    name: 'People who ate >=5 Food groups',
                color: '#6A9F58',
                    // data: [154.7, 70, 85]
                    data: data2
                }]
            });

        }
        
        /*  Sagar wrote code for loading dashboards upto here*/
</script>


    <script>
    
        $('body').on('click', '#tab_5', function(){
            // $('#btn_tab5').trigger('click');
            getTaskWiseView();
        });
        $('body').on('click', '#get_data_t5', function(){
            getTaskWiseView();
        });
        $('.reset').on('click', function(){
            location.reload();
        });
        $('#country_id_5').on('change', function(){
            var country_id=$(this).val();
            if(country_id != '')
            {
                $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                    type: 'POST',  // http method
                    data: { country_id: country_id },  // data to submit
                    success: function (data) {
                        $('#cluster_id_5').html(data);
                    }
                });

                $.ajax('<?=base_url()?>reports/getUaiByCountry', {
                    type: 'POST',  // http method
                    data: { country_id: country_id },  // data to submit
                    success: function (data) {
                        $('#uai_id_5').html(data);
                    }
                });
                // if(loginrole==1){
                //     $('.get_data').css("background-color","rgb(111, 27, 40)");
                //     $('.get_data').prop("disabled",false);
                // }
            }else{
                $('.get_data_5').css("background-color","rgb(147, 148, 150)");
                $('.get_data_5').prop("disabled",true);
                $('#cluster').html('<option value="">Select Cluster</option>');
                $('#uai_id_5').html('<option value="">Select UAI</option>');
                $('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
                
            }   
        });
        

        $('#uai_id_5').on('change', function(){
            var uai_id=$(this).val();
            
            if(uai_id != '')
            {
                $('.get_data_5').css("background-color","rgb(111, 27, 40)");
                $('.get_data_5').prop("disabled",false);
                $('#cluster_id_5').html('<option value="">Select Cluster</option>');
                $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                    type: 'POST',  // http method
                    data: { uai_id: uai_id },  // data to submit
                    success: function (data) {
                        $('#sub_location_id_5').html(data);
                    }
                }); 
            } 
            else{
                if(loginrole==1){
                    //empty
                }else{
                    $('.get_data_5').css("background-color","rgb(147, 148, 150)");
                    $('.get_data_5').prop("disabled",true);
                }
                $('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
            
            }   
        });
        $('#cluster_id_5').on('change', function(){
            var cluster_id=$(this).val();
            
            if(cluster_id != '')
            {
                $('.get_data_5').css("background-color","rgb(111, 27, 40)");
                $('.get_data_5').prop("disabled",false);
                $('#uai').html('<option value="">Select Cluster</option>'); 
            } 
            else{
                $('.get_data_5').css("background-color","rgb(147, 148, 150)");
                $('.get_data_5').prop("disabled",true); 
            }   
        });
        
        /*  Mallikharjuna wrote code for loading dashboards from here*/

        function getTaskWiseView(){
            var country=$('select[name="country_id_5"]').val();
            var uai=$('select[name="uai_id_5"]').val();
            var sub_location=$('select[name="sub_location_id_5"]').val();
            var cluster=$('select[name="cluster_id_5"]').val();
            var start_date=$('input[name="start_date_5"]').val();
            var end_date=$('input[name="end_date_5"]').val();
            var task_id=$('select[name="task_id"]').val();
            
            var selectedName = "";
            if(task_id.length > 0){
                const selectBox = document.getElementById("task_id");
                selectedName = selectBox.options[selectBox.selectedIndex].text;
            }
            var query_data = {
                country : country,
                uai : uai,
                sub_location : sub_location,
                cluster : cluster,
                task_id : task_id,
                start_date : start_date,
                end_date : end_date

            };
                $('.div_task_view').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_taskwise_data/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `<div class="row mt-4">
                                            <div class="col-12">
                                            <div class="card border-0 card-shadow"><h4 class="chart-title">Task Details</h4></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Status (${task_id.length > 0 ? selectedName : 'All'})</h4>
                                                        <div
                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                            <div class="map_height" id="task_level"
                                                                style="width:260px;height: 260px;">
                                                            </div>
                                                            <div class="">
                                                                <div class="primary-v9 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Submitted</span>
                                                                        <span
                                                                            class="large-bold pl-3">`+response.task_level[0]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v10 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Approved</span><span
                                                                            class="large-bold pl-3">`+response.task_level[1]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v11 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Rejected</span><span
                                                                            class="large-bold pl-3">`+response.task_level[2]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Rejection Reasons (${task_id.length > 0 ? selectedName : 'All'})</h4>
                                                        <div
                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                            <div class="map_height" id="rejection_reasons"
                                                                style="width:260px;height: 260px;">
                                                            </div>
                                                            <div class="">
                                                                <div class="primary-v9 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Poor Picture Quality</span>
                                                                        <span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[0]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v10 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Wrong location</span><span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[1]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v11 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Value out of range</span><span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[2]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v3 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Others</span><span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[3]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                            <div class="card border-0 card-shadow"><h4 class="chart-title">Payment Details</h4></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="uai_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="cluster_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Contributor wise</h4>
                                                        <div class="map_height" id="contributor_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Task wise</h4>
                                                        <div class="map_height" id="task_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                            $('.div_task_view').html(HTML_GENERAL);
                            task_wise_piechart('task_level', response.task_level, 'Number of records');
                            task_wise_piechart('rejection_reasons', response.rejection_reasons, 'Number of records');
                            horizantal_barchart('task_wise', response.task_wise,"KES");
                            horizantal_barchart('uai_wise', response.uai_wise,'KES');
                            horizantal_barchart('cluster_wise', response.cluster_wise,'KES');
                            horizantal_barchart('contributor_wise', response.contributor_wise,'KES');
                            
                        }
                    }
                }).always(function(response) {
            });
        }

        function task_wise_piechart(divid, data, yaxis_units){
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
                            enabled: false
                        },
                        showInLegend: false
                    }
                },
                
                series: [{
                    name: yaxis_units,
                    data: data
                }]
            });
        }

        function task_wise_barchart(divid, data){
            Highcharts.chart(divid, {
            chart: {
                type: 'bar'
            },
            title: {
                text: '',
            },
            subtitle: {
                text: '',
            },
            xAxis: {
                categories: data.filter(b => b.y != 0).map(a=>a.name),
                // categories: ['Payment Details1', 'Payment Details 2', 'Payment Details 3', 'Payment Details 4', 'Payment Details 5'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [
                {
                name: 'Contributor Name',
                color: '#14C9C9',
                data: data.filter(b => b.y != 0).map(a=>a.y),
            }]
            });   
        }
        function horizantal_barchart(divid, data, yaxis_units){
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
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            color: '#000',
                            format: '{point.y}', 
                            y: -5, 
                        
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                },
                series: [
                    { 
                        name: yaxis_units,
                        colorByPoint: true,
                        data: data.filter(b => b.y != 0)
                        
                    }
                ],
            });
        }
        /*  Mallikharjuna wrote code for loading dashboards upto here*/
    </script>