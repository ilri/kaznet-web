
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Font Awesome Example</title>

        <!-- Font Awesome 6 CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
        <style>

            td {
                word-wrap: break-word;  /* Allows long text to wrap */
                word-break: break-word; /* Prevents text overflow */
                max-width: 200px;       /* Set a max width for the column to enforce wrapping */
                white-space: normal !important;    /* Ensure normal line breaks */
            }
            .btn-submit {
                background: rgb(111, 27, 40);
                border-radius: 5px;
                margin-top: 1px;
                width: 100px;
                height: 35px;
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
            .fas.fa-trash {
                color: red; /* Change icon color */
                font-size: 24px; /* Change icon size */
            }
        </style>
        <style>
                        
                        
            a.btn.btn-outline-view-form {
                background: transparent !important;
                border-radius: 5px !important;
                height: auto !important;
                /* line-height: 25px  !important; */
                font-weight: 500  !important;
                width: 100px !important;
                font-size: 12px !important;
                margin-top:0px !important;
                color: #173846 !important;
                border: 1px solid #173846 !important;
            }

            a.btn.btn-outline-view-data {
                background: transparent;
                border-radius: 5px !important;
                width: 100px !important;
                font-style: normal !important;
                font-weight: 500 !important;
                height: auto !important;
                font-size: 12px !important;
                line-height: 16px !important;
                color: #28a745 !important;
                border: 1px solid #28a745 !important;
            }
            a.btn.btn-outline-delete {
                border-color: #dc3545 !important;
                background: transparent;
                border-radius: 5px !important;
                width: 100px !important;
                font-style: normal;
                font-weight: 500 !important;
                height: auto !important;
                font-size: 12px !important;
                line-height: 16px !important;
                color: #dc3545 !important;
                border: 1px solid #dc3545 !important;
            }
            a.btn.btn-outline-edit {
                background: transparent;
                border-radius: 5px !important;
                font-style: normal;
                font-weight: 500;
                width: 100px !important;
                height: auto;
                font-size: 12px !important;
                line-height: 16px !important;
                color: #000 !important;
                border: 1px solid #17a2b8 !important;
            }
        </style>
    </head>
    <body>

    

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
                <div class="tab-pane fade show active" id="dataview" role="tabpanel" aria-labelledby="dataview-tab">
                    <div class="row">
                        <div class="col-sm-10 col-md-10 col-lg-10 mb-3">
                            <ul class="nav nav-tabs border-bottom-0 bg-transparent" id="dataTabId"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="Submitted-tab" data-toggle="tab"
                                        data-target="#Submitted" type="button" role="tab"
                                        aria-controls="Submitted" aria-selected="false">Active</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="Approved-tab" data-toggle="tab"
                                        data-target="#Approved" type="button" role="tab"
                                        aria-controls="Approved" aria-selected="true">Inactive</button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Submitted" role="tabpanel" aria-labelledby="Submitted-tab">
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
                                        <div class="table-responsive" style="height:65vh;">
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
                                <div class="tab-pane fade " id="Approved" role="tabpanel" aria-labelledby="Approved-tab">
                                    <!-- <div class="col-md-12 export_align">
                                        <button type="button" class="btn btn-sm hidden"  id="export_ap" data-tabvalue=2 onclick="exportXcel(event)">Export data</button>
                                    </div> -->
                                    <div class="text-right mt-2 mb-2 pr-3 d-flex justify-content-between">
                                        <!-- <span class="p-2 input_place hidden" id="text_approved_search">
                                            <div class="ml-auto">
                                            <input type="text" id="user_approved_search" class="search form-control approved_search" placeholder=" (Search on First Name, User Name) ">
                                            <span class="search_icon" onClick="searchApprovedFilter();"><i class="fa fa-search text-white"></i></span>
                                            </div>
                                        </span> 
                                        <button type="button" class="btn btn-sm btn-primary" id="export_ap" onclick="approvedeExportXcel()">Export data</button>-->
                                    </div> 
                                    <!-- <div class="table-responsive" style="height:290px;"> -->
                                    <div class="table-responsive" style="height:65vh;">
                                        <table class="table table-striped" style="width:100%">
                                            <thead class="bg-dataTable" id="approved_head">
                                            </thead>
                                            <tbody id="approved_body">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="approved_pagination" class="submited_pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>

    <script src="<?php echo base_url(); ?>include/js/pagination.js"></script>
    <script src="<?php echo base_url(); ?>include/js/bootstrap.min.js" ></script>
    <script>
        $(document).ready(function(){
            getSubmitedDataView();
        });
        $('#Submitted-tab').on('click', function(){
            getSubmitedDataView();
        })
        $('#Approved-tab').on('click', function(){
            getAprovedDataView();
        })
        function getSubmitedDataView(pageNo =1, recordperpage = 100, search_input = null){
            var query_data = {
                pagination:{pageNo,recordperpage},
                search: {
                    search_input
                },
                status:1
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
                    var submitedData = response.data;
                    var td_count = 0;
                    var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
                        tableHead += `<th>S.no</th>`;
                        // tableHead += `<th>Delete</th>`;
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
                            if(submitedData[k]['first_name'] == null ){
                                $added_name = "N/A";
                            }else{
                                $added_name = submitedData[k]['first_name'] +` `+ submitedData[k]['last_name']
                            }
                            tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
                            
                            tableBody += `<td>`+ count++ +`</td>`;
                            
                            tableBody += `<td>`+ submitedData[k]['title'] +`</td>`;
                            tableBody += `<td>`+ submitedData[k]['subject'] +`</td>`;
                            tableBody += `<td>`+ $added_name +`</td>`;
                            tableBody += `<td>`;
                            tableBody += submitedData[k]['datetime'] != null ? submitedData[k]['datetime']  : `N/A`;
                            tableBody += `</td>`;
                            tableBody += `<td><a href="<?php echo base_url(); ?>FormController/render_form/`+ submitedData[k]['id'] +`" class="btn btn-outline-view-form  ">View form</a> `;
                            tableBody += `<a href="<?php echo base_url(); ?>FormController/view_form_data/`+ submitedData[k]['id'] +`" class="btn btn-outline-view-data  ">View data</a> </br>`;
                            if(role==1){
                                tableBody += `<a href="#" class="delete_submited  btn btn-outline-delete mt-1" onClick="deleteData(event);" data-id="`+data_id+`">Delete form</a>`;
                                tableBody += `<a href="<?php echo base_url(); ?>FormController/edit_form/`+ submitedData[k]['id'] +`" class="btn btn-outline-edit mt-1 mx-1">Edit form</a></td>`;
                            }else{
                                tableBody += `</td>`;
                            }
                            
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
        function getAprovedDataView(pageNo =1, recordperpage = 100, search_input = null){
            var query_data = {
                pagination:{pageNo,recordperpage},
                search: {
                    search_input
                },
                status:0
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
                url: "<?php echo base_url(); ?>FormController/get_forms_list/<?php echo $this->uri->segment(3); ?>",
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
                        $('#export_sub').addClass('hidden');
                        return false;
                    }
                    var role = response.user_role;
                    var submitedData = response.data;

                    var td_count = 0;
                    var tableHead = `<tr style="position: sticky;top: -1px;background: #000;background:black;">`;
                    // tableHead += `<th>S.No.</th>`;
                    
                    tableHead += `<th>S.no</th>`;
                    tableHead += `<th>Form Title</th>`;
                    tableHead += `<th>Form Subject</th>`;
                    tableHead += `<th>Added By</th>`;
                    tableHead += `<th>Added Date</th>`;
                    tableHead += `<th>Deleted By</th>`;
                    tableHead += `<th>Deleted Date</th>`;
                    tableHead += `<th>Action</th>`;
                    $('#approved_head').html(tableHead);

                    $('#approved_body').html("");
                    
                    if(submitedData.length > 0){
                        var tableBody ="";
                        var displayData = "";
                        var fieldOPtions = "";
                        var count = (pageNo*recordperpage-recordperpage+1);
                        for (let k = 0; k < submitedData.length; k++) {
                            var data_id = submitedData[k]['id'];
                            tableBody = `<tr class="`+data_id+` text-left" data-id="`+data_id+`">`;
                            if(submitedData[k]['d_f_name'] == null ){
                                $deleted_name = "N/A";
                            }else{
                                $deleted_name = submitedData[k]['d_f_name'] +` `+ submitedData[k]['d_l_name']
                            }
                            if(submitedData[k]['first_name'] == null ){
                                $added_name = "N/A";
                            }else{
                                $added_name = submitedData[k]['first_name'] +` `+ submitedData[k]['last_name']
                            }
                            tableBody += `<td>`+ count++ +`</td>`;
                            
                            tableBody += `<td>`+ submitedData[k]['title'] +`</td>`;
                            tableBody += `<td>`+ submitedData[k]['subject'] +`</td>`;
                            tableBody += `<td>`+ $added_name +`</td>`;
                            // tableBody += `<td>`+ submitedData[k]['datetime'] +`</td>`;
                            tableBody += `<td>`;
                            tableBody += submitedData[k]['datetime'] != null ? submitedData[k]['datetime']  : `N/A`;
                            tableBody += `</td>`;
                            tableBody += `<td>`+ $deleted_name +`</td>`;
                            tableBody += `<td>`;
                            tableBody += submitedData[k]['deleted_datetime'] != null ? submitedData[k]['deleted_datetime']  : `N/A`;
                            tableBody += `</td>`;
                            // tableBody += `<td><div> <a href="<?php echo base_url(); ?>FormController/render_form/`+ submitedData[k]['id'] +`" class="btn btn-info btn-sm">View form</a> `;
                            tableBody += `<td><a href="<?php echo base_url(); ?>FormController/view_form_data/`+ submitedData[k]['id'] +`" class="btn btn-outline-view-form ">View data</a></div></td>`;
                            // tableBody += `<a href="<?php echo base_url(); ?>FormController/view_form_data/`+ submitedData[k]['id'] +`" class="btn btn-secondary btn-sm mr-2">Delete form</a></td>`;
                            tableBody += `</tr>`;
                            
                            $('#approved_body').append(tableBody);
                            $('#overlay').fadeOut();
                            $('#loader').fadeOut();
                            
                        }
                    }else{
                        $('#export_sub').addClass('hidden');
                        $('#approved_body').html('<tr><td class="nodata" colspan="55"><h5 class="text-danger">No data found</h5></td></tr>');
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
                        document.getElementById('approved_pagination').style.display = 'none';
                    } else{
                        document.getElementById('approved_pagination').style.display = 'flex';
                        pagination1.refreshPagination (Number(curentPage),totalRecords,currentRecords, Number(totalRecordsPerPage))
                    }

                }
            });
        }

        const onPagination = (event) => { 
            var keywords = $('#user_submit_search').val();
            getSubmitedDataView(+event.currentPage,+event.recordsPerPage,keywords);
            
        }
        const pagination = new Pagination('#submited_pagination',onPagination);

        const onPagination1 = (event) => { 
            var keywords1 = $('#user_approved_search').val();
            getAprovedDataView(+event.currentPage,+event.recordsPerPage,keywords1);
        
        }
        function searchApprovedFilter() {
            var keywords1 = $('#user_approved_search').val();
            getAprovedDataView(1, 100, keywords1);
        }       
        const pagination1 = new Pagination('#approved_pagination',onPagination1);
        
         // Delete user
        $('body').on('click', '.delete_submited', function(event) {
            var elem = $(this);
            swal({
                title: "Are you sure?",
                text: "you want to delete delete form",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!"
            }, function() {
                elem.addClass('disabled');
                elem.html('Please Wait.... Deleting form.');
                deleteData(elem);
            });
        });
        function deleteData(elem){
            var ajaxData = {};
            var id = elem.closest('tr').data('id');
            ajaxData['id'] = id;
            $.ajax({
                url: '<?php echo base_url(); ?>FormController/deleteData/',
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
                    $(this).removeClass('disabled');
                    $(this).html('<i class="fa password" aria-hidden="true"></i> Delete');	      
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
                            window.location.reload();
                        }
                    });
                }
            });
        }
    </script>