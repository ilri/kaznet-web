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
	.disabledTab{
		pointer-events: none;
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
   
</style>
   <div class="container-fluid">
        <div class="row">
			<?php 
				$survey_name = "Contributor profile";
				?>
            <div class="col-sm-12 col-md-12 col-lg-12 ">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Survey Data</a></li>
                        <li class="breadcrumb-item active"><?php echo($survey_name); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <!-- <h4 class="title"><?php echo($survey_name); ?></h4> -->
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
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Respondent</label>
                                            <select class="form-control" id="respondent_id" name="respondent_id">
                                                <option value="">Select Respondent</option>
                                            </select>
                                        </div>
                                    </div>
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

            <div class="col-sm-12 col-md-12 col-lg-12 text-right my-3 hidden">
                <div class="nav nav-tabs border-0 justify-content-end" id="myTab" role="tablist">
                    <button type="button" class="btn btn-secondary active left" id="dataview-tab"
                        data-toggle="tab" data-target="#dataview" type="button" role="tab"
                        aria-controls="dataview" aria-selected="false"><img
                            src="<?php echo base_url(); ?>include/assets/images/data-view.svg"> Data View</button>
                    <button type="button" class="btn btn-secondary right" id="mapview-tab" data-toggle="tab"
                        data-target="#mapview" type="button" role="tab" aria-controls="mapview"
                        aria-selected="true"><img src="<?php echo base_url(); ?>include/assets/images/map-view.svg"> Map View</button>
                    
                </div>
            </div>

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
                            <div class="col-sm-10 col-md-10 col-lg-10">
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
							<div class="col-md-2 export_align">
								<button type="button" class="btn btn-sm hidden"  id="export_sub" onclick="exportXcel()">Export data</button>
							</div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="Submitted" role="tabpanel"
									aria-labelledby="Submitted-tab">
									<?php echo form_open('', array('id' => 'moderateVerifyDataForm')); ?>
										<div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<div class="input_place p-2 hidden" id="text_submit_search">
												<div class="ml-auto">
												<input type="text" id="user_submit_search" class="search form-control submited_search" placeholder="(Search on Name, Phone Number)">
												<span class="search_icon" onClick="searchSumitedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</div>
											<div class="mt-10">
											<?php if ($this->session->userdata('role') == 6) {?>
												<button type="button" class="btn btn-sm btn-success verify hidden ml-2" data-status="2">Approve</button>
												<button type="button" class="btn btn-sm btn-danger verify hidden" data-status="3">Reject</button>
												<!-- <button type="button" class="btn btn-sm btn-danger delete hidden ml-2" data-status="delete">Delete</button> -->
											<?php } ?>
											</div>
										</div>
                                        <div class="table-responsive" style="height:460px;">
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
										<div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<span class="p-2 input_place hidden" id="text_approved_search">
												<div class="ml-auto">
												<input type="text" id="user_approved_search" class="search form-control approved_search" placeholder=" (Search on Name, Phone Number) ">
												<span class="search_icon" onClick="searchApprovedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</span>
											<!-- <button type="button" class="btn btn-sm btn-primary" id="export_ap" onclick="approvedeExportXcel()">Export data</button> -->
										</div>
                                        <div class="table-responsive" style="height:345px;">
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
										<div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<div class="input_place p-2 hidden" id="text_rejected_search">
												<div class="ml-auto">
												<input type="text" id="user_rejected_search" class="search form-control rejected_search" placeholder="(Search on Name, Phone Number)">
												<span class="search_icon" onClick="searchRejectedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</div>
											<!-- <button type="button" class="btn btn-sm btn-primary hidden" id="export_rej" onclick="rejectedExportXcel()">Export data</button> -->
										</div>
                                        <div class="table-responsive" style="height:345px;">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
<script>
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
		var respondent_id = $('select[name="respondent_id"]').val();
		var start_date=$('input[name="start_date_vsd"]').val();
        var end_date=$('input[name="end_date_vsd"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			start_date : start_date,
            end_date : end_date,
			// survey_id: survey_id,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			},
			pa_verified_status:1
		};
		$("#info_data").css("display","none");
		var imageLoader = `<div class="loaders">
				<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
					<img class="map_icon" src="<?php echo base_url(); ?>include/img/Loader_new.svg" alt="loader">
					<p class="text-color"><strong> Loading...</strong></p>
				</div>
			</div>`;
		$('#submited_body').html(imageLoader);
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_submited_contributor_data",
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
					return false;
				}
				$('#text_submit_search').removeClass('hidden');
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
				var lkp_education_level = response.lkp_education_level;
				var lkp_occupation = response.lkp_occupation;
				var lkp_market = response.lkp_market;
				var lkp_transport_means = response.lkp_transport_means;
				var lkp_group = response.lkp_group;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				if ((role == 6)) {
					tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
				}
				tableHead += `<th>S.No.</th>`;
				if (role == 6) {
					tableHead += `<th>Cluster Admin Verify</th>`;
				}else{
					tableHead += `<th>Cluster Admin Verify</th>`;
				}
				tableHead += `<th nowrap>Country</th>`;
				tableHead += `<th nowrap>UAI</th>`;
				tableHead += `<th nowrap>Sub Location</th>`;
				tableHead += `<th nowrap>Cluster</th>`;
				tableHead += `<th nowrap>User Name</th>`;
				tableHead += `<th nowrap>First Name</th>`;
				tableHead += `<th nowrap>Last Name</th>`;
				tableHead += `<th nowrap>Phone Number</th>`;
				tableHead += `<th nowrap>Email</th>`;
				tableHead += `<th nowrap>Date Of Birth</th>`;
				tableHead += `<th nowrap>What is your gender?</th>`;
				// tableHead += `<th nowrap>Select the respondent name as indicated on the roster</th>`;
				tableHead += `<th nowrap>What is your National Identification (ID) number?</th>`;
				// tableHead += `<th nowrap>What is the phone number you often use to communicate?</th>`;
				tableHead += `<th nowrap>Your Mpesa number (for payment purposes)</th>`;
				tableHead += `<th nowrap>Bank Name</th>`;
				tableHead += `<th nowrap>Branch Name</th>`;
				tableHead += `<th nowrap>Branch Code</th>`;
				tableHead += `<th nowrap>Account Number</th>`;
				tableHead += `<th nowrap>What brand name of smart phone are you currently using?</th>`;
				tableHead += `<th nowrap>What is the Android version of your phone?</th>`;
				tableHead += `<th nowrap>How long have you used smart phone (in years)?</th>`;
				tableHead += `<th nowrap>What is your highest level of education?</th>`;
				tableHead += `<th nowrap>What is your current primary occupation?</th>`;
				tableHead += `<th nowrap>Which livestock markets do you commonly access?</th>`;
				tableHead += `<th nowrap>What is the distance between your home and a formal livestock market (in kilometers)?</th>`;
				tableHead += `<th nowrap>What is the common means of transport you use to your nearest local livestock market?</th>`;
				tableHead += `<th nowrap>How long do you take from your home to reach the local livestock market (in minutes)</th>`;
				tableHead += `<th nowrap>How long do you take from your home to reach the nearest assigned household?</th>`;
				tableHead += `<th nowrap>How long in minutes do you take from your home to reach the nearest assigned wet period transect point?</th>`;
				tableHead += `<th nowrap>How long in minutes do you take from your home to reach the nearest assigned dry period transect point?</th>`;
				tableHead += `<th nowrap>Does any member of your household participate in any of the following social groups?</th>`;
				tableHead += `<th nowrap>Have you ever participated in a mobile based survey?</th>`;
				
				
				tableHead += `<th>Terms & conditions</th><th>Signature</th>`;
				tableHead += `<th>Latitude</th><th>Longitude</th>`;
				tableHead += `<th>Uploaded By</th><th>Uploaded Datetime</th>`;

				$('#submited_head').html(tableHead);

				$('#submited_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['data_id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						if ((role == 6)) {
							tableBody += `<td class="text-center">
							<input type="checkbox" name="check_sub[]" value="`+submitedData[k]['user_id']+`"`;
							tableBody += submitedData[k]['terms_conditions'] == null ? `Disabled `  : ` />`;
							tableBody += `</td>`;	
						}
						tableBody += `<td>`+ count++ +`</td>`;
						
						tableBody += `<td class="text-center">`;
						if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
							tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
						}else if(submitedData[k]['pa_verified_status'] == 2){
							tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
						}else{
							tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
						}
						tableBody += `</td>`;
						// tableBody += `<td>`;
						// if(submitedData[k]['images'] != 'N/A'){
						// 	tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k]['images'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
						// }else{
						// 	tableBody += `N/A`;
						// }
						// tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['country_id']){
							for (ckey in lkp_country){
								if(lkp_country[ckey]['country_id'] == submitedData[k]['country_id']){
									tableBody += lkp_country[ckey]['name'];
								}
							}
						}else{
							tableBody +="N/A";
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
						if(submitedData[k]['sub_loc_id']){
							for (ikey in lkp_sub_location){
								if(lkp_sub_location[ikey]['sub_loc_id'] == submitedData[k]['sub_loc_id']){
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
						tableBody += `<td>`;
								tableBody += submitedData[k]['username'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['last_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['mobile_number'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['email_id'];
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['year_of_birth']){
								tableBody += submitedData[k]['year_of_birth'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['gender_id'] == 1){
								tableBody += 'Female';
							}else if(submitedData[k]['gender_id'] == 2){
								tableBody +="Male";
							}else if(submitedData[k]['gender_id'] == 3){
								tableBody +="Other";
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['national_id']){
								tableBody += submitedData[k]['national_id'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['mpesa_id'] || submitedData[k]['mpesa_id'] == "null"){
								tableBody += submitedData[k]['mpesa_id'];
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['bank_name'] || submitedData[k]['bank_name'] == "null"){
								tableBody += submitedData[k]['bank_name'];
							}else{
								tableBody +="N/A";
							}
								
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['branch_name'] || submitedData[k]['branch_name'] == "null"){
								tableBody += submitedData[k]['branch_name'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['branch_code'] || submitedData[k]['branch_code'] == "null"){
								tableBody += submitedData[k]['branch_code'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['account_number'] || submitedData[k]['account_number'] == "null"){
								tableBody += submitedData[k]['account_number'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['smartphone_brand'] || submitedData[k]['smartphone_brand'] == "null"){
								tableBody += submitedData[k]['smartphone_brand'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['android_version'] || submitedData[k]['android_version'] == "null"){
								tableBody += submitedData[k]['android_version'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['years_of_use'] || submitedData[k]['years_of_use'] == "null"){
								tableBody += submitedData[k]['years_of_use'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['highest_education']){
									for (ekey in lkp_education_level){
										if(lkp_education_level[ekey]['edu_id'] == submitedData[k]['highest_education']){
											tableBody += lkp_education_level[ekey]['name'];
										}
									}
								}else{
									tableBody +="N/A";
								}	
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['primary_occupation']){
								for (opkey in lkp_occupation){
									if(lkp_occupation[opkey]['occu_id'] == submitedData[k]['primary_occupation']){
										tableBody += lkp_occupation[opkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}	
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['market_id']){
								for (mkey in lkp_market){
									if(lkp_market[mkey]['market_id'] == submitedData[k]['market_id']){
										tableBody += lkp_market[mkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['formal_livestock_market_distance']){
								tableBody += submitedData[k]['formal_livestock_market_distance'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['means_of_transport']){
								for (tkey in lkp_transport_means){
									if(lkp_transport_means[tkey]['transport_id'] == submitedData[k]['means_of_transport']){
										tableBody += lkp_transport_means[tkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_market']){
								tableBody += submitedData[k]['time_taken_to_reach_market'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_assigned_household']){
								tableBody += submitedData[k]['time_taken_to_reach_assigned_household'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_wet_transect_point']){
								tableBody += submitedData[k]['time_taken_to_reach_wet_transect_point'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_dry_transect_point']){
								tableBody += submitedData[k]['time_taken_to_reach_dry_transect_point'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['joined_group']){
									let checkedValues = (submitedData[k]['joined_group']).replace('&#44;',',');
									let output = '';
									for (gkey in lkp_group){
										for (var i = 0; i < checkedValues.length; i++) {
											if (checkedValues[i] == lkp_group[gkey]['group_id']) {
												output += lkp_group[gkey]['name'] + '<br>';
											}
										}
									}
									tableBody += output;
								}else{
									tableBody +="N/A";
								}
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['participated_in_survey']){
								tableBody += submitedData[k]['participated_in_survey'] == 1 ? 'Yes':'No';
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;

						tableBody += `<td>`;
							if(submitedData[k]['terms_conditions']){
								tableBody += submitedData[k]['terms_conditions'] == 1 ? 'Yes' : 'No';
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['signature']){
								// tableBody += `<img src="<?php echo base_url(); ?>uploads/user/${submitedData[k]['signature']}" width="70px" height="40px" />`;
								tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/user/`+ submitedData[k]['signature'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
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
							if(submitedData[k]['added_by1']){
								tableBody += submitedData[k]['added_by1'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['added_datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#submited_body').append(tableBody);
						
					}
				}else{
					$('#submited_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
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
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			start_date : start_date,
            end_date : end_date,
			// survey_id: survey_id,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
		};
		var imageLoader = `<div class="loaders">
				<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
					<img class="map_icon" src="<?php echo base_url(); ?>include/img/Loader_new.svg" alt="loader">
					<p class="text-color"><strong> Loading...</strong></p>
				</div>
			</div>`;
		$('#approved_body').html(imageLoader);
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_approved_contributor_data",
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
					return false;
				}
				$('#text_approved_search').removeClass('hidden');
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
				var cluster_admin = response.cluster_admin;
				var lkp_education_level = response.lkp_education_level;
				var lkp_occupation = response.lkp_occupation;
				var lkp_market = response.lkp_market;
				var lkp_transport_means = response.lkp_transport_means;
				var lkp_group = response.lkp_group;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// if ((role == 1 || role == 6)) {
				// 	tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
				// }
				tableHead += `<th>S.No.</th>`;
				if (role == 6) {
					tableHead += `<th>Cluster Admin Verify</th>`;
				}else{
					tableHead += `<th>Cluster Admin Verify</th>`;
				}
				tableHead += `<th nowrap>Country</th>`;
				tableHead += `<th nowrap>UAI</th>`;
				tableHead += `<th nowrap>Sub Location</th>`;
				tableHead += `<th nowrap>Cluster</th>`;
				tableHead += `<th nowrap>User Name</th>`;
				tableHead += `<th nowrap>First Name</th>`;
				tableHead += `<th nowrap>Last Name</th>`;
				tableHead += `<th nowrap>Phone Number</th>`;
				tableHead += `<th nowrap>Email</th>`;
				tableHead += `<th nowrap>Date Of Birth</th>`;
				tableHead += `<th nowrap>What is your gender?</th>`;
				// tableHead += `<th nowrap>Select the respondent name as indicated on the roster</th>`;
				tableHead += `<th nowrap>What is your National Identification (ID) number?</th>`;
				// tableHead += `<th nowrap>What is the phone number you often use to communicate?</th>`;
				tableHead += `<th nowrap>Your Mpesa number (for payment purposes)</th>`;
				tableHead += `<th nowrap>Bank Name</th>`;
				tableHead += `<th nowrap>Branch Name</th>`;
				tableHead += `<th nowrap>Branch Code</th>`;
				tableHead += `<th nowrap>Account Number</th>`;
				tableHead += `<th nowrap>What brand name of smart phone are you currently using?</th>`;
				tableHead += `<th nowrap>What is the Android version of your phone?</th>`;
				tableHead += `<th nowrap>How long have you used smart phone (in years)?</th>`;
				tableHead += `<th nowrap>What is your highest level of education?</th>`;
				tableHead += `<th nowrap>What is your current primary occupation?</th>`;
				tableHead += `<th nowrap>Which livestock markets do you commonly access?</th>`;
				tableHead += `<th nowrap>What is the distance between your home and a formal livestock market (in kilometers)?</th>`;
				tableHead += `<th nowrap>What is the common means of transport you use to your nearest local livestock market?</th>`;
				tableHead += `<th nowrap>How long do you take from your home to reach the local livestock market (in minutes)</th>`;
				tableHead += `<th nowrap>How long do you take from your home to reach the nearest assigned household?</th>`;
				tableHead += `<th nowrap>How long in minutes do you take from your home to reach the nearest assigned wet period transect point?</th>`;
				tableHead += `<th nowrap>How long in minutes do you take from your home to reach the nearest assigned dry period transect point?</th>`;
				tableHead += `<th nowrap>Does any member of your household participate in any of the following social groups?</th>`;
				tableHead += `<th nowrap>Have you ever participated in a mobile based survey?</th>`;
				
				
				tableHead += `<th>Approved By</th><th>Approved On</th>`;
				tableHead += `<th>Terms & conditions</th><th>Signature</th>`;
				tableHead += `<th>Latitude</th><th>Longitude</th>`;
				tableHead += `<th>Uploaded By</th><th>Uploaded Datetime</th>`;

				$('#approved_head').html(tableHead);

				$('#approved_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['data_id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						// if ((role == 1 || role == 6)) {
						// 	tableBody += `<td class="text-center">
						// 	<input type="checkbox" name="check_sub[]" value="`+submitedData[k]['id']+`"`;
						// 	tableBody += `</td>`;	
						// }
						tableBody += `<td>`+ count++ +`</td>`;
						
						tableBody += `<td class="text-center">`;
						if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
							tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
						}else if(submitedData[k]['pa_verified_status'] == 2){
							tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
						}else{
							tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
						}
						tableBody += `</td>`;
						// tableBody += `<td>`;
						// if(submitedData[k]['images'] != 'N/A'){
						// 	tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k]['images'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
						// }else{
						// 	tableBody += `N/A`;
						// }
						// tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['country_id']){
							for (ckey in lkp_country){
								if(lkp_country[ckey]['country_id'] == submitedData[k]['country_id']){
									tableBody += lkp_country[ckey]['name'];
								}
							}
						}else{
							tableBody +="N/A";
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
						if(submitedData[k]['sub_loc_id']){
							for (ikey in lkp_sub_location){
								if(lkp_sub_location[ikey]['sub_loc_id'] == submitedData[k]['sub_loc_id']){
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
						tableBody += `<td>`;
								tableBody += submitedData[k]['username'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['last_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['mobile_number'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['email_id'];
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['year_of_birth']){
								tableBody += submitedData[k]['year_of_birth'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['gender_id'] == 1){
								tableBody += 'Female';
							}else if(submitedData[k]['gender_id'] == 2){
								tableBody +="Male";
							}else if(submitedData[k]['gender_id'] == 3){
								tableBody +="Other";
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['national_id']){
								tableBody += submitedData[k]['national_id'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['mpesa_id'] || submitedData[k]['mpesa_id'] == "null"){
								tableBody += submitedData[k]['mpesa_id'];
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['bank_name'] || submitedData[k]['bank_name'] == "null"){
								tableBody += submitedData[k]['bank_name'];
							}else{
								tableBody +="N/A";
							}
								
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['branch_name'] || submitedData[k]['branch_name'] == "null"){
								tableBody += submitedData[k]['branch_name'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['branch_code'] || submitedData[k]['branch_code'] == "null"){
								tableBody += submitedData[k]['branch_code'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['account_number'] || submitedData[k]['account_number'] == "null"){
								tableBody += submitedData[k]['account_number'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['smartphone_brand'] || submitedData[k]['smartphone_brand'] == "null"){
								tableBody += submitedData[k]['smartphone_brand'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['android_version'] || submitedData[k]['android_version'] == "null"){
								tableBody += submitedData[k]['android_version'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['years_of_use'] || submitedData[k]['years_of_use'] == "null"){
								tableBody += submitedData[k]['years_of_use'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['highest_education']){
									for (ekey in lkp_education_level){
										if(lkp_education_level[ekey]['edu_id'] == submitedData[k]['highest_education']){
											tableBody += lkp_education_level[ekey]['name'];
										}
									}
								}else{
									tableBody +="N/A";
								}	
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['primary_occupation']){
								for (opkey in lkp_occupation){
									if(lkp_occupation[opkey]['occu_id'] == submitedData[k]['primary_occupation']){
										tableBody += lkp_occupation[opkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}	
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['market_id']){
								for (mkey in lkp_market){
									if(lkp_market[mkey]['market_id'] == submitedData[k]['market_id']){
										tableBody += lkp_market[mkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['formal_livestock_market_distance']){
								tableBody += submitedData[k]['formal_livestock_market_distance'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['means_of_transport']){
								for (tkey in lkp_transport_means){
									if(lkp_transport_means[tkey]['transport_id'] == submitedData[k]['means_of_transport']){
										tableBody += lkp_transport_means[tkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_market']){
								tableBody += submitedData[k]['time_taken_to_reach_market'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_assigned_household']){
								tableBody += submitedData[k]['time_taken_to_reach_assigned_household'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_wet_transect_point']){
								tableBody += submitedData[k]['time_taken_to_reach_wet_transect_point'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_dry_transect_point']){
								tableBody += submitedData[k]['time_taken_to_reach_dry_transect_point'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['joined_group']){
									let checkedValues = (submitedData[k]['joined_group']).replaceAll('&#44;',',');
									let output = '';
									for (gkey in lkp_group){
										for (var i = 0; i < checkedValues.length; i++) {
											if (checkedValues[i] == lkp_group[gkey]['group_id']) {
												output += lkp_group[gkey]['name'] + '<br>';
											}
										}
									}
									tableBody += output;
								}else{
									tableBody +="N/A";
								}
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['participated_in_survey']){
								tableBody += submitedData[k]['participated_in_survey'] == 1 ? 'Yes':'No';
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
							if(submitedData[k]['terms_conditions']){
								tableBody += submitedData[k]['terms_conditions'] == 1 ? 'Yes' : 'No';
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['signature']){
								tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/user/`+ submitedData[k]['signature'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;

							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;

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
								tableBody += submitedData[k]['added_by1'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['added_datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#approved_body').append(tableBody);
					}
						
					
				}else{
					$('#approved_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
				}

				// const curentPage = pageNo;
				// const totalRecordsPerPage = recordperpage;
				// const totalRecords= response.total_records;
				// const currentRecords = submitedData.length;
				// pagination1.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))
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
					document.getElementById('approved_pagination').style.display = 'none';
				} else{
					document.getElementById('approved_pagination').style.display = 'flex';
					pagination1.refreshPagination (Number(curentPage),totalRecords,currentRecords, Number(totalRecordsPerPage))
				}
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
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			start_date : start_date,
            end_date : end_date,
			// survey_id: survey_id,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
		};
		var imageLoader = `<div class="loaders">
				<div class="d-flex flex-column align-items-center justify-content-center loader-height" >
					<img class="map_icon" src="<?php echo base_url(); ?>include/img/Loader_new.svg" alt="loader">
					<p class="text-color"><strong> Loading...</strong></p>
				</div>
			</div>`;
		$('#rejected_body').html(imageLoader);
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_rejected_contributor_data",
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
					return false;
				}
				$('#text_rejected_search').removeClass('hidden');
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
				var cluster_admin = response.cluster_admin;
				var lkp_education_level = response.lkp_education_level;
				var lkp_occupation = response.lkp_occupation;
				var lkp_market = response.lkp_market;
				var lkp_transport_means = response.lkp_transport_means;
				var lkp_group = response.lkp_group;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// if ((role == 1 || role == 6)) {
				// 	tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
				// }
				tableHead += `<th>S.No.</th>`;
				if (role == 6) {
					tableHead += `<th>Cluster Admin Verify</th>`;
				}else{
					tableHead += `<th>Cluster Admin Verify</th>`;
				}
				tableHead += `<th nowrap>Country</th>`;
				tableHead += `<th nowrap>UAI</th>`;
				tableHead += `<th nowrap>Sub Location</th>`;
				tableHead += `<th nowrap>Cluster</th>`;
				tableHead += `<th nowrap>User Name</th>`;
				tableHead += `<th nowrap>First Name</th>`;
				tableHead += `<th nowrap>Last Name</th>`;
				tableHead += `<th nowrap>Phone Number</th>`;
				tableHead += `<th nowrap>Email</th>`;
				tableHead += `<th nowrap>Date Of Birth</th>`;
				tableHead += `<th nowrap>What is your gender?</th>`;
				// tableHead += `<th nowrap>Select the respondent name as indicated on the roster</th>`;
				tableHead += `<th nowrap>What is your National Identification (ID) number?</th>`;
				// tableHead += `<th nowrap>What is the phone number you often use to communicate?</th>`;
				tableHead += `<th nowrap>Your Mpesa number (for payment purposes)</th>`;
				tableHead += `<th nowrap>Bank Name</th>`;
				tableHead += `<th nowrap>Branch Name</th>`;
				tableHead += `<th nowrap>Branch Code</th>`;
				tableHead += `<th nowrap>Account Number</th>`;
				tableHead += `<th nowrap>What brand name of smart phone are you currently using?</th>`;
				tableHead += `<th nowrap>What is the Android version of your phone?</th>`;
				tableHead += `<th nowrap>How long have you used smart phone (in years)?</th>`;
				tableHead += `<th nowrap>What is your highest level of education?</th>`;
				tableHead += `<th nowrap>What is your current primary occupation?</th>`;
				tableHead += `<th nowrap>Which livestock markets do you commonly access?</th>`;
				tableHead += `<th nowrap>What is the distance between your home and a formal livestock market (in kilometers)?</th>`;
				tableHead += `<th nowrap>What is the common means of transport you use to your nearest local livestock market?</th>`;
				tableHead += `<th nowrap>How long do you take from your home to reach the local livestock market (in minutes)</th>`;
				tableHead += `<th nowrap>How long do you take from your home to reach the nearest assigned household?</th>`;
				tableHead += `<th nowrap>How long in minutes do you take from your home to reach the nearest assigned wet period transect point?</th>`;
				tableHead += `<th nowrap>How long in minutes do you take from your home to reach the nearest assigned dry period transect point?</th>`;
				tableHead += `<th nowrap>Does any member of your household participate in any of the following social groups?</th>`;
				tableHead += `<th nowrap>Have you ever participated in a mobile based survey?</th>`;
				tableHead += `<th nowrap>Rejected By</th>`;
				tableHead += `<th nowrap>Rejected On</th>`;
				tableHead += `<th nowrap>Rejected Remarks</th>`;
				
				tableHead += `<th>Terms & conditions</th><th>Signature</th>`;
				tableHead += `<th>Latitude</th><th>Longitude</th>`;
				tableHead += `<th>Uploaded By</th><th>Uploaded Datetime</th>`;

				$('#rejected_head').html(tableHead);

				$('#rejected_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['data_id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						// if ((role == 1 || role == 6)) {
						// 	tableBody += `<td class="text-center">
						// 	<input type="checkbox" name="check_sub[]" value="`+submitedData[k]['id']+`"`;
						// 	tableBody += `</td>`;	
						// }
						tableBody += `<td>`+ count++ +`</td>`;
						
						tableBody += `<td class="text-center">`;
						if(submitedData[k]['pa_verified_status'] == 1 || submitedData[k]['pa_verified_status'] == null || submitedData[k]['pa_verified_status'] == ''){
							tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
						}else if(submitedData[k]['pa_verified_status'] == 2){
							tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
						}else{
							tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
						}
						tableBody += `</td>`;
						// tableBody += `<td>`;
						// if(submitedData[k]['images'] != 'N/A'){
						// 	tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k]['images'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
						// }else{
						// 	tableBody += `N/A`;
						// }
						// tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['country_id']){
							for (ckey in lkp_country){
								if(lkp_country[ckey]['country_id'] == submitedData[k]['country_id']){
									tableBody += lkp_country[ckey]['name'];
								}
							}
						}else{
							tableBody +="N/A";
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
						if(submitedData[k]['sub_loc_id']){
							for (ikey in lkp_sub_location){
								if(lkp_sub_location[ikey]['sub_loc_id'] == submitedData[k]['sub_loc_id']){
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
						tableBody += `<td>`;
								tableBody += submitedData[k]['username'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['first_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['last_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['mobile_number'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['email_id'];
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['year_of_birth']){
								tableBody += submitedData[k]['year_of_birth'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['gender_id'] == 1){
								tableBody += 'Female';
							}else if(submitedData[k]['gender_id'] == 2){
								tableBody +="Male";
							}else if(submitedData[k]['gender_id'] == 3){
								tableBody +="Other";
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['national_id']){
								tableBody += submitedData[k]['national_id'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['mpesa_id'] || submitedData[k]['mpesa_id'] == "null"){
								tableBody += submitedData[k]['mpesa_id'];
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['bank_name'] || submitedData[k]['bank_name'] == "null"){
								tableBody += submitedData[k]['bank_name'];
							}else{
								tableBody +="N/A";
							}
								
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['branch_name'] || submitedData[k]['branch_name'] == "null"){
								tableBody += submitedData[k]['branch_name'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['branch_code'] || submitedData[k]['branch_code'] == "null"){
								tableBody += submitedData[k]['branch_code'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['account_number'] || submitedData[k]['account_number'] == "null"){
								tableBody += submitedData[k]['account_number'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['smartphone_brand'] || submitedData[k]['smartphone_brand'] == "null"){
								tableBody += submitedData[k]['smartphone_brand'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['android_version'] || submitedData[k]['android_version'] == "null"){
								tableBody += submitedData[k]['android_version'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['years_of_use'] || submitedData[k]['years_of_use'] == "null"){
								tableBody += submitedData[k]['years_of_use'];
							}else{
									tableBody +="N/A";
								}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['highest_education']){
									for (ekey in lkp_education_level){
										if(lkp_education_level[ekey]['edu_id'] == submitedData[k]['highest_education']){
											tableBody += lkp_education_level[ekey]['name'];
										}
									}
								}else{
									tableBody +="N/A";
								}	
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['primary_occupation']){
								for (opkey in lkp_occupation){
									if(lkp_occupation[opkey]['occu_id'] == submitedData[k]['primary_occupation']){
										tableBody += lkp_occupation[opkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}	
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['market_id']){
								for (mkey in lkp_market){
									if(lkp_market[mkey]['market_id'] == submitedData[k]['market_id']){
										tableBody += lkp_market[mkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['formal_livestock_market_distance']){
								tableBody += submitedData[k]['formal_livestock_market_distance'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['means_of_transport']){
								for (tkey in lkp_transport_means){
									if(lkp_transport_means[tkey]['transport_id'] == submitedData[k]['means_of_transport']){
										tableBody += lkp_transport_means[tkey]['name'];
									}
								}
							}else{
								tableBody +="N/A";
							}
							
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_market']){
								tableBody += submitedData[k]['time_taken_to_reach_market'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_assigned_household']){
								tableBody += submitedData[k]['time_taken_to_reach_assigned_household'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_wet_transect_point']){
								tableBody += submitedData[k]['time_taken_to_reach_wet_transect_point'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['time_taken_to_reach_dry_transect_point']){
								tableBody += submitedData[k]['time_taken_to_reach_dry_transect_point'];
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
								if(submitedData[k]['joined_group']){
									let checkedValues = (submitedData[k]['joined_group']).replace('&#44;',',');
									let output = '';
									for (gkey in lkp_group){
										for (var i = 0; i < checkedValues.length; i++) {
											if (checkedValues[i] == lkp_group[gkey]['group_id']) {
												output += lkp_group[gkey]['name'] + '<br>';
											}
										}
									}
									tableBody += output;
								}else{
									tableBody +="N/A";
								}
								
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['participated_in_survey']){
								tableBody += submitedData[k]['participated_in_survey'] == 1 ? 'Yes':'No';
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
							if(submitedData[k]['terms_conditions']){
								tableBody += submitedData[k]['terms_conditions'] == 1 ? 'Yes' : 'No';
							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;
						tableBody += `<td>`;
							if(submitedData[k]['signature']){
								tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/user/`+ submitedData[k]['signature'] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;

							}else{
								tableBody +="N/A";
							}
						tableBody += `</td>`;

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
								tableBody += submitedData[k]['added_by1'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['added_datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#rejected_body').append(tableBody);
					}
						
					
				}else{
					$('#rejected_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
				}

				// const curentPage = pageNo;
				// const totalRecordsPerPage = recordperpage;
				// const totalRecords= response.total_records;
				// const currentRecords = submitedData.length;
				// pagination2.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))
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
					document.getElementById('rejected_pagination').style.display = 'none';
				} else{
					document.getElementById('rejected_pagination').style.display = 'flex';
					pagination2.refreshPagination (Number(curentPage),totalRecords,currentRecords, Number(totalRecordsPerPage))
				}
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
					$('#cluster_id').html('<option value="">Select Cluster</option>');
                }
            });
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
			$('#respondent_id').html('<option value="">Select Respondent</option>');
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
</script>
<!-- map view section -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
<script>
	$('#mapview-tab').on('click', function(){
		// loadAllLocationData(null);
		setTimeout(function(){ 
			map.invalidateSize()
		}, 500);
	})
		
        var addressPoints = [
            [-1.286389, 36.817223, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [0.569525, 34.558376, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [-0.091702, 34.767956, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [1.019089, 35.002304, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [-4.043740, 39.658871, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [0.514277, 35.269779, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [-3.219186, 40.116890, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
            [-0.717178, 36.431026, "<b>Task Name :</b>  Livestock Headcount <br> <b>Assigned To: </b> Pam@wy <br> <b>Contributor Role:</b> Farmer <br> <b>Status:</b> Rejected <br> <b>Cluster:</b> Afar <br> <b>Country:</b> Ethiopia <br> <b>Schedule:</b> 03/08/2022 <br> <b>Recurrent:</b> 06/08/2022 "],
           
        ];

        var map = L.map('map').setView([0.569525, 34.558376], 5);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = L.markerClusterGroup();

        for (var i = 0; i < addressPoints.length; i++) {
            var a = addressPoints[i];
            var title = a[2];
            var marker = L.marker(new L.LatLng(a[0], a[1]), {
                title: title
            });
            marker.bindPopup(title);
            markers.addLayer(marker);
        }

        map.addLayer(markers);
    </script>

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
            //         'Incorrect data': 'Incorrect data',
            //         'Inadequate data': 'Inadequate data',
			// 		'Others': 'Others'
            //     },
			// 	showCancelButton: true,
			// 	confirmButtonClass: "btn-danger",
			// 	confirmButtonColor: '#fa2428',
			// 	confirmButtonText: "Yes, Reject!",
			// 	closeOnConfirm: false,
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
			url: '<?php echo base_url(); ?>reports/verify_contributor/',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			// complete: function(data) {
			// 	var ajaxData = [];
			// 	var csrfData = JSON.parse(data.responseText);
			// 	ajaxData[csrfData.csrfName] = csrfData.csrfHash;
			// 	if (csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
			// 		$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
			// 	}
			// },
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
	function exportXcel() {
		$("#export_sub").prop('disabled', true);
        $("#export_sub").html("Please wait ...");

		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var respondent_id = $('select[name="respondent_id"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			// survey_id: survey_id,
			// survey_type: survey_type,
			pa_verified_status:null,
			pagination:null
		};
		
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_submited_contributor_data/",
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
				var submitedData = response.submited_data;
				var lkp_country = response.lkp_country;
				var lkp_cluster = response.lkp_cluster;
				var lkp_uai = response.lkp_uai;
				var lkp_sub_location = response.lkp_sub_location;
				var lkp_location_type = response.lkp_location_type;
				var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				var respondent_name = response.respondent_name;
				var lkp_education_level = response.lkp_education_level;
				var lkp_occupation = response.lkp_occupation;
				var lkp_market = response.lkp_market;
				var lkp_transport_means = response.lkp_transport_means;
				var lkp_group = response.lkp_group;

				// var myArray = $.makeArray({ foo: "bar", hello: "world
				var verified_list = $.makeArray({"1":"Submitted","2":"Approved","3":"Rejected"});
				var genders = $.makeArray({"1":"Female","2":"Male","3":"Other"});
				const lkpData = {};

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
				for (let sbid = 0; sbid < lkp_sub_location.length; sbid++) {
					const element = lkp_sub_location[sbid];
					subLocations[element.sub_loc_id] = element.location_name;
				}
				const clusters = {};
				for (let cid = 0; cid < lkp_cluster.length; cid++) {
					const element = lkp_cluster[cid];
					clusters[element.cluster_id] = element.name;
				}

				const locationtypes = {};
				for (let lt = 0; lt < lkp_location_type.length; lt++) {
					const element = lkp_location_type[lt];
					locationtypes[element.location_id] = element.name;
				}
				const markets = {};
				for (let mi = 0; mi < lkp_market.length; mi++) {
					const element = lkp_market[mi];
					markets[element.market_id] = element.name;
				}
				const animaltypelactatings = {};
				for (let akey = 0; akey < lkp_animal_type_lactating.length; akey++) {
					const element = lkp_animal_type_lactating[akey];
					animaltypelactatings[element.animal_type_lactating_id] = element.name;
				}
				const educationlevels = {};
				for (let ekey = 0; ekey < lkp_education_level.length; ekey++) {
					const element = lkp_education_level[ekey];
					educationlevels[element.edu_id] = element.name;
				}
				const occupations = {};
				for (let okey = 0; okey < lkp_occupation.length; okey++) {
					const element = lkp_occupation[okey];
					occupations[element.occu_id] = element.name;
				}
				const transportMeans = {};
				for (let cp = 0; cp < lkp_transport_means.length; cp++) {
					const element = lkp_transport_means[cp];
					transportMeans[element.transport_id] = element.name;
				}
				const groups = {};
				for (let gp = 0; gp < lkp_group.length; gp++) {
					const element = lkp_group[gp];
					groups[element.group_id] = element.name;
				}
				
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

				xcelHeader.push(...['Country','UAI','Sub Location','Cluster','User Name','First Name','Last Name','Phone Number','Email','Date Of Birth','What is your gender?','What is your National Identification (ID) number?','Your Mpesa number (for payment purposes)','Bank Name','Branch Name','Branch Code','Account Number','What brand name of smart phone are you currently using?','What is the Android version of your phone?','How long have you used smart phone (in years)?','What is your highest level of education?','What is your current primary occupation?','Which livestock markets do you commonly access?','What is the distance between your home and a formal livestock market (in kilometers)?','What is the common means of transport you use to your nearest local livestock market?','How long do you take from your home to reach the local livestock market (in minutes)','How long do you take from your home to reach the nearest assigned household?','How long in minutes do you take from your home to reach the nearest assigned wet period transect point?','How long in minutes do you take from your home to reach the nearest assigned dry period transect point?','Does any member of your household participate in any of the following social groups?','Have you ever participated in a mobile based survey?','Terms & conditions','Signature']);
				
				tableHeaderFields.push(...['country_id','uai_id','sub_location_id','cluster_id','added_by1','first_name','last_name','mobile_number','email_id','year_of_birth','gender_id','national_id','mpesa_id','bank_name','branch_name','branch_code','account_number','smartphone_brand','android_version','years_of_use','highest_education','primary_occupation','market_id','formal_livestock_market_distance','means_of_transport','time_taken_to_reach_market','time_taken_to_reach_assigned_household','time_taken_to_reach_wet_transect_point','time_taken_to_reach_dry_transect_point','joined_group','participated_in_survey','terms_conditions','signature']);
				
				
				xcelHeader.push(...['Latitude','Longitude','Uploaded By','Uploaded Datetime','Verification status']);
				tableHeaderFields.push(...['lat','lng','added_by1','added_datetime','pa_verified_status']);


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
						// elemnt.cluster_id = locationtypes[elemnt.cluster_id] || elemnt.cluster_id || "N/A";
						elemnt.market_id = markets[elemnt.market_id] || elemnt.market_id || "N/A";
						elemnt.highest_education = educationlevels[elemnt.highest_education] || elemnt.highest_education || "N/A";
						elemnt.primary_occupation = occupations[elemnt.primary_occupation] || elemnt.primary_occupation || "N/A";
						elemnt.means_of_transport = transportMeans[elemnt.means_of_transport] || elemnt.means_of_transport || "N/A";
						// elemnt.joined_group = groups[elemnt.joined_group] || elemnt.joined_group || "N/A";

						elemnt.joined_group = elemnt.joined_group?.split(',').map(d => groups[d] || d).join(', ') || elemnt.joined_group || "N/A";
						elemnt.pa_verified_status = verified_list[0][elemnt.pa_verified_status] || elemnt.pa_verified_status || "N/A";
						elemnt.gender_id = genders[0][elemnt.gender_id] || elemnt.gender_id || "N/A";
						for (let k = 0; k < tableHeaderFields.length; k++) {
							const key = tableHeaderFields[k];
							if(lkpData[key]){
								row.push(lkpData[key][elemnt[key]] || elemnt[key] || "N/A");
							}else{
								row.push(elemnt[key] || elemnt[key] || 'N/A')
							}
						}
						xcelBody.push(row);
					}
					xcelData.push(xcelHeader)
					xcelData.push(...xcelBody)
					exportToXcel("contributors", xcelData);
					$("#export_sub").prop('disabled', false);
                	$("#export_sub").html("Export data");
				}else{
					// comment
					// alert("No data for export");
					Swal.fire({
						title: 'Note!',
						text: 'No data for export.',
						icon: 'error',  // You can use 'success', 'error', 'warning', 'info', 'question'
						confirmButtonText: 'OK'
					});
					$("#export_sub").prop('disabled', false);
        			$("#export_sub").html("Export data");
				}
			}
		});		
	}
</script>