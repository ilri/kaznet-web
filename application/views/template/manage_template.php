<!-- Main content -->
<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }
  .disabled_link{
    pointer-events: none;
    background-color:"gray" !important;
  }
  .dataTables_filter {
    display: block !important;
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

<!-- Main content -->
  <div class="container-fluid">
      <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
              <nav>
                  <ol class="breadcrumb mb-0 bg-transparent">
                      <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
                      <li class="breadcrumb-item"><a href="#">Custom Template</a></li>
                      <li class="breadcrumb-item active"> Manage Templates</li>
                  </ol>
              </nav>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="card mt-3 border-0">
              
                  <?php if(count($forms) > 0) {?>
					<div class="row">
						<div class="col-md-12">
							<h4>Custom Templates</h4>
							<table id="example1" class="table table-striped" style="width:100%" data-table="form">
								<thead class="bg-dataTable">
									<tr>
										<th>S.no</th>
										<th>Template Title</th>
										<th>Template Subject</th>
										<th>Public Id</th>
										<th>Location</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="tbody_form">
									<?php if(count($forms) > 0) {
										$i = 1;
										foreach($forms  as $form) {
											if($form['public_id']!=NULL) {
												$public_id=$form['public_id'];
											}else{
												$public_id="N/A";
											}?>
											<tr>
												<td><?php echo $i; ?></td>
												<td>
													<?php if(strlen($form['title']) > 20){
														$text = substr($form['title'], 0, 20)."...";
													}else{
														$text = $form['title'];
													} ?>
													<?php echo $text; ?>
												</td>
												<td>
													<?php if(strlen($form['subject']) > 20){
														$text = substr($form['subject'], 0, 20)."...";
													}else{
														$text = $form['subject'];
													}
													echo $text; ?>
												</td>
												<?php if($form['public_id']!=NULL){ ?>
													<td>
														<?php if($this->session->userdata('organization_code') == '2WQM4Z'){
															echo base_url(); ?>uefa_publicsurvey/<?php echo $form['public_id'];
														}elseif ($this->session->userdata('organization_code') == 'U8K1AP' && $form['id'] == 101) {
															echo base_url(); ?><?php echo $form['public_id'];
														} else{
															echo base_url(); ?>publicsurvey/<?php echo $form['public_id'];
														} ?>
													</td>
												<?php }else{ ?>
													<td>Public id is not available</td>
												<?php  } ?>
												<td>
													<?php if($form['location'] == 'true' || $form['location'] == 'TRUE'){ ?>
														<!-- <a href="javascript:void(0);" class="btn btn-sm btn-danger location" data-locationstatus = "disable" data-surveyid = "<?php echo $form['id']; ?>">Disable location</a> -->
														<label class="switch">
															<input type="checkbox" checked class="location" data-locationstatus = "disable" data-surveyid = "<?php echo $form['id']; ?>">
															<span class="slider round"></span>
														</label>
													<?php } else{ ?>
														<!-- <a href="javascript:void(0);" class="btn btn-sm btn-success location" data-locationstatus = "enable" data-surveyid = "<?php echo $form['id']; ?>">Enable location</a> -->
														<label class="switch">
															<input type="checkbox" class="location" data-locationstatus = "enable" data-surveyid = "<?php echo $form['id']; ?>">
															<span class="slider round"></span>
														</label>
													<?php } ?>
												</td>
												<td>
													<!-- <a class="label label-danger btn btn-danger btn-xs" style="color: white;">Delete Form</a> -->
													<?php if($this->session->userdata('organization_code') == 'U8K1AP' && $form['id'] == 101){ ?>
														<!-- <a class="label label-success btn btn-success btn-xs" href="<?php echo base_url(); ?>policymaker/drag_form/<?php echo $form['id']; ?>">View Form</a> -->
														<a href="<?php echo base_url(); ?>policymaker/tsicsurvey_dashboard/<?php echo $form['id']; ?>" target="_blank" class="btn btn-success btn-xs">View dashboard</a>
													<?php }else{ ?>
														<a class="label label-success btn btn-success btn-xs" href="<?php echo base_url(); ?>template/drag_form/<?php echo $form['id']; ?>">View Form</a>
														<?php if($form['id'] == 137) { ?>
															<a class="label label-success btn btn-success btn-xs" href="<?php echo base_url(); ?>policymaker/qct_entry_survey_data">View Data</a>
														<?php } ?>
														<?php if($form['id'] == 138) { ?>
															<a class="label label-success btn btn-success btn-xs" href="<?php echo base_url(); ?>policymaker/cyc_entry_survey_data">View Data</a>
														<?php } ?>
														<?php if($form['id'] == 265) { ?>
															<a href="<?php echo base_url(); ?>policymaker/qctusersurvey_dashboard/<?php echo $form['id']; ?>" target="_blank" class="btn btn-success btn-xs">View dashboard</a>
														<?php } ?>
														<?php if($form['id'] == 321 || $form['id'] == 322) { ?>
															<a href="<?php echo base_url(); ?>tsic_dashboard/" target="_blank" class="btn btn-success btn-xs">View dashboard</a>
														<?php } ?>
													<?php } ?>

												</td>
											</tr><?php
											$i++;
										} 
									} else { ?>
										<tr>
											<td colspan="6">Form data is not available</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				<?php } ?>
              </div>
          </div>
      </div>
  </div>







































