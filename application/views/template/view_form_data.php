<!-- <div class="container mt-5"> -->
        <!-- <h1>Details</h1> -->
        <!-- <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-primary" style="border-bottom: 1px solid;">Sl No</th>
                    <?php foreach ($submitted_data['columns'] as $key => $col) { ?>
                    <th class="text-primary" style="border-bottom: 1px solid;"><?php echo $col['label']; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($submitted_data['data']) >1){
                    foreach ($submitted_data['data'] as $dkey => $d) { ?>
                    <tr>
                        <td><?php echo ($dkey + 1); ?></td>
                        <?php foreach ($submitted_data['columns'] as $key => $col) { ?>
                        <td><?php echo $d[$col['name']]; ?></td>
                        <?php } ?>
                    </tr>
                    <?php 
                    } 
                }else{
                    ?>
                    <tr>
                        <td colspan="<?php echo count($submitted_data['columns'])+1;?>" class="text-center"><p style="color:red">No data entered to display</p></td>
                    </tr>
                    <?php 
                }
                ?>
            </tbody>
        </table> -->
    <!-- </div> -->
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
	<div class="container mt-5">
		<!-- <h3>View Form :</h3> <br/> -->
		<h5><?php echo $form_title?></h5>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="dataview" role="tabpanel"
								aria-labelledby="dataview-tab">
					<div class="row">
						<div class="col-sm-10 col-md-10 col-lg-10 mb-3">
							<ul class="nav nav-tabs border-bottom-0 bg-transparent" id="dataTabId"
								role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active disabledTab" id="Submitted-tab" data-toggle="tab"
										data-target="#Submitted" type="button" role="tab"
										aria-controls="Submitted" aria-selected="false">Details</button>
								</li>
								
							</ul>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="Submitted" role="tabpanel"
								aria-labelledby="Submitted-tab">
									<?php echo form_open('', array('id' => 'moderateVerifyDataForm')); ?>
										<!-- <div class="col-md-12 export_align">
											<button type="button" class="btn btn-sm hidden"  id="export_sub" data-tabvalue=1 onclick="exportXcel(event)">Export data</button>
										</div> -->
										<!-- <div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
											<div class="mt-10">
											<?php if ($this->session->userdata('role') == 6) {?>
												<button type="button" class="btn btn-sm btn-success verify hidden ml-2" data-status="2">Approve</button>
												<button type="button" class="btn btn-sm btn-danger verify hidden" data-status="3">Reject</button>
											<?php } ?>
											</div>
										</div> -->
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
		</div>
	
    <script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
<script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>
<script>
    $(document).ready(function(){
        getSubmitedDataView();
    });
    // Function to map values to labels
    function mapValuesToLabels(data, options) {
        return data.map(value => {
            let option = options.find(opt => opt.value === value);
            return option ? option.label : value;
        });
    }
    function isArrayEmpty(arr) {
        // Check if arr is an array, and if not, return false or handle accordingly
        if (!Array.isArray(arr)) {
            return false; // or you could return true if you consider non-arrays "empty"
        }

        // Now safely use every method on the array
        return arr.length === 0 || arr.every(item => item === "");
    }
	function isArrayEmptyOrNull(arr) {
		// Check if the array is null, undefined, or has a length of 0
		return arr == null || arr.length === 0;
	}
    function getSubmitedDataView(pageNo =1, recordperpage = 100, search_input = null){
		var survey_id=<?php echo $this->uri->segment(3); ?>;
		var query_data = {
			survey_id: survey_id,
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
			url: "<?php echo base_url(); ?>FormController/get_form_data/<?php echo $this->uri->segment(3); ?>",
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
				var role = response.user_role;
				var fields = response.columns;
				var submitedData = response.data;
				var formdetails = JSON.parse(response.formdetails[0].form_data);

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				tableHead += `<th>S.No.</th>`;
				for (const key in fields) {
					const label = fields[key]['label'];
					const type = fields[key]['type'];
					if(label != "Declaration" && type !="paragraph"){ //added by sagar to skip paragraph in display
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
                tableHead += `<th>Uploaded By</th>`;
                tableHead += `<th>Uploaded Date</th>`;
				$('#submited_head').html(tableHead);

				$('#submited_body').html("");
				
				if(submitedData.length > 0){
					var tableBody ="";
                    var displayData = "";
                    var fieldOPtions = "";
					var count = (pageNo*recordperpage-recordperpage+1);
					for (let k = 0; k < submitedData.length; k++) {
						var data_id = submitedData[k]['id'];
						tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
						
						tableBody += `<td>`+ count++ +`</td>`;
						
						for (let key = 0; key < fields.length; key++) {
							const label = fields[key]['label'];
							// const field = 'field_'+fields[key]['field_id'];
							const field = fields[key]['name'];
							const type = fields[key]['type'];
							const multiple = fields[key]['multiple'];
                            displayData = "";
                            if(type=="checkbox-group" || type=="radio-group" || type=="select" || type=='autocomplete'){
                                for (let key1 = 0; key1 < formdetails.length; key1++) {
                                    if(formdetails[key1]['name'] == field){
                                        fieldOPtions = formdetails[key1]['values'];
                                    }
                                }
                                if(type=="checkbox-group"){
									// alert(JSON.parse(submitedData[k][field]));
                                    // if (isArrayEmpty(JSON.parse(submitedData[k][field]))) {
                                    if (isArrayEmptyOrNull(JSON.parse(submitedData[k][field]))) {
                                        displayData = "N/A";
                                    }else{
                                        displayData = mapValuesToLabels(JSON.parse(submitedData[k][field]), fieldOPtions);
                                    }
                                }else{
                                    // Ensure data is an array
                                    if (!Array.isArray(submitedData[k][field])) {
                                        submitedData[k][field] = [submitedData[k][field]]; // Wrap the single object in an array
                                    }
									if(multiple){ // check if multiple
										// if (isArrayEmpty(JSON.parse(submitedData[k][field])) ) {
										if (isArrayEmptyOrNull(JSON.parse(submitedData[k][field])) ) {
											displayData = "N/A";
										}else{
											// displayData = mapValuesToLabels(submitedData[k][field], fieldOPtions);
											displayData = mapValuesToLabels(JSON.parse(submitedData[k][field]), fieldOPtions);
										}
									}else{ // check if single
										// if (isArrayEmpty(submitedData[k][field]) ) {
										if (isArrayEmptyOrNull(submitedData[k][field])) {
											displayData = "N/A";
										}else{
											// displayData = mapValuesToLabels(submitedData[k][field], fieldOPtions);
											displayData = mapValuesToLabels(submitedData[k][field], fieldOPtions);
										}
									}
                                }

                            }
                            if(label != "Declaration" && type !="paragraph"){ //added by sagar to skip paragraph in display
                                tableBody += `<td>`;
                                if(type=="checkbox-group" || type=="radio-group" || type=="select" || type=='autocomplete'){
                                    tableBody +=(displayData == null ? `N/A` :displayData);
                                    // tableBody += (submitedData[k][field] == null ? `N/A` : submitedData[k][field] );
                                }else{
                                    tableBody += (submitedData[k][field] == null ? `N/A` : submitedData[k][field] );
                                }
                                tableBody += `</td>`;
                            }
							// if(label != "Declaration"){
								// if (type == 'file') {
								// 	tableBody += `<td>`;
								// 		if(submitedData[k][field] != null){
											
								// 			tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Image</a>`;
											
								// 		}else{
								// 			tableBody += 'N/A';
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'group') {
								// 	tableBody += `<td><a class="text-primary" target="_blank" href="<?php echo base_url(); ?>reports/groupData/<?php echo $this->uri->segment(3)?>/`+ fields[key]['field_id']+`/`+ submitedData[k]['data_id'] +`">View Data</a></td>`;
								// }else if (type == 'lkp_country') {
								// 	tableBody += `<td>`;
								// 		for (ckey in lkp_country){
								// 			if(submitedData[k][field]){
								// 				if(lkp_country[ckey]['country_id'] == submitedData[k][field]){
								// 					tableBody += `<img src="<?php echo base_url(); ?>include/assets/images/${lkp_country[ckey]['name']}-flag.svg">   `+lkp_country[ckey]['name'];
								// 				}
								// 			}
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_cluster') {
								// 	tableBody += `<td>`;
								// 		if(submitedData[k][field]){
								// 			for (clkey in lkp_cluster){
								// 				if(lkp_cluster[clkey]['cluster_id'] == submitedData[k][field]){
								// 					tableBody += lkp_cluster[clkey]['name'];
								// 				}
								// 			}
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_location_type') {
								// 	tableBody += `<td>`;
								// 		for (dskey in lkp_location_type){
								// 			if(lkp_location_type[dskey]['location_id'] == submitedData[k][field]){
								// 				tableBody += lkp_location_type[dskey]['name'];
								// 			}
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_animal_type_lactating') {
								// 	tableBody += `<td>`;
								// 	for (akey in lkp_animal_type_lactating){
								// 		if(lkp_animal_type_lactating[akey]['animal_type_lactating_id'] == submitedData[k][field]){
								// 			tableBody += lkp_animal_type_lactating[akey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;

								// }else if (type == 'respondent_name') {
								// 	tableBody += `<td>`;
								// 	for (rkey in respondent_name){
								// 		if(submitedData[k][field]){
								// 			if(respondent_name[rkey]['data_id'] == submitedData[k][field]){
								// 				tableBody += respondent_name[rkey]['first_name']+' '+respondent_name[rkey]['last_name'];
								// 			}
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_grampanchayat') {
								// 	tableBody += `<td>`;
								// 	for (gkey in gn_list){
								// 		if(gn_list[gkey]['grampanchayat_id'] == submitedData[k][field]){
								// 			tableBody += gn_list[gkey]['grampanchayat_name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_crop') {
								// 	tableBody += `<td>`;
								// 	for (ckey in crop_list){
								// 		if(crop_list[ckey]['crop_id'] == submitedData[k][field]){
								// 			tableBody += crop_list[ckey]['crop_name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_branch_details') {
								// 	tableBody += `<td>`;
								// 	for (let bckey = 0; bckey < branch_list.length; bckey++) {
								// 		if(branch_list[bckey]['branch_id'] == submitedData[k][field]){
								// 			tableBody += branch_list[bckey]['branch_name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_farmer_bank_details') {
								// 	tableBody += `<td>`;
								// 	for (let dnkey = 0; dnkey < bank_list.length; dnkey++) {
								// 		const element = bank_list[dnkey];
								// 		if(bank_list[dnkey]['bank_id'] == submitedData[k][field]){
								// 			tableBody += bank_list[dnkey]['bank_name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_village') {
								// 	tableBody += `<td>`;
								// 	for (let vkey = 0; vkey < village_list.length; vkey++) {
								// 		if(village_list[vkey]['village_id'] == submitedData[k][field]){
								// 			tableBody += village_list[vkey]['village_name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'signature') {
								// 	tableBody += `<td>`;
								// 		if(submitedData[k][field] == 'N/A' || submitedData[k][field] == null){
								// 			tableBody += `N/A`;
								// 		}else{
								// 			tableBody += `<a class="img_link text-primary" data-img-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field] +`" onClick="openImgPopup(event);" href="javascript:void(0);">View Signature</a>`;
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'kml') {
								// 	if(survey_id == 5){
								// 		tableBody += `<td>`;
								// 		tableBody += (submitedData[k][field] != null ? submitedData[k][field]  : `N/A`);
								// 		tableBody += `</td>`;
								// 		tableBody += `<td>`;
								// 		if(submitedData[k][field+'_kml'] == 'N/A' || submitedData[k][field+'_kml'] == null){
								// 			tableBody += `N/A`;
								// 		}else{
								// 			tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field+'_kml']+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;

											
								// 		}
								// 		tableBody += `</td>`;
								// 	}else{
								// 		tableBody += `<td>`;
								// 		if(submitedData[k][field] != 'N/A'){
								// 			tableBody += `<a class="kml_link text-primary" data-klm-url="<?php echo base_url(); ?>uploads/survey/`+ submitedData[k][field]+`" onClick="openPopup(event);" href="javascript:void(0);">View KML Details</a>`;
								// 		}else{
								// 			tableBody += `N/A`;
								// 		}
								// 		tableBody += `</td>`;
								// 	}
								// }else if (type == 'lkp_market') {
								// 	tableBody += `<td>`;
								// 	for (mkey in lkp_market){
								// 		if(lkp_market[mkey]['market_id'] == submitedData[k][field]){
								// 			tableBody += lkp_market[mkey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_lr_body_condition') {
								// 	tableBody += `<td>`;
								// 	for (bkey in lkp_lr_body_condition){
								// 		if(lkp_lr_body_condition[bkey]['id'] == submitedData[k][field]){
								// 			tableBody += lkp_lr_body_condition[bkey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_sr_body_condition') {
								// 	tableBody += `<td>`;
								// 	for (bkey in lkp_sr_body_condition){
								// 		if(lkp_sr_body_condition[bkey]['id'] == submitedData[k][field]){
								// 			tableBody += lkp_sr_body_condition[bkey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_animal_type') {
								// 	tableBody += `<td>`;
								// 	for (akey in lkp_animal_type){
								// 		if(lkp_animal_type[akey]['animal_type_id'] == submitedData[k][field]){
								// 			tableBody += lkp_animal_type[akey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_animal_herd_type') {
								// 	tableBody += `<td>`;
								// 	// for (ahkey in lkp_animal_herd_type){
								// 	// 	if(lkp_animal_herd_type[ahkey]['id'] == submitedData[k][field]){
								// 	// 		tableBody += lkp_animal_herd_type[ahkey]['name'];
								// 	// 	}
								// 	// }
								// 		if(submitedData[k][field]){
								// 			// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
								// 			let checkedValues =(submitedData[k][field]).split('&#44;');
								// 			let output = '';
								// 			for (ahkey in lkp_animal_herd_type){
								// 				for (var i = 0; i < checkedValues.length; i++) {
								// 					if (checkedValues[i] == lkp_animal_herd_type[ahkey]['id']) {
								// 						output += lkp_animal_herd_type[ahkey]['name'] + '<br>';
								// 					}
								// 				}
								// 			}
								// 			tableBody += output;
								// 		}else{
								// 			tableBody +="N/A";
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_food_groups') {
								// 	tableBody += `<td>`;
								// 	// for (fkey in lkp_food_groups){
								// 	// 	if(lkp_food_groups[fkey]['id'] == submitedData[k][field]){
								// 	// 		tableBody += lkp_food_groups[fkey]['name'];
								// 	// 	}
								// 	// }
								// 		if(submitedData[k][field]){
								// 			// let checkedValues =((submitedData[k][field]).replaceAll('&#44;',',')).split(',');
								// 			let checkedValues =(submitedData[k][field]).split('&#44;');
								// 			let output = '';
								// 			for (fkey in lkp_food_groups){
								// 				for (var i = 0; i < checkedValues.length; i++) {
								// 					if (checkedValues[i] == lkp_food_groups[fkey]['id']) {
								// 						output += lkp_food_groups[fkey]['name'] + '<br>';
								// 					}
								// 				}
								// 			}
								// 			tableBody += output;
								// 		}else{
								// 			tableBody +="N/A";
								// 		}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_transect_pasture') {
								// 	tableBody += `<td>`;
								// 	for (fkey in lkp_transect_pasture){
								// 		if(lkp_transect_pasture[fkey]['id'] == submitedData[k][field]){
								// 			tableBody += lkp_transect_pasture[fkey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_dry_wet_pasture') {
								// 	tableBody += `<td>`;
								// 	for (fkey in lkp_dry_wet_pasture){
								// 		if(lkp_dry_wet_pasture[fkey]['id'] == submitedData[k][field]){
								// 			tableBody += lkp_dry_wet_pasture[fkey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else if (type == 'lkp_transport_means') {
								// 	tableBody += `<td>`;
								// 	for (fkey in lkp_transport_means){
								// 		if(lkp_transport_means[fkey]['transport_id'] == submitedData[k][field]){
								// 			tableBody += lkp_transport_means[fkey]['name'];
								// 		}
								// 	}
								// 	tableBody += `</td>`;
								// }else{
								// 	tableBody += `<td>`;
								// 		tableBody += (submitedData[k][field] == null ? `N/A` : submitedData[k][field] );
								// 	tableBody += `</td>`;
								// }

							// }
						}
                        tableBody += `<td>`+ submitedData[k]['first_name'] +` `+ submitedData[k]['last_name'] +`</td>`;
                        tableBody += `<td>`+ submitedData[k]['datetime'] +`</td>`;
						tableBody += `</tr>`;

						
						$('#submited_body').append(tableBody);
						$('#overlay').fadeOut();
						$('#loader').fadeOut();
						
					}
				}else{
					$('#export_sub').addClass('hidden');
					$('#submited_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No data found</h5></td></tr>');
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

    const onPagination = (event) => { 
		var keywords = $('#user_submit_search').val();
		getSubmitedDataView(+event.currentPage,+event.recordsPerPage,keywords);
		
  	}
      const pagination = new Pagination('#submited_pagination',onPagination);
        </script>