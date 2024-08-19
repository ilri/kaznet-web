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
			
            <!-- <div class="col-sm-12 col-md-12 col-lg-12 mt-3"> -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Task Management</a></li>
                        <li class="breadcrumb-item"><a href="#">Survey Data Export</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- <div class="card mt-3 border-0"> -->
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="title">Survey Data Export</h4>
                        
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
							<div class="col-sm-12 col-md-12 col-lg-8">
								<table class="table">
									<thead>
										<td>Slno.</td>
										<td>Survey Name</td>
										<td>Export</td>
									</thead>
									<tbody>
										<tr>
											<td>1</td><td>Milk Production</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=3 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
										</tr>
										<tr>
											<td>2</td><td>Body condition and weight</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=4 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
										</tr>
										<tr>
											<td>3</td><td>MUAC</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=6 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
										</tr>
										<tr>
											<td>4</td><td>RCSI</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=8 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
										</tr>
										<tr>
											<td>5</td><td>Livestock births and deaths trade</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=10 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
										</tr>
										<tr>
											<td>6</td><td>Livestock Feeds and Water</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=12 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
											</tr>
										<tr>
											<td>7</td><td>Crops Water Incomes Expenditures</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=13 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
											</tr>
										<tr>
											<td>8</td><td>Conflict Exposure</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=14 data-surveytype="Household Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
											</tr>
										<tr>
											<td>9</td><td>Livestock Prices & Quality</td><td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=5 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
										</tr>
										<tr>
											<td>10</td><td>Prices of Index commodities</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=7 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
											</tr>
										<tr>
											<td>11</td><td>Livestock Volumes</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=11 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
											</tr>
										<tr>
											<td>12</td><td>Transect forage conditions</td>
											<td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=9 data-surveytype="Rangeland Task"  onclick="exportxcel_all(event)">Execute Job</button></td>
											</tr>
										<tr>
											<td>13</td><td>Household profile</td>
											<!-- <td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=25 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td> -->
										</tr>
										<tr>
											<td>14</td><td>Contributor profile</td>
											<!-- <td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=26 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td> -->
											</tr>
										<tr>
											<td>15</td><td>Transect Pastures</td>
											<!-- <td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=27 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td> -->
											</tr>
										<tr>
											<td>16</td><td>Payment Report</td>
											<!-- <td><button type="button" class="btn btn-sm"  id="export_sub1" data-surveyid=28 data-surveytype="Market Task"  onclick="exportxcel_all(event)">Execute Job</button></td> -->
										</tr>
									</tbody>
								</table>
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

<!-- export data js -->
<script src="<?php echo base_url(); ?>include/js/xlsx.full.min.js"></script>
<script>
	function exportToXcel(name,data){
		const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, name);
        // XLSX.writeFile(wb, name+'.xlsx');
		// debugger
		// const arraybuffer = XLSX.write(wb, name+'.xlsx');
        const arraybuffer = XLSX.write(wb, {type:"binary", bookType:'xlsx'});
		const blob = new Blob([s2ab(arraybuffer)], { type: 'application/octet-stream' });

		// Create FormData and append the Blob
		const formData = new FormData();
		formData.append('file', blob, 'result.xlsx');
		formData.append('name', name);

		// Send data to the server via AJAX
		const xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url(); ?>/reports/get_data_to_export_server', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				console.log('File uploaded successfully to the server.');
			}
		};
		xhr.send(formData);
	}
	// Helper function to convert binary string to array buffer
	function s2ab(s) {
			const buf = new ArrayBuffer(s.length);
			const view = new Uint8Array(buf);
			for (let i = 0; i < s.length; i++) {
				view[i] = s.charCodeAt(i) & 0xFF;
			}
			return buf;
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
		var survey_id = "";
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
	function exportxcel_all(event) {
		$('#overlay').fadeIn();
        $('#loader').fadeIn();
    	var dataValue = "";
		var button = event.target;
    	var survey_id = button.getAttribute('data-surveyid');
    	var survey_type = button.getAttribute('data-surveytype');
		
		var country_id ='';
		var uai_id ='';
		var sub_location_id ='';
		var cluster_id ='';
		var contributor_id ='';
		var respondent_id ='';
		var start_date ='';
		var end_date ='';
		// alert("called");
		// var country_id = $('select[name="country_id"]').val();
		// var uai_id = $('select[name="uai_id"]').val();
		// var sub_location_id = $('select[name="sub_location_id"]').val();
		// var cluster_id = $('select[name="cluster_id"]').val();
		// var contributor_id = $('select[name="contributor_id"]').val();
		// var respondent_id = $('select[name="respondent_id"]').val();
		// var start_date=$('input[name="start_date_vsd"]').val();
        // var end_date=$('input[name="end_date_vsd"]').val();
		if(survey_type == "Market Task"){
			var respondent_id = "";
		}else if(survey_type == "Rangeland Task" ){
			var respondent_id = "";
		}else{
			var respondent_id = "";
		}
		var respondent_id ="";
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
		// alert("called");
		// alert(query_data);
		$.ajax({
			// url: "<?php echo base_url(); ?>reports/get_submited_data_export/<?php echo $this->uri->segment(3); ?>",
			url: "<?php echo base_url(); ?>reports/exportExcel_all/",
			data: query_data,
			type: "POST",
			dataType: "JSON",
			// error: function() {
			// 	$.toast({
			// 		heading: 'Error!',
			// 		text: response.msg,
			// 		icon: 'error'
			// 	});
			// },
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
				// switch (dataValue) {
				// 	case "1":
				// 		$("#export_sub").prop('disabled', false);
				// 		$("#export_sub").html("Execute Job");
				// 		break;
				// 	case "2":
				// 		$("#export_ap").prop('disabled', false);
				// 		$("#export_ap").html("Execute Job");
				// 		break;
				// 	case "3":
				// 		$("#export_rej").prop('disabled', false);
				// 		$("#export_rej").html("Execute Job");
				// 		break;
				
				// 	default:
				// 		break;
				// }
			}
		});
			
	}
	
</script>