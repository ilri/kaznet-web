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
			<?php 
				$survey_id = $this->uri->segment(3);
				switch ($survey_id) {
					case '3':
						$page_title ="Milk Production Details";
						break;
					case '4':
						$page_title ="Body condition and weight";
						break;
					case '5':
						$page_title ="Livestock Prices & Quality";
						break;
					case '6':
						$page_title ="MUAC";
						break;
					case '7':
						$page_title ="Prices of Index commodities";
						break;
					case '8':
						$page_title ="RCSI";
						break;
					case '9':
						$page_title ="Transect forage conditions";
						break;
					case '10':
						$page_title ="Livestock births and deaths trade";
						break;
					case '11':
						$page_title ="Livestock Volumes";
						break;
					case '12':
						$page_title ="Livestock Feeds and Water";
						break;
					case '13':
						$page_title ="Crops Water Incomes Expenditures";
						break;
					case '14':
						$page_title ="Conflict Exposure";
						break;
					
					default:
						# code...
						break;
				}?>
            <!-- <div class="col-sm-12 col-md-12 col-lg-12 mt-3"> -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Survey Data</a></li>
                        <li class="breadcrumb-item active"><?php echo($page_title); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- <div class="card mt-3 border-0"> -->
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="title"><?php echo($page_title); ?></h4>
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
                                            <label for="" class="label-text">UAI
												<?php $loginrole = $this->session->userdata('role');
												if($loginrole!=1){
													?>
													<span class="text-danger"> * </span>
												<?php }?>
											</label>
                                            <select class="form-control" id="uai_id" name="uai_id">
                                                <option value="">Select UAI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text" >Sub Location</label>
                                            <select class="form-control" id="sub_location_id" name="sub_location_id">
                                                <option value="">Select Sub Location</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Cluster
												<?php 
												if($loginrole!=1){
													?>
												<span class="text-danger"> * </span>
												<?php }?>
											</label>
                                            <select class="form-control" id="cluster_id" name="cluster_id">
                                                <option value="">Select Cluster</option>
                                                <!-- <?php 
                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                               <?php  } ?> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text" >Contributor</label>
                                            <select class="form-control" id="contributor_id" name="contributor_id" >
                                                <option value="">Select Contributor</option>
                                            </select>
                                        </div>
                                    </div>
									<?php 
									if($survey_type['type'] == "Market Task"){
										?>
										<div class="col-sm-12 col-md-6 col-lg-4">
											<div class="form-group my-3">
												<label for="" class="label-text">Market</label>
												<select class="form-control" id="market_id" name="market_id">
													<option value="">Select Market</option>
												</select>
											</div>
										</div>
										<?php 
									}else if($survey_type['type'] == "Rangeland Task"){
										?>
										<div class="col-sm-12 col-md-6 col-lg-4">
											<div class="form-group my-3">
												<label for="" class="label-text">Pasture Type</label>
												<select class="form-control" id="pasture_type" name="pasture_type">
													<option value="">Select Pasture Type</option>
													<option value="Dry season">Dry season</option>
													<option value="Wet season">Wet season</option>
												</select>
											</div>
										</div>
										<?php 
									}else{
										?>
										<div class="col-sm-12 col-md-6 col-lg-4">
											<div class="form-group my-3">
												<label for="" class="label-text">Respondent</label>
												<select class="form-control" id="respondent_id" name="respondent_id">
													<option value="">Select Respondent</option>
												</select>
											</div>
										</div>
										<?php 
									}
									?>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Survey Start Date</label>
                                            <input type="date" name="start_date_vsd" id="txtFromDate" class="form-control" placeholder="Date" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                        <label for="" class="label-text">Survey End Date</label>
                                        <input type="date" name="end_date_vsd" id="txtToDate" class="form-control" placeholder="Date" />
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
								<button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
								<button class="btn btn-submit-active text-white mt-55px get_data" disabled style="background-color:gray">Submit</button>
							</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-sm-12 col-md-12 col-lg-12 text-right my-3">
                <div class="nav nav-tabs border-0 justify-content-end" id="myTab" role="tablist">
                    <button type="button" class="btn btn-secondary active left" id="dataview-tab"
                        data-toggle="tab" data-target="#dataview" type="button" role="tab"
                        aria-controls="dataview" aria-selected="false"><img
                            src="<?php echo base_url(); ?>include/assets/images/data-view.svg"> Data View</button>
                    <button type="button" class="btn btn-secondary right" id="mapview-tab" data-toggle="tab"
                        data-target="#mapview" type="button" role="tab" aria-controls="mapview"
                        aria-selected="true"><img src="<?php echo base_url(); ?>include/assets/images/map-view.svg"> Map View</button>
                    
                </div>
            </div> -->

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="mapview" role="tabpanel" aria-labelledby="mapview-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="dataview" role="tabpanel"
                        aria-labelledby="dataview-tab">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10 mb-3">
                                <ul class="nav nav-tabs border-bottom-0 bg-transparent" id="dataTabId"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active disabledTab" id="Submitted-tab" data-toggle="tab"
                                            data-target="#Submitted" type="button" role="tab"
                                            aria-controls="Submitted" aria-selected="false">Submitted</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabledTab" id="Approved-tab" data-toggle="tab"
                                            data-target="#Approved" type="button" role="tab"
                                            aria-controls="Approved" aria-selected="true">Approved</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link disabledTab" id="Rejected-tab" data-toggle="tab"
                                            data-target="#Rejected" type="button" role="tab"
                                            aria-controls="Rejected" aria-selected="false">Rejected</button>
                                    </li>
                                </ul>
                            </div>
							<!-- <div class="col-md-2 export_align">
								<button type="button" class="btn btn-sm hidden"  id="export_sub" onclick="exportXcel()">Export data</button>
							</div> -->
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="Submitted" role="tabpanel"
									aria-labelledby="Submitted-tab">
									<?php echo form_open('', array('id' => 'moderateVerifyDataForm')); ?>
										<div class="col-md-12 export_align">
											<button type="button" class="btn btn-sm hidden"  id="export_sub" data-tabvalue=1 onclick="exportXcel(event)">Export data</button>
										</div>
										<div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<!-- <div class="input_place p-2 hidden" id="text_submit_search">
												<div class="ml-auto">
												<input type="text" id="user_submit_search" class="search form-control submited_search" placeholder="(Search on Name, Last name)">
												<span class="search_icon" onClick="searchSumitedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</div> -->
											
											<div class="mt-10">
											<?php if ($this->session->userdata('role') == 6) {?>
												<button type="button" class="btn btn-sm btn-success verify hidden ml-2" data-status="2">Approve</button>
												<button type="button" class="btn btn-sm btn-danger verify hidden" data-status="3">Reject</button>
												<!-- <button type="button" class="btn btn-sm btn-danger delete hidden ml-2" data-status="delete">Delete</button> -->
											<?php } ?>
											</div>
										</div>
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
									<?php echo form_close(); ?>
                                    </div>
                                    <div class="tab-pane fade " id="Approved" role="tabpanel"
                                        aria-labelledby="Approved-tab">
										<div class="col-md-12 export_align">
											<button type="button" class="btn btn-sm hidden"  id="export_ap" data-tabvalue=2 onclick="exportXcel(event)">Export data</button>
										</div>
										<div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<!-- <span class="p-2 input_place hidden" id="text_approved_search">
												<div class="ml-auto">
												<input type="text" id="user_approved_search" class="search form-control approved_search" placeholder=" (Search on First Name, User Name) ">
												<span class="search_icon" onClick="searchApprovedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</span> 
											<button type="button" class="btn btn-sm btn-primary" id="export_ap" onclick="approvedeExportXcel()">Export data</button>-->
										</div> 
                                        <div class="table-responsive" style="height:290px;">
                                            <table class="table table-striped" style="width:100%">
                                                <thead class="bg-dataTable" id="approved_head">
                                                </thead>
                                                <tbody id="approved_body">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="approved_pagination" class="submited_pagination"></div>
                                    </div>
                                    <div class="tab-pane fade" id="Rejected" role="tabpanel"
                                        aria-labelledby="Rejected-tab">
										<div class="col-md-12 export_align">
											<button type="button" class="btn btn-sm hidden"  id="export_rej" data-tabvalue=3 onclick="exportXcel(event)">Export data</button>
										</div>
										<div class="text-right mt-2 mb-2 pr-3">
											<div class="input_place p-2 hidden" id="text_rejected_search">
												<div class="ml-auto">
												<input type="text" id="user_rejected_search" class="search form-control rejected_search" placeholder="(Search on First Name, Last Name)">
												<span class="search_icon" onClick="searchRejectedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</div>
											<!-- <button type="button" class="btn btn-sm btn-primary hidden" id="export_rej" onclick="rejectedExportXcel()">Export data</button> -->
										</div> 
                                        <div class="table-responsive" style="height:290px;">
                                            <table class="table table-striped" style="width:100%">
                                                <thead class="bg-dataTable" id="rejected_head"></thead>
                                                <tbody id="rejected_body"></tbody>
                                            </table>
                                        </div>
                                        <div id="rejected_pagination" class="submited_pagination"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="ImgModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="img_element" style="height: auto; width: 100%;text-align:center"></div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
<script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>

<script>
	var survey_type = "<?php echo $survey_type['type']?>";
	function openImgPopup(env){
		var img = env.target.dataset.imgUrl;
		$('#ImgModal').modal('show');
		setTimeout(() => {
			$('#img_element').html('<img src="'+img+'" class="img-fit" />');
		}, 500)
	}
	$(document).ready(function(){
        $("#txtFromDate").datepicker({
			numberOfMonths: 2,
			maxDate: new Date(),
            // onSelect: function(selected) {
            // $("#txtToDate").datepicker("option","minDate", selected)
            // }
			onSelect: function(selectedDate) {
				var endDate = $("#txtToDate");
				endDate.datepicker("option", "minDate", selectedDate);
			}
        });
        $("#txtToDate").datepicker({ 
			numberOfMonths: 2,
			maxDate: new Date(),
            // onSelect: function(selected) {
            // $("#txtFromDate").datepicker("option","maxDate", selected)
            // }
			onSelect: function(selectedDate) {
				var startDate = $("#txtFromDate");
				startDate.datepicker("option", "maxDate", selectedDate);
			}
        });  
    });
	$('.get_data').on('click', function(){
		let tabId = $("#dataTabId .active").attr("id");
		switch (tabId) {
			case 'Submitted-tab':
				getSubmitedDataView();
				break;
			case 'Approved-tab':
				getAprovedDataView();
				break;
			case 'Rejected-tab':
				getRejectedDataView();
				break;
		
			default:
				break;
		}
	})

	$('#Submitted-tab').on('click', function(){
		getSubmitedDataView();
	})
	$('#Approved-tab').on('click', function(){
		getAprovedDataView();
	})
	$('#Rejected-tab').on('click', function(){
		getRejectedDataView();
	})
    function getSubmitedDataView(pageNo =1, recordperpage = 100, search_input = null){
		
		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var survey_id = <?php echo $this->uri->segment(3); ?>;
		// var survey_type = "<?php echo $survey_type['type']?>";
		if(survey_type == "Market Task"){
			var respondent_id = $('select[name="market_id"]').val();
		}else if(survey_type == "Rangeland Task" ){
			var respondent_id = $('select[name="pasture_type"]').val();
		}else{
			var respondent_id = $('select[name="respondent_id"]').val();
		}
		var start_date=$('input[name="start_date_vsd"]').val();
        var end_date=$('input[name="end_date_vsd"]').val();
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,			
            start_date : start_date,
            end_date : end_date,
			survey_id: survey_id,
			survey_type: survey_type,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			},
			pa_verified_status:1
		};
		$("#info_data").css("display","none");
		// var imageLoader = `<div class="loaders">
		// 		<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
		// 			<img class="map_icon" src="<?php echo base_url(); ?>include/img/Loader_new.svg" alt="loader">
		// 			<p class="text-color"><strong> Loading...</strong></p>
		// 		</div>
		// 	</div>`;
		// $('#submited_body').html(imageLoader);
		$('#overlay').fadeIn();
        $('#loader').fadeIn();
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_submited_data/<?php echo $this->uri->segment(3); ?>",
			data: query_data,
			type: "POST",
			dataType: "JSON",
			error: function() {
				$('#submited_body').html('<h4 class="text-center">No Data Found</h4>');
			},
			success: function(response) {
				if (response.status == 0) {
					$.toast({
						heading: 'Error!',
						text: response.msg,
						icon: 'error'
					});
					$('#submited_body').html('<h4 class="text-center">No data Found</h4>');
					$('#export_sub').addClass('hidden');
					return false;
				}
				$('#text_submit_search').removeClass('hidden');
				// $('#aprove_all_btn').removeClass('hidden');
				$('#export_sub').removeClass('hidden');
				var role = response.user_role;
				var fields = response.fields;
				var submitedData = response.submited_data;
				var lkp_country = response.lkp_country;
				var lkp_cluster = response.lkp_cluster;
				var lkp_uai = response.lkp_uai;
				var lkp_sub_location = response.lkp_sub_location;
				var lkp_location_type = response.lkp_location_type;
				var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				var respondent_name = response.respondent_name;
				var lkp_market = response.lkp_market;
				var lkp_transect_pastures = response.lkp_transect_pasture;
				var lkp_lr_body_condition = response.lkp_lr_body_condition;
				var lkp_sr_body_condition = response.lkp_sr_body_condition;
				var lkp_animal_type = response.lkp_animal_type;
				var lkp_animal_herd_type = response.lkp_animal_herd_type;
				var lkp_food_groups = response.lkp_food_groups;
				var lkp_transect_pasture = response.lkp_transect_pasture;
				var lkp_dry_wet_pasture = response.lkp_dry_wet_pasture;
				var lkp_transport_means = response.lkp_transport_means;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				if ((role == 6)) {
					tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
				}
				// if (role == 8) {
				// 	tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
					
				// }
				tableHead += `<th>S.No.</th>`;
				// if ((role == 1 || role == 2)) {
				// 	tableHead += `<th>Delete</th>`;
				// }
				if (role == 6) {
					tableHead += `<th>Cluster Verify</th>`;
					// tableHead += `<th>Country Verify</th>`;
				}else{
					tableHead += `<th>Cluster Verify</th>`;
				}
				tableHead += `<th nowrap>Contributor</th>`;
				if(survey_id == 5 || survey_id == 7 || survey_id == 11){
					tableHead += `<th nowrap>Market</th>`;
				}else if(survey_id == 9 ){
					tableHead += `<th nowrap>Transect Pastures</th>`;
				}else{
					tableHead += `<th nowrap>Respondent</th><th nowrap>Respondent HHID</th>`;
				}
				tableHead += `<th nowrap>Country</th>`;
				tableHead += `<th nowrap>UAI</th>`;
				tableHead += `<th nowrap>Sub Location</th>`;
				tableHead += `<th nowrap>Cluster</th>`;
				for (const key in fields) {
					const label = fields[key]['label'];
					const type = fields[key]['type'];
					if(label != "Declaration"){
						td_count++;
						if (type == 'kml') {
							if(survey_id == 5){
								tableHead += `<th>`+label+`</th>`;
								tableHead += `<th>KML Details</th>`;
							}else{
								tableHead += `<th>`+label+`</th>`;	
							}
						}else{
							tableHead += `<th>`+label+`</th>`;
						}
					}
				}
				tableHead += `<th>LATITUDE</th><th>LONGITUDE</th><th>Uploaded By</th><th>Uploaded Datetime</th>`;

				$('#submited_head').html(tableHead);

				$('#submited_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['data_id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						if ((role == 6)) {
							tableBody += `<td class="text-center"><input type="checkbox" name="check_sub[]" value="`+submitedData[k]['id']+`"`;
							tableBody += `</td>`;	
						}
						
						tableBody += `<td>`+ count++ +`</td>`;
						// if ((role == 1 || role == 2)) {
						// 	tableBody += `<td><a href="javascript:void(0);" class="delete_submited text-danger" onClick="deleteRecord(`+submitedData[k]['id']+`);"><i class="fa fa-trash-o"></i></a></td>`;
						// }
						if(role == 6){
							tableBody += `<td class="text-center">`;
							if(submitedData[k]['pa_verified_status'] == 1){
								tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
							}else if(submitedData[k]['pa_verified_status'] == 2){
								tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
							}else{
								tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
							}
							tableBody += `</td>`;
						} else{
							tableBody += `<td class="text-center">`;
							if(submitedData[k]['pa_verified_status'] == 1){
								tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
							}else if(submitedData[k]['pa_verified_status'] == 2){
								tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
							}else{
								tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
							}
							tableBody += `</td>`;
							
						}
						// tableBody += `<td>`;
						// if(submitedData[k]['images'] != 'N/A'){
						// 	tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k]['images'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
						// }else{
						// 	tableBody += `N/A`;
						// }
						// tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						
						tableBody += `<td>`;
								if(survey_id == 5 || survey_id == 7 || survey_id == 11){
									if(submitedData[k]['market_id']){
										for (mkey in lkp_market){
											if(lkp_market[mkey]['market_id'] == submitedData[k]['market_id']){
												tableBody += lkp_market[mkey]['name'];
											}
										}
									}else{
										tableBody +="N/A";
									}
								}else if(survey_id == 9 ){
									if(submitedData[k]['contributor_name']){
										tableBody += submitedData[k]['contributor_name'];
									}else{
										tableBody +="N/A";
									}
								}else{
									tableBody += submitedData[k]['respondent'];
								}
						tableBody += `</td>`;
						if(survey_id == 3 || survey_id == 4 || survey_id == 6 || survey_id == 8 || survey_id == 10 || survey_id == 12 || survey_id == 13 || survey_id == 14){
							tableBody += `<td>`;
							if(submitedData[k]['hhid']){
								tableBody += submitedData[k]['hhid'];
							}else{
								tableBody +="N/A";
							}
							tableBody += `</td>`;
						}
						tableBody += `<td>`;
							for (ckey in lkp_country){
								if(lkp_country[ckey]['country_id'] == submitedData[k]['country_id']){
									tableBody += lkp_country[ckey]['name'];
								}
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['uai_id']){
							for (uaikey in lkp_uai){
								if(lkp_uai[uaikey]['uai_id'] == submitedData[k]['uai_id']){
									tableBody += lkp_uai[uaikey]['uai'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['sub_location_id']){
							for (ikey in lkp_sub_location){
								if(lkp_sub_location[ikey]['sub_loc_id'] == submitedData[k]['sub_location_id']){
									tableBody += lkp_sub_location[ikey]['location_name'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['cluster_id']){
							for (clkey in lkp_cluster){
								if(lkp_cluster[clkey]['cluster_id'] == submitedData[k]['cluster_id']){
									tableBody += lkp_cluster[clkey]['name'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						for (let key = 0; key < fields.length; key++) {
							const label = fields[key]['label'];
							const field = 'field_'+fields[key]['field_id'];
							const type = fields[key]['type'];
							if(label != "Declaration"){
								if (type == 'file') {
									tableBody += `<td>`;
										if(submitedData[k][field] != null){
											
											tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
											
										}else{
											tableBody += 'N/A';
										}
									tableBody += `</td>`;
								}else if (type == 'group') {
									tableBody += `<td><a class="text-primary" target="_blank" href="<?php echo base_url(); ?>reports/groupData/<?php echo $this->uri->segment(3)?>/`+ fields[key]['field_id']+`/`+ submitedData[k]['data_id'] +`">View Data</a></td>`;
								}else if (type == 'lkp_country') {
									tableBody += `<td>`;
										for (ckey in lkp_country){
											if(submitedData[k][field]){
												if(lkp_country[ckey]['country_id'] == submitedData[k][field]){
													tableBody += `<img src="<?php echo base_url(); ?>include/assets/images/${lkp_country[ckey]['name']}-flag.svg">   `+lkp_country[ckey]['name'];
												}
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_cluster') {
									tableBody += `<td>`;
										if(submitedData[k][field]){
											for (clkey in lkp_cluster){
												if(lkp_cluster[clkey]['cluster_id'] == submitedData[k][field]){
													tableBody += lkp_cluster[clkey]['name'];
												}
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_location_type') {
									tableBody += `<td>`;
										for (dskey in lkp_location_type){
											if(lkp_location_type[dskey]['location_id'] == submitedData[k][field]){
												tableBody += lkp_location_type[dskey]['name'];
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_type_lactating') {
									tableBody += `<td>`;
									for (akey in lkp_animal_type_lactating){
										if(lkp_animal_type_lactating[akey]['animal_type_lactating_id'] == submitedData[k][field]){
											tableBody += lkp_animal_type_lactating[akey]['name'];
										}
									}
									tableBody += `</td>`;

								}else if (type == 'respondent_name') {
									tableBody += `<td>`;
									for (rkey in respondent_name){
										if(submitedData[k][field]){
											if(respondent_name[rkey]['data_id'] == submitedData[k][field]){
												tableBody += respondent_name[rkey]['first_name']+' '+respondent_name[rkey]['last_name'];
											}
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_grampanchayat') {
									tableBody += `<td>`;
									for (gkey in gn_list){
										if(gn_list[gkey]['grampanchayat_id'] == submitedData[k][field]){
											tableBody += gn_list[gkey]['grampanchayat_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_crop') {
									tableBody += `<td>`;
									for (ckey in crop_list){
										if(crop_list[ckey]['crop_id'] == submitedData[k][field]){
											tableBody += crop_list[ckey]['crop_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_branch_details') {
									tableBody += `<td>`;
									for (let bckey = 0; bckey < branch_list.length; bckey++) {
										if(branch_list[bckey]['branch_id'] == submitedData[k][field]){
											tableBody += branch_list[bckey]['branch_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_farmer_bank_details') {
									tableBody += `<td>`;
									for (let dnkey = 0; dnkey < bank_list.length; dnkey++) {
										const element = bank_list[dnkey];
										if(bank_list[dnkey]['bank_id'] == submitedData[k][field]){
											tableBody += bank_list[dnkey]['bank_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_village') {
									tableBody += `<td>`;
									for (let vkey = 0; vkey < village_list.length; vkey++) {
										if(village_list[vkey]['village_id'] == submitedData[k][field]){
											tableBody += village_list[vkey]['village_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'signature') {
									tableBody += `<td>`;
										if(submitedData[k][field] == 'N/A' || submitedData[k][field] == null){
											tableBody += `N/A`;
										}else{
											tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;
										}
									tableBody += `</td>`;
								}else if (type == 'kml') {
									if(survey_id == 5){
										tableBody += `<td>`;
										tableBody += (submitedData[k][field] != null ? submitedData[k][field]  : `N/A`);
										tableBody += `</td>`;
										tableBody += `<td>`;
										if(submitedData[k][field+'_kml'] == 'N/A' || submitedData[k][field+'_kml'] == null){
											tableBody += `N/A`;
										}else{
											tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field+'_kml']+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;

											
										}
										tableBody += `</td>`;
									}else{
										tableBody += `<td>`;
										if(submitedData[k][field] != 'N/A'){
											tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field]+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;
										}else{
											tableBody += `N/A`;
										}
										tableBody += `</td>`;
									}
								}else if (type == 'lkp_market') {
									tableBody += `<td>`;
									for (mkey in lkp_market){
										if(lkp_market[mkey]['market_id'] == submitedData[k][field]){
											tableBody += lkp_market[mkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_lr_body_condition') {
									tableBody += `<td>`;
									for (bkey in lkp_lr_body_condition){
										if(lkp_lr_body_condition[bkey]['id'] == submitedData[k][field]){
											tableBody += lkp_lr_body_condition[bkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_sr_body_condition') {
									tableBody += `<td>`;
									for (bkey in lkp_sr_body_condition){
										if(lkp_sr_body_condition[bkey]['id'] == submitedData[k][field]){
											tableBody += lkp_sr_body_condition[bkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_type') {
									tableBody += `<td>`;
									for (akey in lkp_animal_type){
										if(lkp_animal_type[akey]['animal_type_id'] == submitedData[k][field]){
											tableBody += lkp_animal_type[akey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_herd_type') {
									tableBody += `<td>`;
									// for (ahkey in lkp_animal_herd_type){
									// 	if(lkp_animal_herd_type[ahkey]['id'] == submitedData[k][field]){
									// 		tableBody += lkp_animal_herd_type[ahkey]['name'];
									// 	}
									// }
										if(submitedData[k][field]){
											// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
											let checkedValues =(submitedData[k][field]).split('&#44;');
											let output = '';
											for (ahkey in lkp_animal_herd_type){
												for (var i = 0; i < checkedValues.length; i++) {
													if (checkedValues[i] == lkp_animal_herd_type[ahkey]['id']) {
														output += lkp_animal_herd_type[ahkey]['name'] + '<br>';
													}
												}
											}
											tableBody += output;
										}else{
											tableBody +="N/A";
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_food_groups') {
									tableBody += `<td>`;
									// for (fkey in lkp_food_groups){
									// 	if(lkp_food_groups[fkey]['id'] == submitedData[k][field]){
									// 		tableBody += lkp_food_groups[fkey]['name'];
									// 	}
									// }
										if(submitedData[k][field]){
											// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
											let checkedValues =(submitedData[k][field]).split('&#44;');
											let output = '';
											for (fkey in lkp_food_groups){
												for (var i = 0; i < checkedValues.length; i++) {
													if (checkedValues[i] == lkp_food_groups[fkey]['id']) {
														output += lkp_food_groups[fkey]['name'] + '<br>';
													}
												}
											}
											tableBody += output;
										}else{
											tableBody +="N/A";
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_transect_pasture') {
									tableBody += `<td>`;
									for (fkey in lkp_transect_pasture){
										if(lkp_transect_pasture[fkey]['id'] == submitedData[k][field]){
											tableBody += lkp_transect_pasture[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_dry_wet_pasture') {
									tableBody += `<td>`;
									for (fkey in lkp_dry_wet_pasture){
										if(lkp_dry_wet_pasture[fkey]['id'] == submitedData[k][field]){
											tableBody += lkp_dry_wet_pasture[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_transport_means') {
									tableBody += `<td>`;
									for (fkey in lkp_transport_means){
										if(lkp_transport_means[fkey]['transport_id'] == submitedData[k][field]){
											tableBody += lkp_transport_means[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else{
									tableBody += `<td>`;
										tableBody += (submitedData[k][field] == null ? `N/A` : submitedData[k][field] );
									tableBody += `</td>`;
								}

							}
						}
						//lkp_lr_body_condition
						tableBody += `<td>`;
								if(submitedData[k]['lat']){
									tableBody += submitedData[k]['lat'];
								}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['lng']){
									tableBody += submitedData[k]['lng'];
								}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#submited_body').append(tableBody);
						$('#overlay').fadeOut();
						$('#loader').fadeOut();
						
					}
				}else{
					$('#export_sub').addClass('hidden');
					$('#submited_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
					$('#overlay').fadeOut();
					$('#loader').fadeOut();
				}

				// const curentPage = pageNo;
				// const totalRecordsPerPage = recordperpage;
				// const totalRecords= response.total_records;
				// const currentRecords = submitedData.length;
				// pagination.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))
				const totalRecords= response.total_records;
				const currentRecords = submitedData.length;
				let curentPage = pageNo
				let totalRecordsPerPage = recordperpage
				if(pageNo == 1){
					curentPage = submitedData.length === 0 ? 0 : pageNo;
				}
				if(recordperpage == 100){
					totalRecordsPerPage = submitedData.length === 0 ? 0 : recordperpage;
				}
				if(submitedData.length === 0){
					document.getElementById('submited_pagination').style.display = 'none';
				} else{
					document.getElementById('submited_pagination').style.display = 'flex';
					pagination.refreshPagination (Number(curentPage),totalRecords,currentRecords, Number(totalRecordsPerPage))
				}

			}
		});
	}
    function getAprovedDataView(pageNo =1, recordperpage = 100, search_input = null){
		
		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var respondent_id = $('select[name="respondent_id"]').val();
		var start_date=$('input[name="start_date_vsd"]').val();
        var end_date=$('input[name="end_date_vsd"]').val();
		var survey_id = <?php echo $this->uri->segment(3); ?>;
		// var survey_type = "<?php echo $survey_type['type']?>";
		if(survey_type == "Market Task"){
			var respondent_id = $('select[name="market_id"]').val();
		}else if(survey_type == "Rangeland Task" ){
			var respondent_id = $('select[name="pasture_type"]').val();
		}else{
			var respondent_id = $('select[name="respondent_id"]').val();
		}
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			start_date : start_date,
            end_date : end_date,
			survey_id: survey_id,
			survey_type: survey_type,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
		};
		// var imageLoader = `<div class="loaders">
		// 		<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
		// 			<img class="map_icon" src="<?php echo base_url(); ?>include/img/Loader_new.svg" alt="loader">
		// 			<p class="text-color"><strong> Loading...</strong></p>
		// 		</div>
		// 	</div>`;
		// $('#approved_body').html(imageLoader);
		$('#overlay').fadeIn();
        $('#loader').fadeIn();
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_approved_data/<?php echo $this->uri->segment(3); ?>",
			data: query_data,
			type: "POST",
			dataType: "JSON",
			error: function() {
				$('#approved_body').html('<h4 class="text-center">No Data Found</h4>');
			},
			success: function(response) {
				if (response.status == 0) {
					$.toast({
						heading: 'Error!',
						text: response.msg,
						icon: 'error'
					});
					$('#approved_body').html('<h4 class="text-center">No data Found</h4>');
					$('#export_ap').addClass('hidden');
					return false;
				}
				// $('#text_approved_search').removeClass('hidden');
				$('#export_ap').removeClass('hidden');
				var role = response.user_role;
				var fields = response.fields;
				var submitedData = response.submited_data;
				var lkp_country = response.lkp_country;
				var lkp_cluster = response.lkp_cluster;
				var lkp_uai = response.lkp_uai;
				var lkp_sub_location = response.lkp_sub_location;
				var lkp_location_type = response.lkp_location_type;
				var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				var cluster_admin = response.cluster_admin;
				var respondent_name = response.respondent_name;
				var lkp_market = response.lkp_market;
				var lkp_lr_body_condition = response.lkp_lr_body_condition;
				var lkp_sr_body_condition = response.lkp_sr_body_condition;
				var lkp_animal_type = response.lkp_animal_type;
				var lkp_animal_herd_type = response.lkp_animal_herd_type;
				var lkp_food_groups = response.lkp_food_groups;
				var lkp_transect_pasture = response.lkp_transect_pasture;
				var lkp_dry_wet_pasture = response.lkp_dry_wet_pasture;
				var lkp_transport_means = response.lkp_transport_means;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// if ((role == 1 || role == 2)) {
				// 	tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
				// }
				// if (role == 8) {
				// 	tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
					
				// }
				tableHead += `<th>S.No.</th>`;
				// if ((role == 1 || role == 2)) {
				// 	tableHead += `<th>Delete</th>`;
				// }
				if (role == 6) {
					tableHead += `<th>Cluster Verify</th>`;
					// tableHead += `<th>Country Verify</th>`;
				}else{
					tableHead += `<th>Cluster Verify</th>`;
				}
				// tableHead += `<th nowrap>Images</th>`;
				tableHead += `<th nowrap>Contributor</th>`;
				if(survey_id == 5 || survey_id == 7 || survey_id == 11){
					tableHead += `<th nowrap>Market</th>`;
				}else if(survey_id == 9 ){
					tableHead += `<th nowrap>Transect Pastures</th>`;
				}else{
					tableHead += `<th nowrap>Respondent</th><th nowrap>Respondent HHID</th>`;
				}
				tableHead += `<th nowrap>Country</th>`;
				tableHead += `<th nowrap>UAI</th>`;
				tableHead += `<th nowrap>Sub Location</th>`;
				tableHead += `<th nowrap>Cluster</th>`;
				for (const key in fields) {
					const label = fields[key]['label'];
					const type = fields[key]['type'];
					if(label != "Declaration"){
						td_count++;
						if (type == 'kml') {
							if(survey_id == 5){
								tableHead += `<th>`+label+`</th>`;
								tableHead += `<th>KML Details</th>`;
							}else{
								tableHead += `<th>`+label+`</th>`;	
							}
						}else{
							tableHead += `<th>`+label+`</th>`;
						}
					}
				}
				tableHead += `<th>LATITUDE</th><th>LONGITUDE</th><th>Approved By</th><th>Approved On</th>`;
				tableHead += `<th>Uploaded By</th><th>Uploaded Datetime</th>`;

				$('#approved_head').html(tableHead);

				$('#approved_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['data_id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						// if ((role == 1 || role == 2)) {
						// 	tableBody += `<td class="text-center"><input type="checkbox" name="check_sub[]" value="`+submitedData[k]['id']+`"`;
						// 	tableBody += `</td>`;	
						// }
						
						tableBody += `<td>`+ count++ +`</td>`;
						// if ((role == 1 || role == 2)) {
						// 	tableBody += `<td><a href="javascript:void(0);" class="delete_submited text-danger" onClick="deleteRecord(`+submitedData[k]['id']+`);"><i class="fa fa-trash-o"></i></a></td>`;
						// }
						if(role == 6){
							tableBody += `<td class="text-center">`;
							if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
								tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
							}else if(submitedData[k]['pa_verified_status'] == 2){
								tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
							}else{
								tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
							}
							tableBody += `</td>`;
						} else{
							tableBody += `<td class="text-center">`;
							if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
								tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
							}else if(submitedData[k]['pa_verified_status'] == 2){
								tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
							}else{
								tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
							}
							tableBody += `</td>`;
						}
						// tableBody += `<td>`;
						// if(submitedData[k]['images'] != 'N/A'){
						// 	tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k]['images'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
						// }else{
						// 	tableBody += `N/A`;
						// }
						// tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(survey_id == 5 || survey_id == 7 || survey_id == 11){
									if(submitedData[k]['market_id']){
										for (mkey in lkp_market){
											if(lkp_market[mkey]['market_id'] == submitedData[k]['market_id']){
												tableBody += lkp_market[mkey]['name'];
											}
										}
									}else{
										tableBody +="N/A";
									}
									
								}else if(survey_id == 9 ){
									if(submitedData[k]['contributor_name']){
										tableBody += submitedData[k]['contributor_name'];
									}else{
										tableBody +="N/A";
									}
								}else{
									tableBody += submitedData[k]['respondent'];
								}
						tableBody += `</td>`;
						if(survey_id == 3 || survey_id == 4 || survey_id == 6 || survey_id == 8 || survey_id == 10 || survey_id == 12 || survey_id == 13 || survey_id == 14){
							tableBody += `<td>`;
							if(submitedData[k]['hhid']){
											tableBody += submitedData[k]['hhid'];
										}else{
											tableBody +="N/A";
										}
							tableBody += `</td>`;
						}
						tableBody += `<td>`;
							for (ckey in lkp_country){
								if(lkp_country[ckey]['country_id'] == submitedData[k]['country_id']){
									tableBody += lkp_country[ckey]['name'];
								}
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['uai_id']){
							for (uaikey in lkp_uai){
								if(lkp_uai[uaikey]['uai_id'] == submitedData[k]['uai_id']){
									tableBody += lkp_uai[uaikey]['uai'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['sub_location_id']){
							for (ikey in lkp_sub_location){
								if(lkp_sub_location[ikey]['sub_loc_id'] == submitedData[k]['sub_location_id']){
									tableBody += lkp_sub_location[ikey]['location_name'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['cluster_id']){
							for (clkey in lkp_cluster){
								if(lkp_cluster[clkey]['cluster_id'] == submitedData[k]['cluster_id']){
									tableBody += lkp_cluster[clkey]['name'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						
						for (let key = 0; key < fields.length; key++) {
							const label = fields[key]['label'];
							const field = 'field_'+fields[key]['field_id'];
							const type = fields[key]['type'];
							if(label != "Declaration"){
								if (type == 'file') {
									tableBody += `<td>`;
										if(submitedData[k][field] != null){
											
											tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
											
										}else{
											tableBody += 'N/A';
										}
									tableBody += `</td>`;
								}else if (type == 'group') {
									tableBody += `<td><a class="text-primary" target="_blank" href="<?php echo base_url(); ?>reports/groupData/<?php echo $this->uri->segment(3)?>/`+ fields[key]['field_id']+`/`+ submitedData[k]['data_id'] +`">View Data</a></td>`;
								}else if (type == 'lkp_country') {
									tableBody += `<td>`;
										for (ckey in lkp_country){
											if(submitedData[k][field]){
												if(lkp_country[ckey]['country_id'] == submitedData[k][field]){
													tableBody += `<img src="<?php echo base_url(); ?>include/assets/images/${lkp_country[ckey]['name']}-flag.svg">   `+lkp_country[ckey]['name'];
												}
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_cluster') {
									tableBody += `<td>`;
										if(submitedData[k][field]){
											for (clkey in lkp_cluster){
												if(lkp_cluster[clkey]['cluster_id'] == submitedData[k][field]){
													tableBody += lkp_cluster[clkey]['name'];
												}
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_location_type') {
									tableBody += `<td>`;
										for (dskey in lkp_location_type){
											if(lkp_location_type[dskey]['location_id'] == submitedData[k][field]){
												tableBody += lkp_location_type[dskey]['name'];
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_type_lactating') {
									tableBody += `<td>`;
									for (akey in lkp_animal_type_lactating){
										if(lkp_animal_type_lactating[akey]['animal_type_lactating_id'] == submitedData[k][field]){
											tableBody += lkp_animal_type_lactating[akey]['name'];
										}
									}
									tableBody += `</td>`;

								}else if (type == 'lkp_block') {
									tableBody += `<td>`;
									for (bkey in block_list){
										if(submitedData[k][field]){
											if(block_list[bkey]['block_id'] == submitedData[k][field]){
												tableBody += block_list[bkey]['block_name'];
											}
										}
									}
									tableBody += `</td>`;
								}else if (type == 'respondent_name') {
									tableBody += `<td>`;
									for (rkey in respondent_name){
										if(submitedData[k][field]){
											if(respondent_name[rkey]['data_id'] == submitedData[k][field]){
												tableBody += respondent_name[rkey]['first_name']+' '+respondent_name[rkey]['last_name'];
											}
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_grampanchayat') {
									tableBody += `<td>`;
									for (gkey in gn_list){
										if(gn_list[gkey]['grampanchayat_id'] == submitedData[k][field]){
											tableBody += gn_list[gkey]['grampanchayat_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_crop') {
									tableBody += `<td>`;
									for (ckey in crop_list){
										if(crop_list[ckey]['crop_id'] == submitedData[k][field]){
											tableBody += crop_list[ckey]['crop_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_branch_details') {
									tableBody += `<td>`;
									for (let bckey = 0; bckey < branch_list.length; bckey++) {
										if(branch_list[bckey]['branch_id'] == submitedData[k][field]){
											tableBody += branch_list[bckey]['branch_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_farmer_bank_details') {
									tableBody += `<td>`;
									for (let dnkey = 0; dnkey < bank_list.length; dnkey++) {
										const element = bank_list[dnkey];
										if(bank_list[dnkey]['bank_id'] == submitedData[k][field]){
											tableBody += bank_list[dnkey]['bank_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_village') {
									tableBody += `<td>`;
									for (let vkey = 0; vkey < village_list.length; vkey++) {
										if(village_list[vkey]['village_id'] == submitedData[k][field]){
											tableBody += village_list[vkey]['village_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'signature') {
									tableBody += `<td>`;
										if(submitedData[k][field] == 'N/A' || submitedData[k][field] == null){
											tableBody += `N/A`;
										}else{
											tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/user/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;
										}
									tableBody += `</td>`;
								}else if (type == 'kml') {
									if(survey_id == 5){
										tableBody += `<td>`;
										tableBody += (submitedData[k][field] != null ? submitedData[k][field]  : `N/A`);
										tableBody += `</td>`;
										tableBody += `<td>`;
										if(submitedData[k][field+'_kml'] == 'N/A' || submitedData[k][field+'_kml'] == null){
											tableBody += `N/A`;
										}else{
											tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field+'_kml']+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;

											
										}
										tableBody += `</td>`;
									}else{
										tableBody += `<td>`;
										if(submitedData[k][field] != 'N/A'){
											tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field]+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;
										}else{
											tableBody += `N/A`;
										}
										tableBody += `</td>`;
									}
								}else if (type == 'lkp_market') {
									tableBody += `<td>`;
									for (mkey in lkp_market){
										if(lkp_market[mkey]['market_id'] == submitedData[k][field]){
											tableBody += lkp_market[mkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_lr_body_condition') {
									tableBody += `<td>`;
									for (bkey in lkp_lr_body_condition){
										if(lkp_lr_body_condition[bkey]['id'] == submitedData[k][field]){
											tableBody += lkp_lr_body_condition[bkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_sr_body_condition') {
									tableBody += `<td>`;
									for (bkey in lkp_sr_body_condition){
										if(lkp_sr_body_condition[bkey]['id'] == submitedData[k][field]){
											tableBody += lkp_sr_body_condition[bkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_type') {
									tableBody += `<td>`;
									for (akey in lkp_animal_type){
										if(lkp_animal_type[akey]['animal_type_id'] == submitedData[k][field]){
											tableBody += lkp_animal_type[akey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_herd_type') {
									tableBody += `<td>`;
									// for (ahkey in lkp_animal_herd_type){
									// 	if(lkp_animal_herd_type[ahkey]['id'] == submitedData[k][field]){
									// 		tableBody += lkp_animal_herd_type[ahkey]['name'];
									// 	}
									// }
									if(submitedData[k][field]){
											// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
											let checkedValues =(submitedData[k][field]).split('&#44;');
											let output = '';
											for (ahkey in lkp_animal_herd_type){
												for (var i = 0; i < checkedValues.length; i++) {
													if (checkedValues[i] == lkp_animal_herd_type[ahkey]['id']) {
														output += lkp_animal_herd_type[ahkey]['name'] + '<br>';
													}
												}
											}
											tableBody += output;
										}else{
											tableBody +="N/A";
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_food_groups') {
									tableBody += `<td>`;
									if(submitedData[k][field]){
											// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
											let checkedValues =(submitedData[k][field]).split('&#44;');
											let output = '';
											for (fkey in lkp_food_groups){
												for (var i = 0; i < checkedValues.length; i++) {
													if (checkedValues[i] == lkp_food_groups[fkey]['id']) {
														output += lkp_food_groups[fkey]['name'] + '<br>';
													}
												}
											}
											tableBody += output;
										}else{
											tableBody +="N/A";
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_transect_pasture') {
									tableBody += `<td>`;
									for (fkey in lkp_transect_pasture){
										if(lkp_transect_pasture[fkey]['id'] == submitedData[k][field]){
											tableBody += lkp_transect_pasture[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_dry_wet_pasture') {
									tableBody += `<td>`;
									for (fkey in lkp_dry_wet_pasture){
										if(lkp_dry_wet_pasture[fkey]['id'] == submitedData[k][field]){
											tableBody += lkp_dry_wet_pasture[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_transport_means') {
									tableBody += `<td>`;
									for (fkey in lkp_transport_means){
										if(lkp_transport_means[fkey]['transport_id'] == submitedData[k][field]){
											tableBody += lkp_transport_means[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else{
									tableBody += `<td>`;
										tableBody += (submitedData[k][field] == null ? `N/A` : submitedData[k][field] );
									tableBody += `</td>`;
								}

							}
						}
						tableBody += `<td>`;
								if(submitedData[k]['lat']){
									tableBody += submitedData[k]['lat'];
								}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['lng']){
									tableBody += submitedData[k]['lng'];
								}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['pa_verified_by']){
								for(cakey in cluster_admin){
									if(cluster_admin[cakey]['user_id'] == submitedData[k]['pa_verified_by']){
										tableBody += cluster_admin[cakey]['verified_by'];
									}
								}
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pa_verified_date'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#approved_body').append(tableBody);
						$('#overlay').fadeOut();
						$('#loader').fadeOut();
						
					}
				}else{
					$('#approved_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
					$('#export_ap').addClass('hidden');
					$('#overlay').fadeOut();
					$('#loader').fadeOut();
				}

				const curentPage = pageNo;
				const totalRecordsPerPage = recordperpage;
				const totalRecords= response.total_records;
				const currentRecords = submitedData.length;
				pagination1.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))

			}
		});
	}
    function getRejectedDataView(pageNo =1, recordperpage = 100, search_input = null){
		
		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var respondent_id = $('select[name="respondent_id"]').val();
		var start_date=$('input[name="start_date_vsd"]').val();
        var end_date=$('input[name="end_date_vsd"]').val();
		var survey_id = <?php echo $this->uri->segment(3); ?>;
		// var survey_type = "<?php echo $survey_type['type']?>";
		if(survey_type == "Market Task"){
			var respondent_id = $('select[name="market_id"]').val();
		}else if(survey_type == "Rangeland Task" ){
			var respondent_id = $('select[name="pasture_type"]').val();
		}else{
			var respondent_id = $('select[name="respondent_id"]').val();
		}
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			start_date : start_date,
            end_date : end_date,
			survey_id: survey_id,
			survey_type: survey_type,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
		};
		// var imageLoader = `<div class="loaders">
		// 		<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
		// 			<img class="map_icon" src="<?php echo base_url(); ?>include/img/Loader_new.svg" alt="loader">
		// 			<p class="text-color"><strong> Loading...</strong></p>
		// 		</div>
		// 	</div>`;
		// $('#rejected_body').html(imageLoader);
		$('#overlay').fadeIn();
        $('#loader').fadeIn();
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_rejected_data/<?php echo $this->uri->segment(3); ?>",
			data: query_data,
			type: "POST",
			dataType: "JSON",
			error: function() {
				$('#rejected_body').html('<h4 class="text-center">No Data Found</h4>');
			},
			success: function(response) {
				if (response.status == 0) {
					$.toast({
						heading: 'Error!',
						text: response.msg,
						icon: 'error'
					});
					$('#rejected_body').html('<h4 class="text-center">No data Found</h4>');
					$('#export_rej').addClass('hidden');
					return false;
				}
				// $('#text_rejected_search').removeClass('hidden');
				$('#export_rej').removeClass('hidden');
				var role = response.user_role;
				var fields = response.fields;
				var submitedData = response.submited_data;
				var lkp_country = response.lkp_country;
				var lkp_cluster = response.lkp_cluster;
				var lkp_uai = response.lkp_uai;
				var lkp_sub_location = response.lkp_sub_location;
				var lkp_location_type = response.lkp_location_type;
				var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				var cluster_admin = response.cluster_admin;
				var respondent_name = response.respondent_name;
				var lkp_market = response.lkp_market;
				var lkp_lr_body_condition = response.lkp_lr_body_condition;
				var lkp_sr_body_condition = response.lkp_sr_body_condition;
				var lkp_animal_type = response.lkp_animal_type;
				var lkp_animal_herd_type = response.lkp_animal_herd_type;
				var lkp_food_groups = response.lkp_food_groups;
				var lkp_transect_pasture = response.lkp_transect_pasture;
				var lkp_dry_wet_pasture = response.lkp_dry_wet_pasture;
				var lkp_transport_means = response.lkp_transport_means;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// if ((role == 1 || role == 6)) {
				// 	tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
				// }
				tableHead += `<th>S.No.</th>`;
				// if ((role == 1 || role == 2)) {
				// 	tableHead += `<th>Delete</th>`;
				// }
				if (role == 6) {
					tableHead += `<th>Cluster Verify</th>`;
				}else{
					tableHead += `<th>Cluster Verify</th>`;
				}
				// tableHead += `<th nowrap>Images</th>`;
				tableHead += `<th nowrap>Contributor</th>`;
				if(survey_id == 5 || survey_id == 7 || survey_id == 11){
					tableHead += `<th nowrap>Market</th>`;
				}else if(survey_id == 9 ){
					tableHead += `<th nowrap>Transect Pastures</th>`;
				}else{
					tableHead += `<th nowrap>Respondent</th><th nowrap>Respondent HHID</th>`;
				}
				tableHead += `<th nowrap>Country</th>`;
				tableHead += `<th nowrap>UAI</th>`;
				tableHead += `<th nowrap>Sub Location</th>`;
				tableHead += `<th nowrap>Cluster</th>`;
				for (const key in fields) {
					const label = fields[key]['label'];
					const type = fields[key]['type'];
					if(label != "Declaration"){
						td_count++;
						if (type == 'kml') {
							if(survey_id == 5){
								tableHead += `<th>`+label+`</th>`;
								tableHead += `<th>KML Details</th>`;
							}else{
								tableHead += `<th>`+label+`</th>`;	
							}
						}else{
							tableHead += `<th>`+label+`</th>`;
						}
					}
				}
				tableHead += `<th>LATITUDE</th><th>LONGITUDE</th><th>Rejected By</th>`;
				tableHead += `<th>Rejected On</th>`;
				tableHead += `<th>Select Reasons</th>`;
				tableHead += `<th>Uploaded By</th><th>Uploaded Datetime</th>`;

				$('#rejected_head').html(tableHead);

				$('#rejected_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['data_id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						// if ((role == 1 || role == 2)) {
						// 	tableBody += `<td class="text-center"><input type="checkbox" name="check_sub[]" value="`+submitedData[k]['id']+`"`;
						// 	tableBody += `</td>`;	
						// }
						
						tableBody += `<td>`+ count++ +`</td>`;
						// if ((role == 1 || role == 2)) {
						// 	tableBody += `<td><a href="javascript:void(0);" class="delete_submited text-danger" onClick="deleteRecord(`+submitedData[k]['id']+`);"><i class="fa fa-trash-o"></i></a></td>`;
						// }
						if(role == 6){
							tableBody += `<td class="text-center">`;
							if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
								tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
							}else if(submitedData[k]['pa_verified_status'] == 2){
								tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
							}else{
								tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
							}
							tableBody += `</td>`;
						} else{
							tableBody += `<td class="text-center">`;
							if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
								tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
							}else if(submitedData[k]['pa_verified_status'] == 2){
								tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
							}else{
								tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
							}
							tableBody += `</td>`;
							
						}
						// tableBody += `<td>`;
						// if(submitedData[k]['images'] != 'N/A'){
						// 	tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k]['images'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
						// }else{
						// 	tableBody += `N/A`;
						// }
						// tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(survey_id == 5 || survey_id == 7 || survey_id == 11){
									if(submitedData[k]['market_id']){
										for (mkey in lkp_market){
											if(lkp_market[mkey]['market_id'] == submitedData[k]['market_id']){
												tableBody += lkp_market[mkey]['name'];
											}
										}
									}else{
										tableBody +="N/A";
									}
									
								}else if(survey_id == 9 ){
									if(submitedData[k]['contributor_name']){
										tableBody += submitedData[k]['contributor_name'];
									}else{
										tableBody +="N/A";
									}
								}else{
									tableBody += submitedData[k]['respondent'];
								}
						tableBody += `</td>`;
						if(survey_id == 3 || survey_id == 4 || survey_id == 6 || survey_id == 8 || survey_id == 10 || survey_id == 12 || survey_id == 13 || survey_id == 14){
							tableBody += `<td>`;
							if(submitedData[k]['hhid']){
											tableBody += submitedData[k]['hhid'];
										}else{
											tableBody +="N/A";
										}
							tableBody += `</td>`;
						}
						tableBody += `<td>`;
							for (ckey in lkp_country){
								if(lkp_country[ckey]['country_id'] == submitedData[k]['country_id']){
									tableBody += lkp_country[ckey]['name'];
								}
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['uai_id']){
							for (uaikey in lkp_uai){
								if(lkp_uai[uaikey]['uai_id'] == submitedData[k]['uai_id']){
									tableBody += lkp_uai[uaikey]['uai'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['sub_location_id']){
							for (ikey in lkp_sub_location){
								if(lkp_sub_location[ikey]['sub_loc_id'] == submitedData[k]['sub_location_id']){
									tableBody += lkp_sub_location[ikey]['location_name'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['cluster_id']){
							for (clkey in lkp_cluster){
								if(lkp_cluster[clkey]['cluster_id'] == submitedData[k]['cluster_id']){
									tableBody += lkp_cluster[clkey]['name'];
								}
							}
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						for (let key = 0; key < fields.length; key++) {
							const label = fields[key]['label'];
							const field = 'field_'+fields[key]['field_id'];
							const type = fields[key]['type'];
							if(label != "Declaration"){
								if (type == 'file') {
									tableBody += `<td>`;
										if(submitedData[k][field] != null){
											
											tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
											
										}else{
											tableBody += 'N/A';
										}
									tableBody += `</td>`;
								}else if (type == 'group') {
									tableBody += `<td><a class="text-primary" target="_blank" href="<?php echo base_url(); ?>reports/groupData/<?php echo $this->uri->segment(3)?>/`+ fields[key]['field_id']+`/`+ submitedData[k]['data_id'] +`">View Data</a></td>`;
								}else if (type == 'lkp_country') {
									tableBody += `<td>`;
										for (ckey in lkp_country){
											if(submitedData[k][field]){
												if(lkp_country[ckey]['country_id'] == submitedData[k][field]){
													tableBody += `<img src="<?php echo base_url(); ?>include/assets/images/${lkp_country[ckey]['name']}-flag.svg">   `+lkp_country[ckey]['name'];
												}
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_cluster') {
									tableBody += `<td>`;
										if(submitedData[k][field]){
											for (clkey in lkp_cluster){
												if(lkp_cluster[clkey]['cluster_id'] == submitedData[k][field]){
													tableBody += lkp_cluster[clkey]['name'];
												}
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_location_type') {
									tableBody += `<td>`;
										for (dskey in lkp_location_type){
											if(lkp_location_type[dskey]['location_id'] == submitedData[k][field]){
												tableBody += lkp_location_type[dskey]['name'];
											}
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_type_lactating') {
									tableBody += `<td>`;
									for (akey in lkp_animal_type_lactating){
										if(lkp_animal_type_lactating[akey]['animal_type_lactating_id'] == submitedData[k][field]){
											tableBody += lkp_animal_type_lactating[akey]['name'];
										}
									}
									tableBody += `</td>`;

								}else if (type == 'lkp_block') {
									tableBody += `<td>`;
									for (bkey in block_list){
										if(submitedData[k][field]){
											if(block_list[bkey]['block_id'] == submitedData[k][field]){
												tableBody += block_list[bkey]['block_name'];
											}
										}
									}
									tableBody += `</td>`;
								}else if (type == 'respondent_name') {
									tableBody += `<td>`;
									for (rkey in respondent_name){
										if(submitedData[k][field]){
											if(respondent_name[rkey]['data_id'] == submitedData[k][field]){
												tableBody += respondent_name[rkey]['first_name']+' '+respondent_name[rkey]['last_name'];
											}
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_grampanchayat') {
									tableBody += `<td>`;
									for (gkey in gn_list){
										if(gn_list[gkey]['grampanchayat_id'] == submitedData[k][field]){
											tableBody += gn_list[gkey]['grampanchayat_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_crop') {
									tableBody += `<td>`;
									for (ckey in crop_list){
										if(crop_list[ckey]['crop_id'] == submitedData[k][field]){
											tableBody += crop_list[ckey]['crop_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_branch_details') {
									tableBody += `<td>`;
									for (let bckey = 0; bckey < branch_list.length; bckey++) {
										if(branch_list[bckey]['branch_id'] == submitedData[k][field]){
											tableBody += branch_list[bckey]['branch_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_farmer_bank_details') {
									tableBody += `<td>`;
									for (let dnkey = 0; dnkey < bank_list.length; dnkey++) {
										const element = bank_list[dnkey];
										if(bank_list[dnkey]['bank_id'] == submitedData[k][field]){
											tableBody += bank_list[dnkey]['bank_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_village') {
									tableBody += `<td>`;
									for (let vkey = 0; vkey < village_list.length; vkey++) {
										if(village_list[vkey]['village_id'] == submitedData[k][field]){
											tableBody += village_list[vkey]['village_name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'signature') {
									tableBody += `<td>`;
										if(submitedData[k][field] == 'N/A' || submitedData[k][field] == null){
											tableBody += `N/A`;
										}else{
											tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;
										}
									tableBody += `</td>`;
								}else if (type == 'kml') {
									if(survey_id == 5){
										tableBody += `<td>`;
										tableBody += (submitedData[k][field] != null ? submitedData[k][field]  : `N/A`);
										tableBody += `</td>`;
										tableBody += `<td>`;
										if(submitedData[k][field+'_kml'] == 'N/A' || submitedData[k][field+'_kml'] == null){
											tableBody += `N/A`;
										}else{
											tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field+'_kml']+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;

											
										}
										tableBody += `</td>`;
									}else{
										tableBody += `<td>`;
										if(submitedData[k][field] != 'N/A'){
											tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field]+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;
										}else{
											tableBody += `N/A`;
										}
										tableBody += `</td>`;
									}
								}else if (type == 'lkp_market') {
									tableBody += `<td>`;
									for (mkey in lkp_market){
										if(lkp_market[mkey]['market_id'] == submitedData[k][field]){
											tableBody += lkp_market[mkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_lr_body_condition') {
									tableBody += `<td>`;
									for (bkey in lkp_lr_body_condition){
										if(lkp_lr_body_condition[bkey]['id'] == submitedData[k][field]){
											tableBody += lkp_lr_body_condition[bkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_sr_body_condition') {
									tableBody += `<td>`;
									for (bkey in lkp_sr_body_condition){
										if(lkp_sr_body_condition[bkey]['id'] == submitedData[k][field]){
											tableBody += lkp_sr_body_condition[bkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_type') {
									tableBody += `<td>`;
									for (akey in lkp_animal_type){
										if(lkp_animal_type[akey]['animal_type_id'] == submitedData[k][field]){
											tableBody += lkp_animal_type[akey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_animal_herd_type') {
									tableBody += `<td>`;
									// for (ahkey in lkp_animal_herd_type){
									// 	if(lkp_animal_herd_type[ahkey]['id'] == submitedData[k][field]){
									// 		tableBody += lkp_animal_herd_type[ahkey]['name'];
									// 	}
									// }
										if(submitedData[k][field]){
											// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
											let checkedValues =(submitedData[k][field]).split('&#44;');
											let output = '';
											for (ahkey in lkp_animal_herd_type){
												for (var i = 0; i < checkedValues.length; i++) {
													if (checkedValues[i] == lkp_animal_herd_type[ahkey]['id']) {
														output += lkp_animal_herd_type[ahkey]['name'] + '<br>';
													}
												}
											}
											tableBody += output;
										}else{
											tableBody +="N/A";
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_food_groups') {
									tableBody += `<td>`;
										if(submitedData[k][field]){
											// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
											let checkedValues =(submitedData[k][field]).split('&#44;');
											let output = '';
											for (fkey in lkp_food_groups){
												for (var i = 0; i < checkedValues.length; i++) {
													if (checkedValues[i] == lkp_food_groups[fkey]['id']) {
														output += lkp_food_groups[fkey]['name'] + '<br>';
													}
												}
											}
											tableBody += output;
										}else{
											tableBody +="N/A";
										}
									tableBody += `</td>`;
								}else if (type == 'lkp_transect_pasture') {
									tableBody += `<td>`;
									for (fkey in lkp_transect_pasture){
										if(lkp_transect_pasture[fkey]['id'] == submitedData[k][field]){
											tableBody += lkp_transect_pasture[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_dry_wet_pasture') {
									tableBody += `<td>`;
									for (fkey in lkp_dry_wet_pasture){
										if(lkp_dry_wet_pasture[fkey]['id'] == submitedData[k][field]){
											tableBody += lkp_dry_wet_pasture[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else if (type == 'lkp_transport_means') {
									tableBody += `<td>`;
									for (fkey in lkp_transport_means){
										if(lkp_transport_means[fkey]['transport_id'] == submitedData[k][field]){
											tableBody += lkp_transport_means[fkey]['name'];
										}
									}
									tableBody += `</td>`;
								}else{
									tableBody += `<td>`;
										tableBody += (submitedData[k][field] == null ? `N/A` : submitedData[k][field] );
									tableBody += `</td>`;
								}

							}
						}
						tableBody += `<td>`;
								if(submitedData[k]['lat']){
									tableBody += submitedData[k]['lat'];
								}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['lng']){
									tableBody += submitedData[k]['lng'];
								}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['pa_verified_by']){
								for(cakey in cluster_admin){
									if(cluster_admin[cakey]['user_id'] == submitedData[k]['pa_verified_by']){
										tableBody += cluster_admin[cakey]['verified_by'];
									}
								}
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pa_verified_date'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['rejected_remarks'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#rejected_body').append(tableBody);
						
					}
				}else{
					$('#rejected_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
					$('#export_rej').addClass('hidden');
				}
				$('#overlay').fadeOut();
				$('#loader').fadeOut();
				const curentPage = pageNo;
				const totalRecordsPerPage = recordperpage;
				const totalRecords= response.total_records;
				const currentRecords = submitedData.length;
				pagination2.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))

			}
		});
	}

	

    const onPagination = (event) => { 
		var keywords = $('#user_submit_search').val();
		getSubmitedDataView(+event.currentPage,+event.recordsPerPage,keywords);
		
  	}
	  function searchSumitedFilter() {
		var keywords = $('#user_submit_search').val();
		getSubmitedDataView(1, 100, keywords);
	}
	const onPagination1 = (event) => { 
		var keywords1 = $('#user_approved_search').val();
		getAprovedDataView(+event.currentPage,+event.recordsPerPage,keywords1);
	
  	}
	function searchApprovedFilter() {
		var keywords1 = $('#user_approved_search').val();
		getAprovedDataView(1, 100, keywords1);
	}
	
	const onPagination2 = (event) => { 
		var keywords2 = $('#user_rejected_search').val();
		getRejectedDataView(+event.currentPage,+event.recordsPerPage,keywords2);
  	}

	  function searchRejectedFilter() {
		var keywords2 = $('#user_rejected_search').val();
		getRejectedDataView(1, 100, keywords2);
	}
	  
	
	const pagination = new Pagination('#submited_pagination',onPagination);
	const pagination1 = new Pagination('#approved_pagination',onPagination1);
	const pagination2 = new Pagination('#rejected_pagination',onPagination2);
</script>
<!-- filters dependency -->
<script>
	var loginrole=<?php echo $this->session->userdata('role')?>;

	$('.reset').on('click', function(){
		location.reload();
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
	});
	 $('#country_id').on('change', function(){
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
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
				$('#Submitted-tab').removeClass("disabledTab");
				$('#Approved-tab').removeClass("disabledTab");
				$('#Rejected-tab').removeClass("disabledTab");
				//get contributor List
				$.ajax('<?=base_url()?>reports/getContributorByCountry', {
					type: 'POST',  // http method
					data: { country_id: country_id },  // data to submit
					success: function (data) {
						$('#contributor_id').html(data);
					}
				});
				if(survey_type=="Market Task"){
					$.ajax('<?=base_url()?>reports/getMarketsByCountry', {
						type: 'POST',  // http method
						data: { country_id: country_id },  // data to submit
						success: function (data) {
							$('#market_id').html(data);
						}
					});
				}
            }
			$('#sub_location_id').html('<option value="">Select Sub Location</option>');
			$('#respondent_id').html('<option value="">Select Respondent</option>');
        }else{
			$('.get_data').css("background-color","rgb(147, 148, 150)");
			$('.get_data').prop("disabled",true);
            $('#cluster_id').html('<option value="">Select Cluster</option>');
            $('#uai_id').html('<option value="">Select UAI</option>');
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
            $('#Submitted-tab').addClass("disabledTab");
			$('#Approved-tab').addClass("disabledTab");
			$('#Rejected-tab').addClass("disabledTab");
        }   
    });
	 $('#cluster_id').on('change', function(){
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
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
			$('#respondent_id').html('<option value="">Select Respondent</option>');
        } 
		else{
			$('#country_id').trigger('change');
			var country_id = $('#country_id').val();
			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id').html(data);
                }
            });
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
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
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
					$('#cluster_id').html('<option value="">Select Cluster</option>');
                }
            });
			if(survey_type=="Market Task"){
				$.ajax('<?=base_url()?>reports/getMarketsByUai', {
					type: 'POST',  // http method
					data: { uai_id: uai_id },  // data to submit
					success: function (data) {
						$('#market_id').html(data);
					}
				});
			}
			if(loginrole==1){
                //get contributor List
				$.ajax('<?=base_url()?>reports/getContributorByUAI', {
					type: 'POST',  // http method
					data: { uai_id: uai_id },  // data to submit
					success: function (data) {
						$('#contributor_id').html(data);
					}
				});
            }
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        } 
		else{
			$('#country_id').trigger('change');
			var country_id = $('#country_id').val();
			$.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id').html(data);
                }
            });
			if(survey_type=="Market Task"){
				$.ajax('<?=base_url()?>reports/getMarketsByCountry', {
					type: 'POST',  // http method
					data: { country_id: country_id },  // data to submit
					success: function (data) {
						$('#market_id').html(data);
					}
				});
			}
			if(loginrole==1){
                //get contributor List
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
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
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
			$('#respondent_id').html('<option value="">Select Respondent</option>');
        } 
		else{
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });
	$('#contributor_id').on('change', function(){
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
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
</script>
<!-- map view section -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
<script>
	// $('#mapview-tab').on('click', function(){
	// 	setTimeout(function(){ 
	// 		map.invalidateSize()
	// 	}, 500);
	// })
		
    //     var addressPoints = [
    //         [-1.286389, 36.817223, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [0.569525, 34.558376, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [-0.091702, 34.767956, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [1.019089, 35.002304, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [-4.043740, 39.658871, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [0.514277, 35.269779, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [-3.219186, 40.116890, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
    //         [-0.717178, 36.431026, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
           
    //     ];

    //     var map = L.map('map').setView([0.569525, 34.558376], 5);

    //     L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    //         attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    //     }).addTo(map);

    //     var markers = L.markerClusterGroup();

    //     for (var i = 0; i < addressPoints.length; i++) {
    //         var a = addressPoints[i];
    //         var title = a[2];
    //         var marker = L.marker(new L.LatLng(a[0], a[1]), {
    //             // title: title
    //         });
    //         marker.bindPopup(title);
    //         markers.addLayer(marker);
    //     }

    //     map.addLayer(markers);
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
<script>
	//Handle checkall on click
	$('body').on('change', '.checkall_sub', function(event) {
		var elem = $(this);

		if (elem.is(":checked")) {
			$('body').find('[name="check_sub[]"]').filter(function () {
                return !this.disabled
            }).prop('checked', true);
			var totalChecked = $('body').find('[name="check_sub[]"]:checked').length;
			if (totalChecked > 0) {
				$('.delete, .verify').removeClass('hidden');
			} else {
				$('.delete, .verify').addClass('hidden');
				$('body').find('[class="checkall_sub"]').prop('checked', false);
			}
		} else {
			$('.delete, .verify').addClass('hidden');
			$('body').find('[name="check_sub[]"]').prop('checked', false);
		}
	});
	//Handle check on change
	$('body').on('change', '[name="check_sub[]"]', function(event) {
		var totalChecked = $('body').find('[name="check_sub[]"]:checked').length;
		if (totalChecked > 0) {
			$('.delete, .verify').removeClass('hidden');
		} else {
			$('.delete, .verify').addClass('hidden');
		}
	});

	//Handle verify button click
	$('body').on('click', 'button.verify', function(event) {
		var elem = $(this),
			status = elem.data('status');

		var formData = new FormData($('#moderateVerifyDataForm')[0]);
		formData.append('status', elem.data('status'));
		$('body').find('button.verify').prop('disabled', true);
		if(status == 3){
			// Swal.fire({
			// 	title: "Are you sure you want to reject?",
			// 	type: "warning!",
			// 	text: "Remarks for Rejection",
            //     input: "select",
            //     inputOptions: {
            //         'Poor Picture Quality': 'Poor Picture Quality',
            //         'Wrong location': 'Wrong location',
            //         'Value out of range': 'Value out of range',
			// 		'Others': 'Others'
            //     },
			// 	showCancelButton: true,
			// 	confirmButtonClass: "btn-danger",
			// 	confirmButtonColor: '#fa2428',
			// 	confirmButtonText: "Yes, Reject!",
			// 	closeOnConfirm: false,
			// 	inputEvent: "change", // Listen for changes in the input value
			// 	didOpen: function(input) {
			// 		// Create an input event listener
			// 		input.addEventListener("change", function() {
			// 			const selectedOption = input.value;

			// 			// Check if Option 2 is selected and show/hide the text input
			// 			if (selectedOption === "Others") {
			// 			// Create and append a text input below the select input
			// 			const textInput = document.createElement("input");
			// 			textInput.type = "text";
			// 			textInput.placeholder = "Enter something...";
			// 			Swal.getInput().parentElement.appendChild(textInput);
			// 			} else {
			// 			// Remove the text input if it's present
			// 			const textInput = Swal.getInput("text");
			// 			if (textInput) {
			// 				textInput.parentElement.removeChild(textInput);
			// 			}
			// 			}
			// 		});
			// 	},
			// 	inputPlaceholder: "Select Reason",
			// 	validationMessage : "Select a Reason",
			// 	preConfirm: (value) => {
			// 		return new Promise((res,rej)=> res(value))
			// 		.then(response => {
			// 			console.log(response);
			// 			if (!response) {
			// 			throw new Error("please provide reason")
			// 			}
			// 			return response
			// 		})
			// 		.catch(error => {
			// 			Swal.showValidationMessage(`${error}`)
			// 		})
			// 	}
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         // User clicked Confirm
			// 		if(result.value){
						
			// 			formData.append('rejected_remarks', result.value);
			// 			verifyData(formData, status);
						
			// 		}else{
			// 			Swal.showValidationError("error");
			// 		}
					
            //     } else {
            //         // User clicked Cancel
			// 		$('body').find('button.verify').prop('disabled', false)
            //     }
            // });
			
				Swal.fire({
					title: "Are you sure you want to reject?",
					type: "warning!",
					text: "Remarks for Rejection",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonColor: '#fa2428',
					confirmButtonText: "Yes, Reject!",
					closeOnConfirm: false,
					html:
					'Remarks for Rejection :<select id="option-select" class="swal2-input">' +
						'<option value="">Select remark for rejection</option>' +
						'<option value="Poor Picture Quality">Poor Picture Quality</option>' +
						'<option value="Wrong location">Wrong location</option>' +
						'<option value="Value out of range">Value out of range</option>' +
						'<option value="other">Other</option>' +
					'</select>' +
					'<div id="text-box-container" style="display:none;">' +
						'<input id="text-box" class="swal2-input" placeholder="Specify the details">' +
					'</div>',
					didOpen: () => {
						const optionSelect = document.getElementById('option-select');
						const textBoxContainer = document.getElementById('text-box-container');
						const textBox = document.getElementById('text-box');

						optionSelect.addEventListener('change', () => {
							Swal.resetValidationMessage();
							if (optionSelect.value === 'other') {
								textBoxContainer.style.display = 'block';
							} else {
								textBoxContainer.style.display = 'none';
							}
						});
					},
					inputPlaceholder: "Select Reason",
					validationMessage : "Select a Reason",
					preConfirm: () => {
						return new Promise((res,rej)=> res())
						.then(response => {
							
							if (!document.getElementById('option-select').value) {
								throw new Error("please select one Remark for Rejection")
							}else{
								if(document.getElementById('option-select').value =='other'){
									if (!document.getElementById('text-box').value) {
										throw new Error("Please specify the details")
									}
								}
							}
							// return response
							if(document.getElementById('option-select').value == 'other'){
								return document.getElementById('text-box').value
							}else{
								return document.getElementById('option-select').value
							}
						})
						.catch(error => {
							Swal.showValidationMessage(`${error}`)
						})
					}
				}).then((result) => {
					if (result.isConfirmed) {
						// User clicked Confirm
						if(result.value){
							
							formData.append('rejected_remarks', result.value);
							verifyData(formData, status);
							
						}else{
							Swal.showValidationError("error");
						}
						
					} else {
						// User clicked Cancel
						$('body').find('button.verify').prop('disabled', false)
					}
				});		
			
		}else{
			verifyData(formData, status);
		}
	});
	// $this->uri->segment(3)
	function verifyData(formData, status) {
		$.ajax({
			url: '<?php echo base_url(); ?>reports/verify_data/<?php echo $this->uri->segment(3); ?>',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			error: function() {
				$('body').find('button.verify').prop('disabled', false);
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success: function(data) {
				var data = JSON.parse(data);

				// If session error exists
				if (data.session_err == 1) {
					$.toast({
						heading: 'Session Error!',
						text: data.msg,
						icon: 'error'
					});
					$('body').find('button.verify').prop('disabled', false);
				}

				if (data.status == 1) {
					// If update completed
					$.toast({
						heading: 'Success!',
						text: data.msg,
						icon: 'success',
						afterHidden: function() {
							$('body').find('button.verify').prop('disabled', false);

							var verifyText = '';
							if (status == 2) verifyText = '<i class="fa fa-2x fa-check-square-o text-success"></i>';
							if (status == 3) verifyText = '<i class="fa fa-2x fa-times text-danger"></i>';

							if (data.verified_role == 6) {
								$('body').find('[name="check_sub[]"]:checked').each(function(index) {
									$(this).parent().next().next().html(data.verified_by + " " + verifyText);
									$(this).trigger('click');
								});
							}
							if (data.verified_role == 7) {
								$('body').find('[name="check_sub[]"]:checked').each(function(index) {
									// $(this).parent().next().next().html(verifyText);
									$(this).parent().next().next().next().html(data.verified_by + " " + verifyText);
									$(this).trigger('click');
								});
							} else {
								$('body').find('[name="check_sub[]"]:checked').each(function(index) {
									$(this).parent().next().next().next().html(data.verified_by + " " + verifyText);
									$(this).trigger('click');
								});
							}
						}
					});
				} else if (data.status == 0) {
					$.toast({
						heading: 'Error!',
						text: data.msg,
						icon: 'error'
					});
					$('body').find('button.verify').prop('disabled', false);
				}
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
	
	function exportXcel(event) {
		$('#overlay').fadeIn();
        $('#loader').fadeIn();
		var button = event.target;
    	var dataValue = button.getAttribute('data-tabvalue');
		switch (dataValue) {
			case "1":
				$("#export_sub").prop('disabled', true);
				$("#export_sub").html("Please wait ...");
				break;
			case "2":
				$("#export_ap").prop('disabled', true);
				$("#export_ap").html("Please wait ...");
				break;
			case "3":
				$("#export_rej").prop('disabled', true);
				$("#export_rej").html("Please wait ...");
				break;
		
			default:
				break;
		}

		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var respondent_id = $('select[name="respondent_id"]').val();
		var start_date=$('input[name="start_date_vsd"]').val();
        var end_date=$('input[name="end_date_vsd"]').val();
		var survey_id = <?php echo $this->uri->segment(3); ?>;
		if(survey_type == "Market Task"){
			var respondent_id = $('select[name="market_id"]').val();
		}else if(survey_type == "Rangeland Task" ){
			var respondent_id = $('select[name="pasture_type"]').val();
		}else{
			var respondent_id = $('select[name="respondent_id"]').val();
		}
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			start_date : start_date,
            end_date : end_date,
			survey_id: survey_id,
			survey_type: survey_type,
			pa_verified_status:dataValue,
			pagination:null
		};
		
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_submited_data_export/<?php echo $this->uri->segment(3); ?>",
			data: query_data,
			type: "POST",
			dataType: "JSON",
			error: function(response) {
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
				var submitedData = response.submited_data;
				var lkp_country = response.lkp_country;
				var lkp_cluster = response.lkp_cluster;
				var lkp_uai = response.lkp_uai;
				var lkp_sub_location = response.lkp_sub_location;
				var lkp_location_type = response.lkp_location_type;
				var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				var respondent_name = response.respondent_name;
				var lkp_market = response.lkp_market;
				var lkp_transect_pastures = response.lkp_transect_pasture;
				var lkp_lr_body_condition = response.lkp_lr_body_condition;
				var lkp_sr_body_condition = response.lkp_sr_body_condition;
				var lkp_animal_type = response.lkp_animal_type;
				var lkp_animal_herd_type = response.lkp_animal_herd_type;
				var lkp_food_groups = response.lkp_food_groups;
				var lkp_transect_pasture = response.lkp_transect_pasture;
				var lkp_dry_wet_pasture = response.lkp_dry_wet_pasture;
				var lkp_transport_means = response.lkp_transport_means;

				// var myArray = $.makeArray({ foo: "bar", hello: "world
				var verified_list = $.makeArray({"1":"Submitted","2":"Approved","3":"Rejected"});
				const lkpData = {};
				const imageData = {};
				const lkpDataMultiple = {};

				const countries = {};
				for (let sid = 0; sid < lkp_country.length; sid++) {
					const element = lkp_country[sid];
					countries[element.country_id] = element.name;
				}
				const uais = {};
				for (let uaiid = 0; uaiid < lkp_uai.length; uaiid++) {
					const element = lkp_uai[uaiid];
					uais[element.uai_id] = element.uai;
				}
				const subLocations = {};
				for (let dsid = 0; dsid < lkp_sub_location.length; dsid++) {
					const element = lkp_sub_location[dsid];
					subLocations[element.sub_loc_id] = element.location_name;
				}
				const clusters = {};
				for (let cid = 0; cid < lkp_cluster.length; cid++) {
					const element = lkp_cluster[cid];
					clusters[element.cluster_id] = element.name;
				}

				const locationtypes = {};
				for (let bk = 0; bk < lkp_location_type.length; bk++) {
					const element = lkp_location_type[bk];
					locationtypes[element.location_id] = element.name;
				}
				const markets = {};
				for (let gn = 0; gn < lkp_market.length; gn++) {
					const element = lkp_market[gn];
					markets[element.market_id] = element.name;
				}
				const animaltypelactatings = {};
				for (let vkey = 0; vkey < lkp_animal_type_lactating.length; vkey++) {
					const element = lkp_animal_type_lactating[vkey];
					animaltypelactatings[element.animal_type_lactating_id] = element.name;
				}
				
				const lrBodyConditions = {};
				for (let cp = 0; cp < lkp_lr_body_condition.length; cp++) {
					const element = lkp_lr_body_condition[cp];
					lrBodyConditions[element.id] = element.name;
				}
				const srBodyConditions = {};
				for (let cp = 0; cp < lkp_sr_body_condition.length; cp++) {
					const element = lkp_sr_body_condition[cp];
					srBodyConditions[element.id] = element.name;
				}
				const animalTypes = {};
				for (let cp = 0; cp < lkp_animal_type.length; cp++) {
					const element = lkp_animal_type[cp];
					animalTypes[element.animal_type_id] = element.name;
				}
				const animalHerdTypes = {};
				for (let cp = 0; cp < lkp_animal_herd_type.length; cp++) {
					const element = lkp_animal_herd_type[cp];
					animalHerdTypes[element.id] = element.name;
				}
				const foodGroups = {};
				for (let cp = 0; cp < lkp_food_groups.length; cp++) {
					const element = lkp_food_groups[cp];
					foodGroups[element.id] = element.name;
				}
				const transectPastures = {};
				for (let cp = 0; cp < lkp_transect_pasture.length; cp++) {
					const element = lkp_transect_pasture[cp];
					transectPastures[element.id] = element.name;
				}
				const dryWetPastures = {};
				for (let cp = 0; cp < lkp_dry_wet_pasture.length; cp++) {
					const element = lkp_dry_wet_pasture[cp];
					dryWetPastures[element.id] = element.name;
				}
				const transportMeans = {};
				for (let cp = 0; cp < lkp_transport_means.length; cp++) {
					const element = lkp_transport_means[cp];
					transportMeans[element.transport_id] = element.name;
				}

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
				xcelHeader.push("Contributor")
				tableHeaderFields.push('first_name')
				if(survey_id == 5 || survey_id == 7 || survey_id == 11){
					xcelHeader.push("Market")
					tableHeaderFields.push('market_name')
				}else if(survey_id == 9 ){
					xcelHeader.push("Transect Pastures")
					tableHeaderFields.push('contributor_name')
				}else{
					xcelHeader.push("Respondent")
					xcelHeader.push("Respondent HHID")
					tableHeaderFields.push('respondent')
					tableHeaderFields.push('hhid')
				}

				
				xcelHeader.push(...['Country','UAI','Sub Location','Cluster']);
				tableHeaderFields.push(...['country_id','uai_id','sub_location_id','cluster_id']);
				
				for (const key in fields) {
					const label = fields[key]['label'];
					const type = fields[key]['type'];
					const subtype = fields[key]['subtype'];
					if(type?.startsWith('lkp_') ){
						if(type == 'lkp_country'){
							lkpData['field_'+fields[key]['field_id']] = countries;
						}else if(type == 'lkp_uai'){
							lkpData['field_'+fields[key]['field_id']] = uais;
						}else if(type == 'lkp_sub_location'){
							lkpData['field_'+fields[key]['field_id']] = subLocations;
						}else if(type == 'lkp_cluster'){
							lkpData['field_'+fields[key]['field_id']] = clusters;
						}else if(type == 'lkp_location_type'){
							lkpData['field_'+fields[key]['field_id']] = locationtypes;
						}else if(type == 'lkp_market'){
							lkpData['field_'+fields[key]['field_id']] = markets;
						}else if(type == 'lkp_animal_type_lactating'){
							lkpData['field_'+fields[key]['field_id']] = animaltypelactatings;
							lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
						}else if(type == 'lkp_lr_body_condition'){
							lkpData['field_'+fields[key]['field_id']] = lrBodyConditions;
						}else if(type == 'lkp_sr_body_condition'){
							lkpData['field_'+fields[key]['field_id']] = srBodyConditions;
						}else if(type == 'lkp_animal_type'){
							lkpData['field_'+fields[key]['field_id']] = animalTypes;
							lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
						}else if(type == 'lkp_animal_herd_type'){
							lkpData['field_'+fields[key]['field_id']] = animalHerdTypes;
							lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
						}else if(type == 'lkp_food_groups'){
							lkpData['field_'+fields[key]['field_id']] = foodGroups;
							lkpDataMultiple['field_'+fields[key]['field_id']] ="Multiple";
						}else if(type == 'lkp_transect_pasture'){
							lkpData['field_'+fields[key]['field_id']] = transectPastures;
						}else if(type == 'lkp_dry_wet_pasture'){
							lkpData['field_'+fields[key]['field_id']] = dryWetPastures;
						}else if(type == 'lkp_transport_means'){
							lkpData['field_'+fields[key]['field_id']] = transportMeans;
						}else if(type == 'lkp_branch_details'){
							lkpData['field_'+fields[key]['field_id']] = branchs;
						}else if(type == 'lkp_farmer_bank_details'){
							lkpData['field_'+fields[key]['field_id']] = banks;
						}
					}
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
				xcelHeader.push(...['Latitude','Longitude','Uploaded By','Uploaded Datetime','Verification status']);
				tableHeaderFields.push(...['lat','lng','first_name','datetime','pa_verified_status']);


				if(submitedData.length > 0){
					const xcelBody = [];
					// var tableBody ="";
					
					for (let i=0; i<submitedData.length; i++){
						const elemnt = submitedData[i];
						const row = [];
						elemnt.sno = i+1;
						elemnt.country_id = countries[elemnt.country_id] || elemnt.country_id || "N/A";
						elemnt.uai_id = uais[elemnt.uai_id] || elemnt.uai_id || "N/A";
						elemnt.sub_location_id = subLocations[elemnt.sub_location_id] || elemnt.sub_location_id || "N/A";
						elemnt.cluster_id = clusters[elemnt.cluster_id] || elemnt.cluster_id || "N/A";
						elemnt.pa_verified_status = verified_list[0][elemnt.pa_verified_status] || elemnt.pa_verified_status || "N/A";
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
									row.push(elemnt[key] || elemnt[key] || 'N/A');
								}
							}
						}
						xcelBody.push(row);
					}
					xcelData.push(xcelHeader)
					xcelData.push(...xcelBody)
					exportToXcel(response.title, xcelData);
					// $("#export_sub").prop('disabled', false);
                	// $("#export_sub").html("Export data");
					
				}else{
					// comment
				}
				$('#overlay').fadeOut();
				$('#loader').fadeOut();	
				switch (dataValue) {
					case "1":
						$("#export_sub").prop('disabled', false);
						$("#export_sub").html("Export data");
						break;
					case "2":
						$("#export_ap").prop('disabled', false);
						$("#export_ap").html("Export data");
						break;
					case "3":
						$("#export_rej").prop('disabled', false);
						$("#export_rej").html("Export data");
						break;
				
					default:
						break;
				}
			}
		});
			
	}
</script>