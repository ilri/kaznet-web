    <style>
        .table thead {
		color: white !important;
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
    .btn-reset-active {
    background: rgb(147, 148, 150);
    border-radius: 5px;
    margin-top: 25px;
    padding: 0px 35px;
    height: 40px;
    width: 130px;
}
.btn-submit-active {
    background: rgb(111, 27, 40);
    border-radius: 5px;
    margin-top: 25px;
    padding: 0px 35px;
    height: 40px;
    width: 130px;
}

	@keyframes rotation {
		from {
			transform: rotate(0deg);
		}

		to {
			transform: rotate(360deg);
		}
	}

    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item">
                            <a href="#">Task Management</a>
                        </li>
                        <li class="breadcrumb-item active">Task Contributor</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <!-- <h4 class="title"><?php echo($page_title); ?></h4> -->
                        <div class="row">
                            <?php
                             if($this->uri->segment(3)!=""){
                                $task_id=$this->uri->segment(3);
                            }else{
                                $task_id=0;
                            }
                            ?>
                            <div class="col-sm-12 col-md-10 col-lg-10">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Task<span class="text-danger"> *</span></label>
                                            <select class="form-control" id="task_id" name="task_id">
                                                <option value="">Select Task</option>
                                                <?php 
                                                foreach($tasks_list as $key => $task){
                                                    ?>
                                                    <option value="<?=$task['id'];?>" <?php if($task['id']==$task_id){ echo "selected";}?>><?=$task['title'];?></option>
                                            <?php  } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
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
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">UAI<?php $loginrole = $this->session->userdata('role');
												if($loginrole!=1){
													?>
													<span class="text-danger"> * </span>
												<?php }?></label>
                                            <select class="form-control" id="uai_id" name="uai_id">
                                                <option value="">Select UAI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text" >Sub Location</label>
                                            <select class="form-control" id="sub_location_id" name="sub_location_id">
                                                <option value="">Select Sub Location</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Cluster<?php 
												if($loginrole!=1){
													?>
												<span class="text-danger"> * </span>
												<?php }?></label>
                                            <select class="form-control" id="cluster_id" name="cluster_id">
                                                <option value="">Select Cluster</option>
                                                <!-- <?php 
                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                            <?php  } ?> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text" >Status</label>
                                            <select class="form-control" id="status_id" name="status_id" >
                                                <option value="">Select Status</option>
                                                <option value="1">Not Started</option>
                                                <option value="2">Active</option>
                                                <option value="3">Expired</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text" >Contributor</label>
                                            <select class="form-control" id="contributor_id" name="contributor_id" >
                                                <option value="">Select Contributor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group my-3">
                                            <label for="" class="label-text">Respondent</label>
                                            <select class="form-control" id="respondent_id" name="respondent_id">
                                                <option value="">Select Respondent</option>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2 text-center " style="display:grid;">
                                <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                                <button class="btn btn-submit-active text-white mt-55px get_data" disabled style="background-color:gray">Submit</button>
                            </div>
                        </div>
                        <?php echo form_open('', array('id' => 'moderateVerifyDataForm')); ?>        
                        <div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
                            
                            <div class="mt-10">
                            <?php if ($this->session->userdata('role') == 1) {?>
                                <button type="button" class="btn btn-sm btn-success verify hidden ml-2" data-status="2">Unassign</button>
                                <!-- <button type="button" class="btn btn-sm btn-danger verify hidden" data-status="3">Reject</button> -->
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
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
<script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>

<script type="text/javascript">
    var loginrole=<?php echo $this->session->userdata('role')?>;
    $(function(){
        <?php if($selectedTask) { ?>
            // $('#getTaskContributerForm').trigger('submit');
        <?php } ?>
    });
    $('.get_data').on('click', function(){
        getSubmitedDataView();
    });
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
                //get contributor List
				$.ajax('<?=base_url()?>reports/getContributorByCountry', {
					type: 'POST',  // http method
					data: { country_id: country_id },  // data to submit
					success: function (data) {
						$('#contributor_id').html(data);
					}
				});
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
    //     if(contributor_id != '')
    //     {
    //         $.ajax('<?=base_url()?>reports/getRespondentByContributor', {
    //             type: 'POST',  // http method
    //             data: { contributor_id: contributor_id },  // data to submit
    //             success: function (data) {
    //                 // $('#respondent_id').html(data);
    //             }
    //         });
    //     } 
	// 	else{
    //         // $('#contributor_id').html('<option value="">Select Contributor</option>');
    //         // $('#respondent_id').html('<option value="">Select Respondent</option>');
    //     }   
    // });

    // Define global variable ajaxData
    var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

    //Handle form reset
    $('body').on('reset', '#getTaskContributerForm', function(event) {
        setTimeout(function() {
            $('#getTaskContributerForm').trigger('submit');
        }, 100);
    });

    //Handle form submit
    // $('body').on('submit', '#getTaskContributerForm', function(event) {
    //     event.preventDefault();
    //     let form = $(this), task = $('[name="task"]');
        
    //     // $('tbody').html(`<tr>
    //     //     <td colspan="6" class="text-center task-info">Please wait. Getting task contributor details.</td>
    //     // </tr>`);
    //     // if(!task.val() || task.val().length == 0) {
    //     //     $('tbody').html(`<tr>
    //     //         <td colspan="6" class="text-center">Click on the filter and select a task to view details.</td>
    //     //     </tr>`);
    //     //     return false;
    //     // }
    //     var task_id ="";

    //     formData = new FormData(form[0]);
    //     var task1 = <?php echo $task_id?>;
        
    //     formData.append('task_id', task);
    //     form.find('button').prop('disabled', true);
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>survey/get_task_contributers',
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         complete: function(data) {
    //             var csrfData = JSON.parse(data.responseText);
    //             ajaxData[csrfData.csrfName] = csrfData.csrfHash;
    //             if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
    //                 $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
    //             }
    //             form.find('button').prop('disabled', false);
    //         },
    //         error: function() {
    //             form.find('button').prop('disabled', false);
    //             $('tbody').html(`<tr>
    //                 <td colspan="6" class="text-center task-danger">Could not establish connection to server. Please refresh the page and try again.</td>
    //             </tr>`);
    //         },
    //         success: function(data) {
    //             var data = JSON.parse(data);
    //             form.find('button').prop('disabled', false);

    //             // If session error exists
    //             if(data.session_err == 1) {
    //                 $('tbody').html(`<tr>
    //                     <td colspan="6" class="text-center task-danger">Session Error! ${data.msg}</td>
    //                 </tr>`);
    //                 return false;
    //             }

    //             if(data.status == 0) {
    //                 $('tbody').html(`<tr>
    //                     <td colspan="6" class="text-center task-danger">Unable to get task contributor details. Please use the filter again to get details.</td>
    //                 </tr>`);
    //                 return false;
    //             }

    //             if(data.status == 1) {
    //                 let HTML = ``;
    //                 for(let detail of data.contributor_list) {
    //                     HTML += `<tr>
    //                                 <td >${detail.assignee_id}</td>
    //                             </tr>`;
    //                 }
    //                 if(HTML == ``) HTML = `<tr>
    //                     <td colspan="6" class="text-center">Not task contributor details found.</td>
    //                 </tr>`;

    //                 $('tbody').html(HTML);
    //             }
    //         }
    //     });
    // });

    function getSubmitedDataView(pageNo =1, recordperpage = 100, search_input = null){
		
		var task_id = $('select[name="task_id"]').val();
		var country_id = $('select[name="country_id"]').val();
		var uai_id = $('select[name="uai_id"]').val();
		var sub_location_id = $('select[name="sub_location_id"]').val();
		var cluster_id = $('select[name="cluster_id"]').val();
		var contributor_id = $('select[name="contributor_id"]').val();
		// var respondent_id = $('select[name="respondent_id"]').val();
		var respondent_id = "";
		var status = $('select[name="status_id"]').val();
		// var survey_id = <?php echo $task_id ?>;
		
		
		var query_data = {
			country_id: country_id,
			uai_id: uai_id,
			sub_location_id: sub_location_id,
			cluster_id: cluster_id,
			contributor_id: contributor_id,
			respondent_id: respondent_id,
			status: status,
			survey_id: task_id,
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
			url: "<?php echo base_url(); ?>survey/get_task_contributers/<?php echo $task_id; ?>",
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
				// $('#export_sub').removeClass('hidden');
				// var role = response.user_role;
				var role = <?php echo $this->session->userdata('role')?>;
				// var fields = response.fields;
				var submitedData = response.submited_data;
				var task_type = response.task_type;
				// var lkp_country = response.lkp_country;
				// var lkp_cluster = response.lkp_cluster;
				// var lkp_uai = response.lkp_uai;
				// var lkp_sub_location = response.lkp_sub_location;
				// var lkp_location_type = response.lkp_location_type;
				// var lkp_animal_type_lactating = response.lkp_animal_type_lactating;
				// var respondent_name = response.respondent_name;

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background:black;">`;
				
				tableHead += `<th>S.No.</th>`;
				tableHead += `<th>Task Name</th>`;					
				tableHead += `<th>Country</th>`;				
				tableHead += `<th>Cluster</th>`;
				tableHead += `<th>UAI</th>`;
				tableHead += `<th>Sub Location</th>`;
				tableHead += `<th>Contributor</th>`;
                if(task_type == "Household Task"){
                    tableHead += `<th>Respondent</th>`;
                }else  if(task_type == "Rangeland Task"){
                    //empty
                }else if(task_type == "Market Task" ){
                    tableHead += `<th>Market</th>`;
                }
                
                
                tableHead += `<th>Status</th>`;
                tableHead += `<th>Start Date</th>`;
                tableHead += `<th>End Date</th>`;
                tableHead += `<th>Actions123</th>`;
                if ((role == 1 || role == 6)) {
					tableHead += `<th class="text-left" nowrap><input type="checkbox" class="checkall_sub"></th>`;
					// tableHead += `<th class="text-left" nowrap></th>`;
				}
				$('#submited_head').html(tableHead);

				$('#submited_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var assignee_id = submitedData[k]['assignee_id'];
						tableBody = `<tr class="`+assignee_id+` text-left" data-id="`+assignee_id+`">`;
						
						
						tableBody += `<td>`+ count++ +`</td>`;
						// if(role == 6){
						// 	tableBody += `<td class="text-center">`;
						// 	if(submitedData[k]['pa_verified_status'] == 1){
						// 		tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
						// 	}else if(submitedData[k]['pa_verified_status'] == 2){
						// 		tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
						// 	}else{
						// 		tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
						// 	}
						// 	tableBody += `</td>`;
						// } else{
						// 	tableBody += `<td class="text-center">`;
						// 	if(submitedData[k]['pa_verified_status'] == 1){
						// 		tableBody += `<i class="fa fa-2x fa-question-circle-o text-warning" aria-hidden="true"></i>`;
						// 	}else if(submitedData[k]['pa_verified_status'] == 2){
						// 		tableBody += `<i class="fa fa-2x fa-check-square-o text-success" aria-hidden="true"></i>`;
						// 	}else{
						// 		tableBody += `<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>`;
						// 	}
						// 	tableBody += `</td>`;
							
						// }
                        
						tableBody += `<td>`;
						if(submitedData[k]['task_name']){
							tableBody += submitedData[k]['task_name'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['country_name']){
							tableBody += submitedData[k]['country_name'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['cluster_name']){
							tableBody += submitedData[k]['cluster_name'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['uai_name']){
							tableBody += submitedData[k]['uai_name'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['location_name']){
							tableBody += submitedData[k]['location_name'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;

						tableBody += `<td>`;
						if(submitedData[k]['contributor_name']){
							tableBody += submitedData[k]['contributor_name'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
                        if(task_type == "Household Task"){
                
                            tableBody += `<td>`;
                            if(submitedData[k]['respondent_name']){
                                tableBody += submitedData[k]['respondent_name'];
                            }else{
                                tableBody +="N/A";
                            }
                            tableBody += `</td>`;
                        }else  if(task_type == "Rangeland Task"){
                        //empty
                        }else if(task_type == "Market Task" ){
                    
                            tableBody += `<td>`;
                            if(submitedData[k]['market_name']){
                                tableBody += submitedData[k]['market_name'];
                            }else{
                                tableBody +="N/A";
                            }
                            tableBody += `</td>`;
                            tableHead += `<th>Market</th>`;
                        }
						tableBody += `<td>`;
						if(submitedData[k]['status']){
							tableBody += submitedData[k]['status'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['start_date']){
							tableBody += submitedData[k]['start_date'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
						tableBody += `<td>`;
						if(submitedData[k]['end_date']){
							tableBody += submitedData[k]['end_date'];
						}else{
							tableBody +="N/A";
						}
						tableBody += `</td>`;
                        tableBody += `<td>`;
                        if(role == 1 || role == 6){
                            tableBody +="<a class='btn btn-outline-dark mt-0 unassign' href='javascript:void(0);' >Unassign</a>";
                        }else{
                            tableBody +="N/A";
                        }
                        tableBody += `</td>`;
                        if(role == 1 || role == 6){
                            tableBody +="<td><input type='checkbox' name='check_sub[]' value='"+submitedData[k]['assignee_id']+"'> </td>";
                        }
                        
						
						tableBody += `</tr>`;

						
						$('#submited_body').append(tableBody);
						
					}
				}else{
					$('#submited_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No Data Found</h5></td></tr>');
				}

				const curentPage = pageNo;
				const totalRecordsPerPage = recordperpage;
				const totalRecords= response.total_records;
				const currentRecords = submitedData.length;
				pagination.refreshPagination (Number(curentPage || 1),totalRecords,currentRecords, Number(totalRecordsPerPage || 100))

			}
		});
	}
    const onPagination = (event) => { 
		var keywords = "";
		getSubmitedDataView(+event.currentPage,+event.recordsPerPage,keywords);
		
  	}
      const pagination = new Pagination('#submited_pagination',onPagination);

      
// Delete user
$('body').on('click', '.unassign', function(event) {
  var elem = $(this);
  swal({
    title: "Are you sure?",
    text: "You want to unassign the task for this User?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, unassign it!"
  }, function() {
    elem.addClass('disabled');
    elem.html('Please Wait.... Unassign Task to User.');
    unassignUser(elem);
  });
});
function unassignUser(elem){
  ajaxData['assignee_id'] = elem.closest('tr').data('id');
  
  $.ajax({
    url: '<?php echo base_url(); ?>survey/unassign_task_user/',
    data: ajaxData,
    type: 'POST',
    dataType: 'json',
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
        icon: 'error'
      });
      elem.removeClass('disabled');
    //   elem.html('<i class="fa deleted" aria-hidden="true"></i> Delete');
    },
    success: function(data) {
      elem.removeClass('disabled');
    //   elem.html('<i class="fa deleted" aria-hidden="true"></i> Delete');
      
      if(data.status == 0) {
        $.toast({
          heading: 'Error!',
          text: data.msg,
          icon: 'error'
        });
        return false;
      }

      $.toast({
        heading: 'Success!',
        text: data.msg,
        icon: 'success',
        afterHidden: function () {
        //   window.location.reload();
        getSubmitedDataView();
        }
      });
    }
  });
}

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
        
        if(status == 2){
            swal({
                title: "Are you sure?",
                text: "You want to unassign the task for this User?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, unassign it!"
            }, function() {
                // elem.addClass('disabled');
                elem.html('Please Wait....');
                unassignMultipleUser(formData, status);
            });
            
        }else{
            unassignMultipleUser(formData, status);
        }
    });
    // $this->uri->segment(3)
    function unassignMultipleUser(formData, status) {
        $('body').find('button.verify').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url(); ?>survey/unassign_task_multiple_user/<?php echo $this->uri->segment(3); ?>',
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
                            // $('body').find('button.verify').prop('disabled', false);
                            $('body').find('button.verify').addClass('hidden');
                            $('body').find('button.verify').html('Unassign');
                            $('body').find('button.verify').prop('disabled', false);
                            getSubmitedDataView();
                            // var verifyText = '';
                            // if (status == 2) verifyText = '<i class="fa fa-2x fa-check-square-o text-success"></i>';
                            // if (status == 3) verifyText = '<i class="fa fa-2x fa-times text-danger"></i>';

                            // if (data.verified_role == 6) {
                            //     $('body').find('[name="check_sub[]"]:checked').each(function(index) {
                            //         $(this).parent().next().next().html(data.verified_by + " " + verifyText);
                            //         $(this).trigger('click');
                            //     });
                            // }
                            // if (data.verified_role == 7) {
                            //     $('body').find('[name="check_sub[]"]:checked').each(function(index) {
                            //         // $(this).parent().next().next().html(verifyText);
                            //         $(this).parent().next().next().next().html(data.verified_by + " " + verifyText);
                            //         $(this).trigger('click');
                            //     });
                            // } else {
                            //     $('body').find('[name="check_sub[]"]:checked').each(function(index) {
                            //         $(this).parent().next().next().next().html(data.verified_by + " " + verifyText);
                            //         $(this).trigger('click');
                            //     });
                            // }
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