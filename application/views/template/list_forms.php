<style>

td {
    word-wrap: break-word;  /* Allows long text to wrap */
    word-break: break-word; /* Prevents text overflow */
    max-width: 200px;       /* Set a max width for the column to enforce wrapping */
    white-space: normal !important;    /* Ensure normal line breaks */
}
    </style>
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
<!-- <div class="container mt-5"> -->
        <!-- <h1>List of Forms</h1> -->
        <!-- <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>S.no</th>
                    <th>Form Title</th>
                    <th>Form Subject</th>
                    <th>Added By</th>
                    <th>Added Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($forms)): ?>
                    <?php foreach ($forms as $index => $form): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $form['title']; ?></td>
                            <td><?php echo $form['subject']; ?></td>
                            <td><?php echo $form['first_name']; ?> <?php echo $form['last_name']; ?></td>
                            <td><?php echo $form['datetime']; ?></td>
                            <td>
                                <a href="<?php echo site_url('FormController/render_form/' . $form['id']); ?>" class="btn btn-info btn-sm">View form</a>
                                <a href="<?php echo site_url('FormController/view_form_data/' . $form['id']); ?>" class="btn btn-secondary btn-sm">View data</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No forms available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table> -->
    <!-- </div> -->
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
										aria-controls="Submitted" aria-selected="false">List of Forms</button>
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

    function getSubmitedDataView(pageNo =1, recordperpage = 100, search_input = null){
		var query_data = {
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
			url: "<?php echo base_url(); ?>FormController/get_forms_list/<?php echo $this->uri->segment(3); ?>",
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
				// var fields = response.columns;
				var submitedData = response.data;
				// var formdetails = JSON.parse(response.formdetails[0].form_data);
				// var formdetails = JSON.parse(response.formdetails[0].form_data);

				var td_count = 0;
				var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
				// tableHead += `<th>S.No.</th>`;
				
                // tableHead += `<th>Uploaded By</th>`;
                // tableHead += `<th>Uploaded Date</th>`;
                    tableHead += `<th>S.no</th>`;
                    tableHead += `<th>Form Title</th>`;
                    tableHead += `<th>Form Subject</th>`;
                    tableHead += `<th>Added By</th>`;
                    tableHead += `<th>Added Date</th>`;
                    tableHead += `<th>Action</th>`;
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
						
                        // tableBody += `<td>`+ submitedData[k]['first_name'] +` `+ submitedData[k]['last_name'] +`</td>`;
                        // tableBody += `<td>`+ submitedData[k]['datetime'] +`</td>`;
                        tableBody += `<td>`+ submitedData[k]['title'] +`</td>`;
                        tableBody += `<td>`+ submitedData[k]['subject'] +`</td>`;
                        tableBody += `<td>`+ submitedData[k]['first_name'] +` `+ submitedData[k]['last_name'] +`</td>`;
                        tableBody += `<td>`+ submitedData[k]['datetime'] +`</td>`;
                        tableBody += `<td><a href="<?php echo base_url(); ?>FormController/render_form/`+ submitedData[k]['id'] +`" class="btn btn-info btn-sm">View form</a>`;
                        tableBody += `<a href="<?php echo base_url(); ?>FormController/view_form_data/`+ submitedData[k]['id'] +`" class="btn btn-secondary btn-sm">View data</a></td>`;
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