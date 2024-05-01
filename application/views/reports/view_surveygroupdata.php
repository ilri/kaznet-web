
<!-- Main content -->
<div class="main-content">
	<div class="p-4">
		<div class="card">			
			<div class="card-footer">
			<?php 
				$survey_id = $this->uri->segment(3);
				switch ($survey_id) {
					case '3':
						$page_title ="Milk Production Details";
						break;
					case '4':
						$page_title ="Body condition and weight";
						break;
					case '5':
						$page_title ="Livestock Prices & Quality";
						break;
					case '6':
						$page_title ="MUAC";
						break;
					case '7':
						$page_title ="Prices of Index commodities";
						break;
					case '8':
						$page_title ="RCSI";
						break;
					case '9':
						$page_title ="Transect forage conditions";
						break;
					case '10':
						$page_title ="Livestock births and deaths trade";
						break;
					
					default:
						# code...
						break;
				}?>
				 <h4 class="title"><?php echo($page_title); ?></h4>
			</div>
		</div>
		<!-- Import tabular view -->
		<?php //$this->load->view('reports/tabular_data.php', array('filename' => 'Farmer Registration Data')); ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>include/plugins/daterangepicker/daterangepicker.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>include/plugins/bootstrap-select/bootstrap-select.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
		<style type="text/css">
			.dropdown-menu {
				width: auto !important;
			}
		</style>
		<!-- Tabular Data -->
		<div class="card mt-20">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-success pull-right" onclick="window.close();">Back</button>
					</div>
					<div class="col-md-12">
						<div class="card p-2">
							<div class="exportContainer hidden"></div>
							<div class="table-responsive" style="height: 400px;overflow-y: scroll ;">
								<table class="table table-bordered table-hover m-0">
									<thead>
										<tr style="position: sticky;top: 0px;background: #000;">
											<th>S.No.</th>
											<?php foreach ($fields as $key => $value) { ?>
												<th><?php echo $value['label']; ?></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($group_data)){
												$i=1;
												foreach ($group_data as $key => $g_data) {
													$formgroup_data_arr = json_decode($g_data['data'], true);
													if(!empty($formgroup_data_arr)){
														?>
														<tr>
															<td><?php echo $i; ?></td>
															<?php
															foreach ($fields as $value) { 
																$column = "field_".$value['field_id'];
																if ($value['type'] == 'lkp_crop') {
																	if(!empty($formgroup_data_arr[$column])){
																		$this->db->select('crop_name');
																		$this->db->where('crop_code', $formgroup_data_arr[$column]);;
																		$crop_res = $this->db->get('lkp_crop')->row();
																		?>
																		<td><?php echo (!empty($crop_res)) ? $crop_res->crop_name : 'N/A'; ?></td>
																		<?php
																	}
																} 
																else{
																	?>
																	<td><?php echo (!empty($formgroup_data_arr[$column])) ? $formgroup_data_arr[$column] : ''; ?></td>
																	<?php
																}
															}
															?>
														</tr>
														<?php
													}
													$i++;
												}
											}
										?>
									</tbody>
								</table>
							</div>
							<div class="loadingText"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="<?php echo base_url(); ?>include/plugins/daterangepicker/daterangepicker.js"></script>
		<script src="<?php echo base_url(); ?>include/plugins/bootstrap-select/bootstrap-select.js"></script>
		<script src="<?php echo base_url(); ?>include/plugins/table_doublescroller/jquery.doubleScroll.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

	</div>
</div>
<!-- /Main content -->

<script type="text/javascript">
	var primary_key = 'farmer_id',
	url = '<?php echo base_url(); ?>reports/registration',
	mapUrl = '<?php echo base_url(); ?>reports/get_map_locations/<?php echo $this->uri->segment(3); ?>';
	$(function() {
		$('.get_data').trigger('click');
		//Call fn to load all locations in map
		loadAllLocationData(null);
	});
	$('.table').DataTable({
        dom: 'Bfrtip',
        buttons: [
        	{
                extend: 'copyHtml5',
                title: '',
                filename: '<?php echo $export_file_name; ?>'
            },
            {
                extend: 'excelHtml5',
                title: '',
                filename: '<?php echo $export_file_name; ?>'
            },
            {
                extend: 'csvHtml5',
                title: '',
                filename: '<?php echo $export_file_name; ?>'
            }
        ]
    });
</script>