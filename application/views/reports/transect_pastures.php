<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
<style>
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
   <div class="container-fluid">
        <div class="row">
			<?php 
				$survey_name = "Transect Pastures";
				?>
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Survey Data</a></li>
                        <li class="breadcrumb-item active"><?php echo($survey_name); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <h4 class="title"><?php echo($survey_name); ?></h4>
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
                                    <!-- <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Respondent</label>
                                            <select class="form-control" id="respondent_id" name="respondent_id">
                                                <option value="">Select Respondent</option>
                                            </select>
                                        </div>
                                    </div> -->
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
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
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
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="Submitted" role="tabpanel"
									aria-labelledby="Submitted-tab">
									<?php echo form_open('', array('id' => 'moderateVerifyDataForm')); ?>
										<div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<div class="input_place p-2 hidden" id="text_submit_search">
												<div class="ml-auto">
												<input type="text" id="user_submit_search" class="search form-control submited_search" placeholder="(Search on Contributor Name, Wet or Dry Pasture Name)">
												<span class="search_icon" onClick="searchSumitedFilter();"><i class="fa fa-search text-white"></i></span>
												</div>
											</div>
											<!-- <button type="button" class="btn btn-sm btn-primary hidden"  id="export_sub" onclick="exportXcel()">Export data</button> -->
											<button type="button" class="btn btn-sm mt-2 mb-2 hidden"  id="export_sub" data-tabvalue=1 onclick="exportXcel(event)">Export data</button>
											<?php if ($this->session->userdata('role') == 6) {?>
												<div class="mt-10">
												<button type="button" class="btn btn-sm btn-success verify hidden ml-2" data-status="2">Approve</button>
												<button type="button" class="btn btn-sm btn-danger verify hidden" data-status="3">Reject</button>
												<!-- <button type="button" class="btn btn-sm btn-danger delete hidden ml-2" data-status="delete">Delete</button> -->
											</div>
											<?php } ?>
										</div>
                                        <div class="table-responsive" style="height:345px;">
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
											<button type="button" class="btn btn-sm mt-2 mb-2 hidden"  id="export_ap" data-tabvalue=2 onclick="exportXcel(event)">Export data</button>
										</div>
                                        <div class="table-responsive" style="height:345px;">
                                            <table class="table table-striped" style="width:100%">
                                                <thead class="bg-dataTable" id="approved_head"></thead>
                                                <tbody id="approved_body"></tbody>
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
											<button type="button" class="btn btn-sm mt-2 mb-2 hidden"  id="export_rej" data-tabvalue=3 onclick="exportXcel(event)">Export data</button>
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
<script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
<script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>

<script>
    // $(function() {
	// 	$('.get_data').trigger('click');
	// });

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
		var pasture_type = $('select[name="pasture_type"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			pasture_type: pasture_type,
			pa_verified_status:"1",
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
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
			url: "<?php echo base_url(); ?>reports/get_submited_transect_data",
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
				tableHead += `<th nowrap>Pasture Name</th>`;
				tableHead += `<th nowrap>Pasture Type</th>`;
				// tableHead += `<th nowrap>Contributor</th>`;
				
				
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
						
						tableBody += `<td>`;
								tableBody += submitedData[k]['pasture_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pasture_type'];
						tableBody += `</td>`;
						
						// tableBody += `<td>`;
						// 		tableBody += submitedData[k]['added_by'];
						// tableBody += `</td>`;
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
								tableBody += submitedData[k]['added_by'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['added_datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#submited_body').append(tableBody);
						
					}
				}else{
					$('#export_sub').addClass('hidden');
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
		var pasture_type = $('select[name="pasture_type"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			pasture_type: pasture_type,
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
			url: "<?php echo base_url(); ?>reports/get_approved_transect_data",
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
				var respondent_name = response.respondent_name;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// if ((role == 1 || role == 2)) {
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
				tableHead += `<th nowrap>Pasture Name</th>`;
				tableHead += `<th nowrap>Pasture Type</th>`;
				// tableHead += `<th nowrap>Contributor</th>`;
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
						tableBody += `<td>`;
								tableBody += submitedData[k]['pasture_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pasture_type'];
						tableBody += `</td>`;
						// tableBody += `<td>`;
						// 		tableBody += submitedData[k]['added_by'];
						// tableBody += `</td>`;
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
								tableBody += submitedData[k]['approved_by'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pa_verified_date'];
						tableBody += `</td>`;

						tableBody += `<td>`;
								tableBody += submitedData[k]['added_by'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['added_datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#approved_body').append(tableBody);
					}
						
					
				}else{
					$('#export_ap').addClass('hidden');
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
		var pasture_type = $('select[name="pasture_type"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			pasture_type: pasture_type,
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
			url: "<?php echo base_url(); ?>reports/get_rejected_transect_data",
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
				var respondent_name = response.respondent_name;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// if ((role == 1 || role == 2)) {
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
				tableHead += `<th nowrap>Pasture Name</th>`;
				tableHead += `<th nowrap>Pasture Type</th>`;
				// tableHead += `<th nowrap>Contributor</th>`;
				tableHead += `<th>LATITUDE</th><th>LONGITUDE</th><th nowrap>Rejected By</th>`;
				tableHead += `<th nowrap>Rejected On</th>`;
				tableHead += `<th nowrap>Rejected Remarks</th>`;
				
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
						tableBody += `<td>`;
								tableBody += submitedData[k]['pasture_name'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pasture_type'];
						tableBody += `</td>`;
						// tableBody += `<td>`;
						// 		tableBody += submitedData[k]['added_by'];
						// tableBody += `</td>`;
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
								tableBody += submitedData[k]['rejected_by'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['pa_verified_date'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['rejected_remarks'];
						tableBody += `</td>`;

						tableBody += `<td>`;
								tableBody += submitedData[k]['added_by'];
						tableBody += `</td>`;
						tableBody += `<td>`;
								tableBody += submitedData[k]['added_datetime'];
						tableBody += `</td>`;
						tableBody += `</tr>`;

						
						$('#rejected_body').append(tableBody);
					}
						
					
				}else{
					$('#export_rej').addClass('hidden');
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
            }
			$('#sub_location_id').html('<option value="">Select Sub Location</option>');
        }else{
			$('.get_data').css("background-color","rgb(147, 148, 150)");
			$('.get_data').prop("disabled",true);
            $('#cluster_id').html('<option value="">Select Cluster</option>');
            $('#uai_id').html('<option value="">Select UAI</option>');
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            
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
            // $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });

	$('#uai_id').on('change', function(){
		$('#export_sub').addClass('hidden');
		$('#export_ap').addClass('hidden');
		$('#export_rej').addClass('hidden');
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
            // $('#respondent_id').html('<option value="">Select Respondent</option>');
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
        } 
		else{
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            // $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });
	// $('#contributor_id').on('change', function(){
    //     var contributor_id=$(this).val();
	// var page_id=0;
    //     if(contributor_id != '')
    //     {
    //         $.ajax('<?=base_url()?>reports/getRespondentByContributor', {
    //             type: 'POST',  // http method
    //             data: { contributor_id: contributor_id, page_id: page_id },  // data to submit
    //             success: function (data) {
    //                 $('#respondent_id').html(data);
    //             }
    //         });
    //     } 
	// 	else{
    //         $('#contributor_id').html('<option value="">Select Contributor</option>');
    //         $('#respondent_id').html('<option value="">Select Respondent</option>');
    //     }   
    // });
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
			url: '<?php echo base_url(); ?>reports/verify_transect_pasture/<?php echo $this->uri->segment(3); ?>',
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
		var pasture_type = $('select[name="pasture_type"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			pasture_type: pasture_type,
			pa_verified_status:dataValue,
			pagination:null
		};
		
		
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_submited_transect_data/<?php echo $this->uri->segment(3); ?>",
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
				// var lkp_market = response.lkp_market;
				// var lkp_transect_pastures = response.lkp_transect_pasture;
				// var lkp_lr_body_condition = response.lkp_lr_body_condition;
				// var lkp_sr_body_condition = response.lkp_sr_body_condition;
				// var lkp_animal_type = response.lkp_animal_type;
				// var lkp_animal_herd_type = response.lkp_animal_herd_type;
				// var lkp_food_groups = response.lkp_food_groups;
				// var lkp_transect_pasture = response.lkp_transect_pasture;
				// var lkp_dry_wet_pasture = response.lkp_dry_wet_pasture;
				// var lkp_transport_means = response.lkp_transport_means;

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
				// const markets = {};
				// for (let gn = 0; gn < lkp_market.length; gn++) {
				// 	const element = lkp_market[gn];
				// 	markets[element.market_id] = element.name;
				// }
				// const animaltypelactatings = {};
				// for (let vkey = 0; vkey < lkp_animal_type_lactating.length; vkey++) {
				// 	const element = lkp_animal_type_lactating[vkey];
				// 	animaltypelactatings[element.animal_type_lactating_id] = element.name;
				// }
				
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
				// const transportMeans = {};
				// for (let cp = 0; cp < lkp_transport_means.length; cp++) {
				// 	const element = lkp_transport_means[cp];
				// 	transportMeans[element.transport_id] = element.name;
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
				// xcelHeader.push("Contributor")
				// tableHeaderFields.push('first_name')
				// if(survey_id == 5 || survey_id == 7 || survey_id == 11){
				// 	xcelHeader.push("Market")
				// 	tableHeaderFields.push('market_name')
				// }else if(survey_id == 9 ){
				// 	xcelHeader.push("Transect Pastures")
				// 	tableHeaderFields.push('contributor_name')
				// }else{
				// 	xcelHeader.push("Respondent")
				// 	xcelHeader.push("Respondent HHID")
				// 	tableHeaderFields.push('respondent')
				// 	tableHeaderFields.push('hhid')
				// }
				
				
				xcelHeader.push(...['Country','UAI','Sub Location','Cluster']);
				tableHeaderFields.push(...['country_id','uai_id','sub_location_id','cluster_id']);
				xcelHeader.push("Pasture Name");
				tableHeaderFields.push('pasture_name')
				xcelHeader.push("Pasture Type");
				tableHeaderFields.push('pasture_type')

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
				tableHeaderFields.push(...['lat','lng','added_by','added_datetime','pa_verified_status']);


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
					exportToXcel("Transect Pastures", xcelData);
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