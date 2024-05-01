<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
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
	.back_btn{
		text-align: right;
		position: absolute;
		top: 5px;
		right: 25px;
	}
   
</style>
   <div class="container-fluid">
        <div class="row">
			<?php 
				$survey_name = "Household Details";
				?>
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Survey Data</a></li>
                        <li class="breadcrumb-item active"><?php echo($survey_name); ?></li>
                    </ol>
                </nav>
				<div class="back_btn">
					<a href="<?php echo base_url(); ?>reports/household_profile" class="btn btn-sm btn-primary">Back</a>
				</div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <h4 class="title"><?php echo($survey_name); ?></h4>
						
						<div class="table-responsive">
							<table class="table table-striped" style="width:100%">
								<thead class="bg-dataTable">
									<th>S.No</th>
									<th>What is the name of the household head?</th>
									<th>Is household head married?</th>
									<th> household head spouse name</th>
									<th>Dose the household head know their AGE or YEAR OF BIRTH?</th>
									<th>household head OF BIRTH?</th>
									<th>What is the age of the household head?</th>
									<th>Household head's gender?</th>
									<th>Do you gave an ID?</th>
									<th>What is your National Identification number?</th>
									<th>Do you or any member of this household own a mobile phone?</th>
									<th>What is the type of phone?</th>
									<th>What is the phone number you often use to communicate?</th>
									<th>Your Mpesa number (For any taken/paments that we may give)</th>
									<th>To whom does this number(Mpesa) belong?</th>
									<th>How many members of this household own a mobile phone?</th>
									<th>What is your highest level of education?</th>
									<th>What is your current primary occupation?</th>
									<th>Other occupation</th>
								</thead>
								<tbody>
									<?php 
										if(count($hh_details) > 0){
										$count = 1;
										foreach($hh_details as $key => $value){ ?>
										<tr>
											<td><?=$count++;?></td>
											<td><?=$value['head_name'];?></td>
											<td><?=$value['married'];?></td>
											<td><?=$value['head_spouse_name'];?></td>
											<td><?=$value['head_dob_knowledge'];?></td>
											<td><?=$value['head_dob'];?></td>
											<td><?=$value['head_age'];?></td>
											<td><?=$value['head_gender'];?></td>
											<td><?=$value['have_id'];?></td>
											<td><?=$value['national_id'];?></td>
											<td><?=$value['does_member_have_phone'];?></td>
											<td><?=$value['phone_type'];?></td>
											<td><?=$value['mobile_number'];?></td>
											<td><?=$value['mpesa_no'];?></td>
											<td><?=$value['number_belongs_to'];?></td>
											<td><?=$value['total_member_have_phone'];?></td>
											<td><?=$value['highest_education_level'];?></td>
											<td><?=$value['current_primary_occupation'];?></td>
											<td><?=$value['other_occupation'];?></td>
										</tr>
									<?php } }else{ ?>
											<tr><td colspan="19"><span class="text-danger">No data Found</span></td></tr>

										<?php } ?>
								</tbody>
							</table>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

