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
    #export_sub_task{
		background-color: rgb(111, 27, 40);
		color:#fff;
	}
	#export_sub_task:hover{
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
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
				?>
            <div class="col-sm-12 col-md-12 col-lg-12 ">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <!-- <li class="breadcrumb-item"><a href="#">Survey Data</a></li> -->
                        <li class="breadcrumb-item active">Payment Report</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="title">Payment Report</h4>
                        <div class="row">
                            <div class="col-sm-12 col-md-10 col-lg-10">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group ">
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
                                        <div class="form-group ">
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
                                        <div class="form-group ">
                                            <label for="" class="label-text" >Sub Location</label>
                                            <select class="form-control" id="sub_location_id" name="sub_location_id">
                                                <option value="">Select Sub Location</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group ">
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
                                        <div class="form-group ">
                                            <label for="" class="label-text" >Contributor</label>
                                            <select class="form-control" id="contributor_id" name="contributor_id" >
                                                <option value="">Select Contributor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group ">
                                            <label for="" class="label-text">Respondent</label>
                                            <select class="form-control" id="respondent_id" name="respondent_id">
                                                <option value="">Select Respondent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group ">
                                            <label for="" class="label-text">Survey Start Date</label>
                                            <input type="date" name="start_date_5" id="txtFromDate" class="form-control" placeholder="Date" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group ">
                                        <label for="" class="label-text">Survey End Date</label>
                                        <input type="date" name="end_date_5" id="txtToDate" class="form-control" placeholder="Date" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group ">
                                            <label class="label-text">Task Name <span class="text-danger">*</span></label>
                                            <!-- <select class="form-control" name="task">
                                                <option value="" selected="true">....Select....</option>
                                            </select> -->
                                            <select class="form-control selectpicker" name="tasks[]" id="mySelect" title="Search and select task(s)" data-live-search="true" data-actions-box="true" multiple>
                                            </select>
                                            <span class="error d-block"></span>
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

           
                <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                    <ul class="nav nav-tabs border-bottom-0 bg-transparent" id="dataTabId"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active disabledTab" id="Approved-tab" data-toggle="tab"
                                data-target="#Approved" type="button" role="tab"
                                aria-controls="Approved" aria-selected="true">Contributors</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  disabledTab" id="Submitted-tab" data-toggle="tab"
                                data-target="#Submitted" type="button" role="tab"
                                aria-controls="Submitted" aria-selected="false">Tasks</button>
                        </li>
                        
                    </ul>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Approved" role="tabpanel"
                        aria-labelledby="Approved-tab">
                        <?php echo form_open('', array('id' => 'moderateVerifyDataForm')); ?>
                            <div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
                                <div class="input_place p-2 hidden" id="text_approved_search">
                                    <div class="ml-auto">
                                    <input type="text" id="user_approved_search" class="search form-control submited_search" placeholder="(Search on Name, Last name)">
                                    <span class="search_icon" onClick="searchApprovedFilter();"><i class="fa fa-search text-white"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-12 export_align">
                                    <button type="button" class="btn btn-sm hidden"  id="export_sub" onclick="exportXcel()">Export data</button>
                                </div>
                                <!-- <button type="button" class="btn btn-sm btn-primary hidden"  id="export_sub" onclick="exportXcel()">Export data</button> -->
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
                                    <thead class="bg-dataTable" id="approved_head">
                                    </thead>
                                    <tbody id="approved_body">
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="submited_pagination" id="approved_pagination"></div>
                        <?php echo form_close(); ?>
                        </div>
                        <div class="tab-pane fade " id="Submitted" role="tabpanel"
                            aria-labelledby="Submitted-tab">
                            <div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
                                <span class="p-2 input_place hidden" id="text_submit_search">
                                    <div class="ml-auto">
                                    <input type="text" id="user_submit_search" class="search form-control approved_search" placeholder=" (Search on First Name, User Name) ">
                                    <span class="search_icon" onClick="searchSumitedFilter();"><i class="fa fa-search text-white"></i></span>
                                    </div>
                                </span>
                                <div class="col-md-12 export_align">
                                    <button type="button" class="btn btn-sm hidden"  id="export_sub_task" onclick="exportXcel_task()">Export data</button>
                                </div>
                                <!-- <button type="button" class="btn btn-sm btn-primary" id="export_ap" onclick="approvedeExportXcel()">Export data</button> -->
                            </div>
                            <div class="table-responsive" style="height:290px;">
                                <table class="table table-striped" style="width:100%">
                                    <thead class="bg-dataTable" id="submited_head">
                                    </thead>
                                    <tbody id="submited_body">
                                    </tbody>
                                </table>
                            </div>
                            <div id="submited_pagination" class="submited_pagination"></div>
                        </div>
                        
                    </div>
                </div>
            
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
<script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>

<!-- <script src="<?php echo base_url(); ?>include/assets/js/bootstrap-select.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script>
    // $(function() {
	// 	$('.get_data').trigger('click');
	// });
    $(document).ready(function(){
        $('.selectpicker').selectpicker();
        get_all_tasks();
        $("#txtFromDate").datepicker({
            numberOfMonths: 2,
            onSelect: function(selected) {
            $("#txtToDate").datepicker("option","minDate", selected)
            }
        });
        $("#txtToDate").datepicker({ 
            numberOfMonths: 2,
            onSelect: function(selected) {
            $("#txtFromDate").datepicker("option","maxDate", selected)
            }
        });  
    });
    var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };
    function get_all_tasks(){
        let task=null;
        task = $('[name="tasks[]"]');
        task.empty();
        task.selectpicker('refresh');
        ajaxData['task_type'] = null;
        $.ajax({
            url: '<?php echo base_url(); ?>survey/get_all_tasks',
            type: 'POST',
            dataType : 'json',
            data: ajaxData,
            // complete: function(data) {
            //     $('#assignTaskForm').find('button[type="submit"]').html('Assign Task');
            //     var csrfData = JSON.parse(data.responseText);
            //     ajaxData[csrfData.csrfName] = csrfData.csrfHash;
            //     if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
            //         $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
            //     }
            // },
            error: function() {
                $.toast({
                    heading: 'Network Error!',
                    text: 'Could not establish connection to server. Please refresh the page and try again.',
                    icon: 'error',
                    // afterHidden: function () {
                    //     $('#assignTaskForm').find('button[type="submit"]').prop('disabled', false);
                    // }
                });
            },
            success: function(response) {
                

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

                
            }
        });
    }
	$('.get_data').on('click', function(){
		let tabId = $("#dataTabId .active").attr("id");
		switch (tabId) {
			case 'Submitted-tab':
				getSubmitedDataView();
				break;
			case 'Approved-tab':
				getAprovedDataView();
				break;
		
			default:
				break;
		}
	})

	$('#Submitted-tab').on('click', function(){
		getSubmitedDataView();
	});
	$('#Approved-tab').on('click', function(){
		getAprovedDataView();
	});
    function getSubmitedDataView(pageNo =1, recordperpage = 100, search_input = null){
		
		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var respondent_id = $('select[name="respondent_id"]').val();
        var start_date=$('input[name="start_date_5"]').val();
        var end_date=$('input[name="end_date_5"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;
		
        var tasks =[];
        tasks = $('#mySelect').val();
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
            start_date : start_date,
            end_date : end_date,
            tasks : tasks,
			// survey_id: survey_id,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
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
            url: "<?php echo base_url(); ?>reports/get_payment_report_tasks/",
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
                // $('#text_submit_search').removeClass('hidden');
                // $('#aprove_all_btn').removeClass('hidden');
                $('#export_sub_task').removeClass('hidden');
                // var role = response.user_role;
                // var fields = response.fields;
                var submitedData = response.surveys_tasks;
                // var lkp_country = response.lkp_country;
                // var lkp_cluster = response.lkp_cluster;
                // var lkp_uai = response.lkp_uai;
                // var lkp_sub_location = response.lkp_sub_location;
                // var lkp_location_type = response.lkp_location_type;
                // var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
                // var respondent_name = response.respondent_name;

                var td_count = 0;
                var tableHead = `<tr style="position: sticky;top: -1px;z-index: 999;background-color: #2A2C36;background:black;">`;                
                tableHead += `<th>S.No.</th>`;
                tableHead += `<th>Task Name</th>`;					
                tableHead += `<th>Payment Amount</th>`;				
                tableHead += `<th>Approved</th>`;
                tableHead += `<th>Submitted </th>`;
                tableHead += `<th>Rejected </th>`;

                $('#submited_head').html(tableHead);

                $('#submited_body').html("");
                
                if(submitedData.length > 0){
                    var tableBody ="";
                    var tempAmt = 0;
                    var tempsubmt = 0;
                    var tempreject = 0;
                    var count = (pageNo*recordperpage-recordperpage+1);
                    for (let k = 0; k < submitedData.length; k++) {
                        var id = submitedData[k]['id'];
                        tableBody = `<tr class="`+id+` text-left" data-id="`+id+`">`;                 
                        
                        tableBody += `<td>`+ count++ +`</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['title']){
                            tableBody += submitedData[k]['title'];
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['payment_amount']){
                            tableBody += submitedData[k]['payment_amount'];
                            tempAmt =  tempAmt + submitedData[k]['payment_amount'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['approved']){
                            tableBody += submitedData[k]['approved'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['submitted']){
                            tableBody += submitedData[k]['submitted'];
                            tempsubmt = tempsubmt + submitedData[k]['submitted'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['rejected']){
                            tableBody += submitedData[k]['rejected'];
                            tempreject = tempreject + submitedData[k]['rejected'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;                        
                        tableBody += `</tr>`;                        
                        $('#submited_body').append(tableBody);                        
                    }
                    $('#overlay').fadeOut();
					$('#loader').fadeOut();
                    if(tempAmt == 0 && tempsubmt == 0 && tempreject == 0){
                        $('#export_sub_task').addClass('hidden');
                    }
                }else{
                    
                    $('#submited_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
                    $('#overlay').fadeOut();
					$('#loader').fadeOut();
                }
				const curentPage = pageNo;
				const totalRecordsPerPage = recordperpage;
				const totalRecords= response.total_records;
				const currentRecords = submitedData.length;
				pagination.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100));
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
        var start_date=$('input[name="start_date_5"]').val();
        var end_date=$('input[name="end_date_5"]').val();
		// var survey_id = <?php echo $this->uri->segment(3); ?>;

        var tasks =[];
        tasks = $('#mySelect').val();
        // var tasks=null;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
            start_date : start_date,
            end_date : end_date,
            tasks : tasks,
			// survey_id: survey_id,
			pagination:{pageNo,recordperpage},
			search: {
				search_input
			}
		};
		$("#info_data").css("display","none");
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
            url: "<?php echo base_url(); ?>reports/get_payment_report_contributors/",
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
                // $('#text_submit_search').removeClass('hidden');
                // $('#aprove_all_btn').removeClass('hidden');
                $('#export_sub').removeClass('hidden');
                // var role = response.user_role;
                // var fields = response.fields;
                var submitedData = response.contributor_list;
                
                // var lkp_country = response.lkp_country;
                // var lkp_cluster = response.lkp_cluster;
                // var lkp_uai = response.lkp_uai;
                // var lkp_sub_location = response.lkp_sub_location;
                // var lkp_location_type = response.lkp_location_type;
                // var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
                // var respondent_name = response.respondent_name;

                var td_count = 0;
                var tableHead = `<tr style="position: sticky;top: -1px;z-index: 999;background-color: #2A2C36;background:black;">`;                
                tableHead += `<th>S.No.</th>`;
                tableHead += `<th>Contributor UserName</th>`;
                tableHead += `<th>Contributor Status</th>`;
                tableHead += `<th>Contributor Name</th>`;
                tableHead += `<th>Task Name </th>`;
                tableHead += `<th>Submitted </th>`;
                tableHead += `<th>Approved</th>`;
                tableHead += `<th>Rejected </th>`;				
                tableHead += `<th>Task Amount</th>`;				
                tableHead += `<th>Transport</th>`;				
                tableHead += `<th>Internet bundles</th>`;				
                tableHead += `<th>Payment Amount</th>`;				
                tableHead += `<th>MPesa Number</th>`;				
                tableHead += `<th>Bank Name</th>`;	
                tableHead += `<th>Account Number</th>`;	

                $('#approved_head').html(tableHead);

                $('#approved_body').html("");
                // var submitedusertasksData = "";
                if(submitedData.length > 0){
                    var tableBody ="";
                    // var count = (pageNo*recordperpage-recordperpage+1);
                    var count = 1;
                    for (let k = 0; k < submitedData.length; k++) {
                        var id = submitedData[k]['user_id'];
                        var tasktableBody ="";
                        var tasklistcount = 0;
                        var contributorStatus = "";
                        var submitedusertasksData = submitedData[k]['usertasksData'];
                        //getting contributor status
                        switch (submitedData[k]['status']) {
                            case '1':
                                contributorStatus="Active";
                                break;

                            case '2':
                                contributorStatus="Rejected";
                                break;
                                
                            case '0':
                                contributorStatus="Inactive";
                                break;
                        
                            default:
                                contributorStatus="N/A";
                                break;
                        }
                        if(submitedusertasksData.length > 0){
                            for (let j = 0; j < submitedusertasksData.length; j++) {
                                // tasklistcount++;
                                
                                
                                tasktableBody += `<tr class="`+id+`_`+j+` text-left" data-id="`+id+`_`+j+`">`;                 
                                tasktableBody += `<td>`+ count++ +`</td>`;
                                tasktableBody += `<td>`;
                                if(submitedData[k]['username']){
                                    tasktableBody += submitedData[k]['username'];
                                }else{
                                    tasktableBody +="N/A";
                                }
                                tasktableBody += `</td>`;
                                
                                tasktableBody += `<td>`+ contributorStatus +`</td>`;
                                tasktableBody += `<td>`;
                                if(submitedData[k]['contributor_name']){
                                    tasktableBody += submitedData[k]['contributor_name'];
                                }else{
                                    tasktableBody +="N/A";
                                }
                                tasktableBody += `</td>`;
                                tasktableBody += `<td>`;
                                    if(submitedusertasksData[j]['title']){
                                        tasktableBody += submitedusertasksData[j]['title'];
                                    }else{
                                        tasktableBody +="N/A";
                                    }
                                tasktableBody += `</td>`;
                                
                                tasktableBody += `<td>`;
                                if(submitedusertasksData[j]['submitted']){
                                    tasktableBody += submitedusertasksData[j]['submitted'];
                                }else{
                                    tasktableBody +="0";
                                }
                                tasktableBody += `</td>`;
                                tasktableBody += `<td>`;
                                if(submitedusertasksData[j]['approved']){
                                    tasktableBody += submitedusertasksData[j]['approved'];
                                }else{
                                    tasktableBody +="0";
                                }
                                tasktableBody += `</td>`;
                                
                                tasktableBody += `<td>`;
                                if(submitedusertasksData[j]['rejected']){
                                    tasktableBody += submitedusertasksData[j]['rejected'];
                                }else{
                                    tasktableBody +="0";
                                }
                                tasktableBody += `</td>`; 
                                tasktableBody += `<td>`;
                                if(submitedusertasksData[j]['payment_amount']){
                                    tasktableBody += submitedusertasksData[j]['payment_amount'];
                                }else{
                                    tasktableBody +="0";
                                }
                                tasktableBody += `</td>`;
                                tasktableBody += `<td>N/A</td>`; 
                                tasktableBody += `<td>N/A</td>`; 
                                tasktableBody += `<td>N/A</td>`; 
                                tasktableBody += `<td>N/A</td>`; 
                                tasktableBody += `<td>N/A</td>`; 
                                tasktableBody += `<td>N/A</td>`; 
                                tasktableBody += `</tr>`;
                                ;
                            }
                        }
                        tableBody = tasktableBody;
                        var totalamt = 0;
                        totalamt = parseInt(submitedData[k]['payment_amount']);
                        if(country_id==1){
                            totalamt = totalamt + 2300;
                        }else{
                            totalamt = totalamt + 1800;
                        }
                        tableBody += `<tr class="`+id+` text-left" data-id="`+id+`">`;                 
                        // count++
                        tableBody += `<td>`+  count++ +`</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['username']){
                            tableBody += submitedData[k]['username'];
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`+  contributorStatus +`</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['contributor_name']){
                            tableBody += submitedData[k]['contributor_name'];
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>N/A</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['submitted']){
                            tableBody += submitedData[k]['submitted'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['approved']){
                            tableBody += submitedData[k]['approved'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        
                        tableBody += `<td>`;
                        if(submitedData[k]['rejected']){
                            tableBody += submitedData[k]['rejected'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`; 
                        tableBody += `<td>`;
                        if(submitedData[k]['task_amount']){
                            
                            tableBody += submitedData[k]['task_amount'];
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        //static for now as given by client and gaythri confirmed
                        if(country_id==1){
                            tableBody += `<td>`;
                                tableBody +="1500";
                            tableBody += `</td>`;
                            tableBody += `<td>`;
                                tableBody +="800";
                            tableBody += `</td>`;
                        }else{
                            tableBody += `<td>`;
                                tableBody +="1200";
                            tableBody += `</td>`;
                            tableBody += `<td>`;
                                tableBody +="600";
                            tableBody += `</td>`;
                        }
                        
                        //upto here static
                        

                        tableBody += `<td>`;
                        // if(submitedData[k]['payment_amount']){                            
                        //     tableBody += submitedData[k]['payment_amount'];
                        if(totalamt){                            
                            tableBody += totalamt;
                        }else{
                            tableBody +="0";
                        }
                        tableBody += `</td>`;
                        //added 2 new columns
                        tableBody += `<td>`;
                        if(submitedData[k]['mpesa_id']){
                            
                            tableBody += submitedData[k]['mpesa_id'];
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;

                        tableBody += `<td>`;
                        if(submitedData[k]['bank_name']){
                            
                            tableBody += submitedData[k]['bank_name'];
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(submitedData[k]['account_number']){
                            
                            tableBody += submitedData[k]['account_number'];
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;

                                               
                        tableBody += `</tr>`;                        
                        $('#approved_body').append(tableBody);                        
                    }
                    $('#overlay').fadeOut();
					$('#loader').fadeOut();
                }else{
                    $('#approved_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
                    $('#overlay').fadeOut();
                    $('#loader').fadeOut();
                    $('#export_sub').addClass('hidden');
                }
				const curentPage = pageNo;
				const totalRecordsPerPage = recordperpage;
				// const totalRecords= response.total_records;
				// const currentRecords = submitedData.length;
                count--;
                const totalRecords= count;
				const currentRecords = count;
				pagination1.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100));
                // const totalRecords= count;
				// const currentRecords = count;
				// let curentPage = pageNo
				// let totalRecordsPerPage = recordperpage
				// if(pageNo == 1){
				// 	curentPage = submitedData.length === 0 ? 0 : pageNo;
				// }
				// if(recordperpage == 100){
				// 	totalRecordsPerPage = submitedData.length === 0 ? 0 : recordperpage;
				// }
				// if(submitedData.length === 0){
				// 	document.getElementById('submited_pagination').style.display = 'none';
				// } else{
				// 	document.getElementById('submited_pagination').style.display = 'flex';
				// 	pagination1.refreshPagination (Number(curentPage),totalRecords,currentRecords, Number(totalRecordsPerPage))
				// }
			}
		});
		
	}
    

	

    const onPagination = (event) => { 
		var keywords = "";
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
		getApprovedDataView(1, 100, keywords1);
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
	// const pagination2 = new Pagination('#rejected_pagination',onPagination2);
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
            // var loginrole=<?php echo $this->session->userdata('role')?>;
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
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
        var start_date=$('input[name="start_date_5"]').val();
        var end_date=$('input[name="end_date_5"]').val();		
		var tasks =[];
        tasks = $('#mySelect').val();

		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
            tasks : tasks,
            start_date : start_date,
            end_date : end_date,
			pagination:null
		};
        $('#overlay').fadeIn();
        $('#loader').fadeIn();
		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_payment_report_contributors/",
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
				var submitedData = response.contributor_list;				
                

				let xcelData = [];
				let xcelHeader = [];
				let tableHeaderFields = [];
				
				xcelHeader.push("S.No.")
				tableHeaderFields.push('sno')

				xcelHeader.push(...['CONTRIBUTOR USER NAME','CONTRIBUTOR STATUS','CONTRIBUTOR NAME','TASK NAME','SUBMITTED','APPROVED','REJECTED','TASK AMOUNT','TRANSPORT','INTERNET BUNDLES','PAYMENT AMOUNT','MPESA NUMBER','BANK NAME','ACCOUNT NUMBER']);


				tableHeaderFields.push(...['username','status','contributor_name','added_by','submitted','approved','rejected','task_amount','transport','int_bundles','payment_amount','mpesa_id','bank_name','account_number']);
				

                let tamount = 0;
                var totalamt = 0;
				if(submitedData.length > 0){
					const xcelBody = [];
					// var tableBody ="";
					let recordcount=1;
					for (let i=0; i<submitedData.length; i++){
						const elemnt = submitedData[i];
                        const row = [];
                        var userTasksData = submitedData[i]['usertasksData'];
                        //getting contributor status
                        switch (submitedData[i]['status']) {
                            case '1':
                                contributorStatus="Active";
                                break;
                        
                            case '0':
                                contributorStatus="Inactive";
                                break;
                        
                            case '2':
                                contributorStatus="Rejected";
                                break;
                        
                            default:
                                contributorStatus="N/A";
                                break;
                        }
                        if(userTasksData.length > 0){                            
                            for (let j=0; j<userTasksData.length; j++){
                                const taskElement = userTasksData[j];
                                const taskRow = [];
                                // recordcount++
                                var userName = elemnt['username'] || elemnt['username'] || 'N/A';
                                // userName = userName +' ('+contributorStatus+')';
                                taskRow.push(recordcount++);
                                taskRow.push(userName);
                                taskRow.push(contributorStatus);
                                taskRow.push(elemnt['contributor_name'] || elemnt['contributor_name'] || 'N/A');
                                taskRow.push(taskElement['title'] || taskElement['title'] || 'N/A');
                                taskRow.push(taskElement['submitted'] || taskElement['submitted'] || '0');
                                taskRow.push(taskElement['approved'] || taskElement['approved'] || '0');
                                taskRow.push(taskElement['rejected'] || taskElement['rejected'] || '0');
                                taskRow.push(taskElement['payment_amount'] || taskElement['payment_amount'] || '0');
                                taskRow.push('N/A');
                                taskRow.push('N/A');
                                taskRow.push('N/A');
                                taskRow.push('N/A');
                                taskRow.push('N/A');
                                taskRow.push('N/A');
                                // row.push(taskRow);
                                xcelBody.push(taskRow);
                            }
                        }
                        // recordcount++;
                        elemnt.sno = recordcount++;
						// row[] = row.concat(taskRow);
						for (let k = 0; k < tableHeaderFields.length; k++) {
							const key = tableHeaderFields[k];
                            switch (key) {
                                case 'username':
                                    row.push(userName || userName || 'N/A');
                                    break;

                                case 'status':
                                    row.push(contributorStatus || contributorStatus || 'N/A');
                                    break;
                            
                                case 'added_by':
                                    row.push('N/A');
                                    break;
                            
                                case 'transport':
                                    if(country_id==1){
                                        row.push('1500');
                                    }else{
                                        row.push('1200');
                                    }
                                    break;

                                case 'int_bundles':
                                    if(country_id==1){
                                        row.push('800');
                                    }else{
                                        row.push('600');
                                    }
                                    break;

                                case 'payment_amount':
                                    totalamt = 0;
                                    totalamt = parseInt(elemnt[key]);
                                    if(country_id==1){
                                        totalamt = totalamt + 2300;
                                    }else{
                                        totalamt = totalamt + 1800;
                                    }
                                    row.push(totalamt);
                                    break;
                            
                                default:
                                    row.push(elemnt[key] || elemnt[key] || 'N/A');
                                    break;
                            }
                            // if(key=='added_by'){
                            //     row.push('N/A');
                            // }else{
                            //     row.push(elemnt[key] || elemnt[key] || 'N/A');
                            // }
                                
						}
						xcelBody.push(row);
					}
					xcelData.push(xcelHeader)
					xcelData.push(...xcelBody)
					exportToXcel("Contributors_Payment_report", xcelData);
					$("#export_sub").prop('disabled', false);
                	$("#export_sub").html("Export data");
                    $('#overlay').fadeOut();
					$('#loader').fadeOut();
				}else{
					// comment
                    $('#overlay').fadeOut();
					$('#loader').fadeOut();
				}
			}
		});		
	}
    function exportToXcel_task(name,data){
		const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, name);
        XLSX.writeFile(wb, name+'.xlsx');
	}
	function exportXcel_task() {
		$("#export_sub_task").prop('disabled', true);
        $("#export_sub_task").html("Please wait ...");

		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		var respondent_id = $('select[name="respondent_id"]').val();
        var start_date=$('input[name="start_date_5"]').val();
        var end_date=$('input[name="end_date_5"]').val();	
        var tasks =[];
        tasks = $('#mySelect').val();	
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
            tasks : tasks,
            start_date : start_date,
            end_date : end_date,
			pagination:null
		};

		$.ajax({
			url: "<?php echo base_url(); ?>reports/get_payment_report_tasks/",
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
				var submitedData = response.surveys_tasks;				

				let xcelData = [];
				let xcelHeader = [];
				let tableHeaderFields = [];
				
				xcelHeader.push("S.No.")
				tableHeaderFields.push('sno')
                
				xcelHeader.push(...['TASK NAME','PAYMENT AMOUNT','APPROVED','SUBMITTED','REJECTED']);

				tableHeaderFields.push(...['title','payment_amount','approved','submitted','rejected']);

                let tamount = 0;
				if(submitedData.length > 0){
					const xcelBody = [];
					// var tableBody ="";
					
					for (let i=0; i<submitedData.length; i++){
						const elemnt = submitedData[i];
						const row = [];
						elemnt.sno = i+1;
						for (let k = 0; k < tableHeaderFields.length; k++) {
							const key = tableHeaderFields[k];
                            row.push(elemnt[key] || elemnt[key] || 'N/A');
                                
						}
						xcelBody.push(row);
					}
					xcelData.push(xcelHeader)
					xcelData.push(...xcelBody)
					exportToXcel_task("Tasks_Payment_report", xcelData);
					$("#export_sub_task").prop('disabled', false);
                	$("#export_sub_task").html("Export data");
				}else{
					// comment
				}
			}
		});		
	}
</script>
