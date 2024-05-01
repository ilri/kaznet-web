<style>
	.vertical-layout{
		margin-top: 10px;
	}
</style>

<!-- location Modal -->
<div class="modal fade" id="locationModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Location Details</h4>
				<button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body table-responsive">
				<table class="table">
					<thead>
						<th>#</th>
						<th>Country</th>
						<th>State</th>
						<th>District</th>
						<th>Block</th>
						<th>Village</th>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="app-content content" style="margin-left: 0px;">
	<div class="content-wrapper">
		<div class="content-body" style="margin-bottom: 30px;">
			<div class="row">
				<div class="col-12">		    	
					<div class="card">
						<div class="card-content collapse show">
							<div class="card-header">
								<h4 class="card-title">All Users</h4>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Sl.no</th>
												<th>First name</th>
												<th>Last name</th>
												<th>Email id</th>
												<th>Username</th>
												<th>Role</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($users) > 0){
												foreach ($users as $ukey => $user) { ?>
													<tr data-user_id="<?php echo $user['user_id']; ?>">
														<td><?php echo ($ukey+1); ?></td>
														<td><?php echo $user['first_name']; ?></td>
														<td><?php echo $user['last_name']; ?></td>
														<td><?php echo $user['email_id']; ?></td>
														<td><?php echo $user['username']; ?></td>
														<td><?php echo $user['role_name']; ?></td>
														<td>
														<?php if($user['role_id'] > 2) { ?>
															<a href="javascript:void(0);" data-id="<?php echo $user['user_id']; ?>" class="locations"><i class="fa fa-map" aria-hidden="true"></i> View Locations</a>
														<?php } else { ?>
															N/A
														<?php } ?>
														</td>
													</tr>
												<?php }
											}else{ ?>
												<tr>
													<td colspan="7">No users found</td>
												</tr>
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
	</div>
</div>

<!-- Page Script -->
<script type="text/javascript">
	$(function() {
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

		// Handle project locations btn click
		$('body').on('click', '.locations', function(event) {
			var elem = $(this);
			$('.error').empty();
			$('#locationModal').modal('show');
			$('#locationModal').find('tbody').html('<tr><td colspan="4">Please Wait... Getting Location Details.</td></tr>');
			var data = {
				user_id: elem.data('id')
			}
			data[csrfName] = csrfHash;
			$.ajax({
				url: '<?php echo base_url(); ?>users/get_user_locations/',
				data: data,
				type: 'POST',
				dataType: 'json',
				complete: function(data) {
					var csrfData = JSON.parse(data.responseText);
					if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
						$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
					}
					csrfName = csrfData.csrfName;
					csrfHash = csrfData.csrfHash;
				},
				error: function() {
					$.toast({
						heading: 'Network Error!',
						text: 'Could not establish connection to server. Please refresh the page and try again.',
						icon: 'error',
						afterHidden: function () {
							$('#locationModal').modal('hide');
						}
					});
				},
				success: function(data) {
					if(data.status == 0) {
						$('#locationModal').modal('hide');
						$.toast({
							heading: 'Error!',
							text: data.msg,
							icon: 'error',
							afterHidden: function () {
								$('#locationModal').modal('hide');
							}
						});
						return false;
					}

					if(data.status == 2) {
						$('#locationModal').modal('hide');
						$.toast({
							heading: 'Info',
							text: data.msg,
							icon: 'info',
							afterHidden: function () {
								$('#locationModal').modal('hide');
							}
						});
						return false;
					}

					var HTML = ``;
					for(var key in data.locations) {
						var loc = data.locations[key];
						HTML += `<tr>
						<td>${parseInt(key)+1}</td>
						<td>${loc.country}</td>
						<td>${loc.state}</td>
						<td>${loc.dist}</td>
						<td>${loc.block}</td>
						<td>${loc.village}</td>
						</tr>`;
					}
					$('#locationModal').find('tbody').html(HTML);
				}
			});
		});
	});
</script>