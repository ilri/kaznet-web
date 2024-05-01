<link rel="stylesheet" href="<?php echo base_url(); ?>include/plugins/bootstrap-select/bootstrap-select.css">
<style type="text/css">
	.dropdown-menu {
		width: auto !important;
	}
</style>
<style>
  .vertical-layout{
    margin-top: 10px;
  }

  ul {
    list-style-type: none;
    margin: 3px;
  }
  ul.checktree li:before {
    height: 1em;
    width: 12px;
    border-bottom: 1px dashed;
    content: "";
    display: inline-block;
    top: -0.3em;
  }
  ul.checktree li.blocks {
    margin-right: 50px;
    vertical-align: top;
    display: inline-block;
  }
  ul.checktree li { border-left: 1px dashed; }
  ul.checktree li.blocks:last-child { margin-right: 0; }
</style>

<!-- Main content -->
<div class="main-content">
	<div class="p-4">
		<div class="card">
			<div class="card-header">
				<h3>Map User's Agency and Location</h3>
			</div>
			<div class="card-body">
				<?php echo form_open('', array('id' => 'mapUserForm', 'autocomplete' => 'off')); ?>
				<div class="row">
					<div class="form-group col-6">
						<label for="user">User</label>
						<select class="form-control" name="user" title="-- Search / Select --">
							<?php foreach ($users as $key => $user) { if($user['role_id'] >= 3) { ?>
							<option value="<?php echo $user['user_id']; ?>">
								<?php echo $user['first_name'].' '.$user['last_name'].' ('.$user['username'].')'; ?>
							</option>
							<?php } } ?>
						</select>
					</div>

					<!-- <div class="form-group col-6">
						<label for="division">Agency</label>
						<select class="form-control" name="agency" title="-- Search / Select --">
							<?php foreach ($units as $key => $unit) { ?>
							<option value="<?php echo $unit['UNIT_ID']; ?>"><?php echo $unit['UNIT_NAME']; ?></option>
							<?php } ?>
						</select>
					</div> -->

					<!-- <div class="form-group col-6 acc_group"></div>
					<div class="form-group col-6 house_bank"></div> -->

					<div class="form-group col-12 locations"></div>

					<div class="col-12 text-right">
						<h5 class="text-danger form error float-left title mt-1"></h5>
						<button type="submit" class="btn btn-success">Map User</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>include/plugins/checkbox-tree/js/checktree.js"></script>
<script src="<?php echo base_url(); ?>include/plugins/bootstrap-select/bootstrap-select.js"></script>
<script type="text/javascript">
$(function(){
	$("[name='agency'], [name='user']").selectpicker({
		actionsBox: true,
		liveSearch: true
	});
});

// Define global variable ajaxData
var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

// Handle checkbox tree view
$(document).on('click', '.tree label', function(e) {
	$(this).next('ul').fadeToggle();
	e.stopPropagation();
});

$(document).on('change', '.tree input[type=checkbox]', function(e) {
	$(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
	$(this).parentsUntil('.tree').children("input[type='checkbox']").prop('checked', this.checked);
	e.stopPropagation();
});

//Handle user and agency change
$('body').on('change', '[name="user"]', function(event) {
	var elem = $(this);
	getLocations(elem.val(), $('[name="agency"]').val());
}).on('change', '[name="agency"]', function(event) {
	var elem = $(this);
	getLocations($('[name="user"]').val(), elem.val());
});

function getLocations(user, agency) {
	// $('.acc_group, .house_bank').empty();
	$('.locations').html(`<h6 class="text-info text-center">Select both User and Agency to continue mapping</h6>`);
	// if(user.length === 0 || agency.length === 0) return false;
	
	$('.locations').html('<h6 class="text-info text-center">Getting Locations... Please Wait...</h6>');
	//send ajax request to get location
	ajaxData['agency'] = agency;
	ajaxData['user_id'] = user;
	$.ajax({
		url: '<?php echo base_url(); ?>Users/get_user_locations',
		type: 'POST',
		dataType : 'json',
		data: ajaxData,
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
			$('.locations').html('<h6 class="text-info text-center">Please change either User or Agency to get details.</h6>');
		},
		success: function(response) {
			// // Show account group as radio button
			// var HTML = ``;
			// for(var accgrp of response.allAccGrp) {
			// 	var checked = (response.selectedAccGrp && (response.selectedAccGrp.account_group_id == accgrp.account_group_id)) ? 'checked' : '';
			// 	HTML += `<div class="form-group">
			// 		<input type="radio" name="accgrp" id="accgrp-${accgrp.account_group_id}" value="${accgrp.account_group_id}" ${checked}>
			// 		<label for="accgrp-${accgrp.account_group_id}">${accgrp.account_group_code} - ${accgrp.account_group_name} - ${accgrp.reconciliation_account} - ${accgrp.purchasing_organization}</label>
			// 	</div>`;
			// }
			// $('.acc_group').html(`<label>Select User Account Group</label>
			// ${HTML}
			// <h6 class="text-danger accgrp error title mt-1"></h6>`);

			// // Show house bank as radio button
			// HTML = ``;
			// for(var hsebnk of response.allHseBank) {
			// 	var checked = (response.selectedHseBank && (response.selectedHseBank.house_bank_id == hsebnk.house_bank_id)) ? 'checked' : '';
			// 	HTML += `<div class="form-group">
			// 		<input type="radio" name="hsebnk" id="hsebnk-${hsebnk.house_bank_id}" value="${hsebnk.house_bank_id}" ${checked}>
			// 		<label for="hsebnk-${hsebnk.house_bank_id}">${hsebnk.name}</label>
			// 	</div>`;
			// }
			// $('.house_bank').html(`<label>Select User House Bank</label>
			// ${HTML}
			// <h6 class="text-danger hsebnk error title mt-1"></h6>`);

			// if(response.status == 0) {
			// 	$.toast({
			// 		heading: 'Error!',
			// 		text: response.msg,
			// 		icon: 'error'
			// 	});
			// 	$('.locations').html('<h6 class="text-info text-center">Please change either User or Agency to get details.</h6>');
			// 	return false;
			// }
			
			// initLocation(response.states, response.selectedLoc);
			// $('button').prop('disabled', false);
			// $('button[type="submit"]').html('Add User');
			if(response.status == 0){
			$('.ajax_message').html('<div class="alert alert-danger">'+response.msg+'</div>').delay(3000).fadeOut();
			$('html,body').animate({
				scrollTop: $(".ajax_message").offset().top - 300
			}, 500);
			return false;
			}
			userDetails = response.user_details;
			var locationHTML = `<label>Tag Locations To User<span style="color:red;">*</span></label>`;
			for(country of response.countries) {
			locationHTML += `<ul class="checktree">
				<li>
				<input id="country_${country.id}" type="checkbox" />
				<label for="country_${country.id}">${country.country}</label>
				<ul>`;
				for(state of country.states) {
					locationHTML += `<li>
					<input id="state_${state.id}" type="checkbox" />
					<label for="state_${state.id}">${state.state}</label>
					<ul>`;
					for(district of state.districts) {
						locationHTML += `<li>
						<input id="district_${district.id}" type="checkbox" />
						<label for="district_${district.id}">${district.district}</label>
						<ul>`;
						for(block of district.blocks) {
							locationHTML += `<li class="blocks">
							<input id="block_${block.id}" type="checkbox" />
							<label for="block_${block.id}">${block.block}</label>
							<ul>`;
							for(village of block.villages) {
								var checked = userDetails.locations.includes(village.id) ? 'checked' : '';
								locationHTML += `<li>
								<input id="village_${village.id}" type="checkbox" name="villages[]" value="${village.id}" ${checked}/>
								<label for="village_${village.id}">${village.village}</label>
								</li>`;
							}
							locationHTML += `</ul>
							</li>`;
						}
						locationHTML += `</ul>
						</li>`;
					}
					locationHTML += `</ul>
					</li>`;
				}
				locationHTML += `</ul>
				</li>
			</ul>
			<p class="villages error" style="color: red;"></p>`;
			}
			$('.locations').html(locationHTML);
			$('ul.checktree').checktree();
		}
	});
}

//Initialize location tree
function initLocation(states, selectedLoc) {
	var states = states;
	selectedLoc = JSON.parse(selectedLoc);
	selectedLoc = selectedLoc.length === 0 ? null : selectedLoc;

	locationHTML = ``;
	for (var state of states) {
		checked = '';
		if(selectedLoc && selectedLoc.states && selectedLoc.states.includes(state.state_id)) checked = 'checked';
		
		locationHTML += `<li class="col-lg-3 col-md-4 col-sm-6">
		<input type="checkbox" name="state[]" value="${state.state_id}" ${checked}>
		<label>${state.state_name}</label>`;
		var did = 0;
		for (var district of state.districts) {
			if(did === 0) locationHTML += `<ul>`;

			checked = '';
			if(selectedLoc && selectedLoc.districts && selectedLoc.districts.includes(district.district_id)) checked = 'checked';
			
			locationHTML += `<li>
			<input type="checkbox" name="district[]" value="${district.district_id}" ${checked}>
			<label>${district.district_name}</label>`;
			var tid = 0;
			for (var tehsil of district.tehsils) {
				if(tid === 0) locationHTML += `<ul>`;

				checked = '';
				if(selectedLoc && selectedLoc.tehsils && selectedLoc.tehsils.includes(tehsil.tehsil_id)) checked = 'checked';

				locationHTML += `<li>
				<input type="checkbox" name="tehsil[]" value="${tehsil.tehsil_id}" ${checked}>
				<label>${tehsil.tehsil_name}</label>`;
				var bid = 0;
				for (var block of tehsil.blocks) {
					if(bid === 0) locationHTML += `<ul>`;

					checked = '';
					if(selectedLoc && selectedLoc.blocks && selectedLoc.blocks.includes(block.block_id)) checked = 'checked';

					locationHTML += `<li>
					<input type="checkbox" name="block[]" value="${block.block_id}" ${checked}>
					<label>${block.block_name}</label>`;
					// var gid = 0;
					// for (var gp of block.gps) {
					// 	if(gid === 0) locationHTML += `<ul>`;

					// 	checked = '';
					// 	if(selectedLoc && selectedLoc.gps && selectedLoc.gps.includes(gp.grampanchayat_id)) checked = 'checked';

					// 	locationHTML += `<li>
					// 	<input type="checkbox" name="grampanchayat[]" value="${gp.grampanchayat_id}" ${checked}>
					// 	<label>${gp.grampanchayat_name}</label>`;
					// 	var vid = 0;
					// 	for (var village of gp.villages) {
					// 		if(vid === 0) locationHTML += `<ul>`;

					// 		checked = '';
					// 		if(selectedLoc && selectedLoc.villages && selectedLoc.villages.includes(village.village_id)) checked = 'checked';

					// 		locationHTML += `<li>
					// 		<input type="checkbox" name="village[]" value="${village.village_id}" ${checked}>
					// 		<label>${village.village_name}</label>`;
					// 		locationHTML += `</li>`;
					// 		vid++;

					// 		if(vid === gp.villages.length) locationHTML += `</ul>`;
					// 	}
					// 	locationHTML += `</li>`;
					// 	gid++;

					// 	if(gid === block.gps.length) locationHTML += `</ul>`;
					// }
					locationHTML += `</li>`;
					bid++;

					if(bid === tehsil.blocks.length) locationHTML += `</ul>`;
				}
				locationHTML += `</li>`;
				tid++;

				if(tid === district.tehsils.length) locationHTML += `</ul>`;
			}
			locationHTML += `</li>`;
			did++;

			if(did === state.districts.length) locationHTML += `</ul>`;
		}
		locationHTML += `</li>`;
	}
	$('.locations').html(`<label>Modify Location Assignment - <a href="javascript:void(0)" class="allLoc text-success">Assign All Locations</a></label>
	<ul class="tree row">${locationHTML}</ul>
	<h6 class="text-danger location error title mt-1"></h6>`);

	// Show total direct children
	$('.locations').find('label').each(function(index) {
		var label = $(this),
		total = label.closest('li').find('ul:first > li').length;
		if(total > 0) label.append(' <span class="total">('+total+')</span>');
	});
}

// Assign all locations
$('body').on('click', '.allLoc', function(event) {
	var elem = $(this);
	elem.closest('.locations').find('ul.tree > li').find('input[type=checkbox]').prop('checked', true).trigger("change");
});

//Handle user mapping form submit
$('body').on('submit', '#mapUserForm', function(event) {
	event.preventDefault();
	var form = $(this);
	form.find('.error').empty();
	form.find('button').prop('disabled', true);
	form.find('button[type="submit"]').html('Please wait...');

	var formData = new FormData($(this)[0]);
	// var form = document.getElementById("mapUserForm"),
	// 	inputs = form.getElementsByName("villages"),
	// 	villages = [];

	// for (var i = 0, max = inputs.length; i < max; i += 1) {
	// 	// Take only those inputs which are checkbox
	// 	if (inputs[i].type === "checkbox" && inputs[i].checked) {
	// 		villages.push(inputs[i].value);
	// 	}
	// }
	// var formData =['villages'=>villages,'user']
	$.ajax({
		url: '<?php echo base_url(); ?>users/update_user_mapping/',
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		complete: function(data) {
			var csrfData = JSON.parse(data.responseText);
			ajaxData[csrfData.csrfName] = csrfData.csrfHash;
			if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
				$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
			}
		},
		error: function() {
			form.find('button').prop('disabled', false);
			form.find('button[type="submit"]').html('Map User');
			$.toast({
				heading: 'Network Error!',
				text: 'Could not establish connection to server. Please refresh the page and try again.',
				icon: 'error'
			});
		},
		success: function(data) {
			var data = JSON.parse(data);

			// If session error exists
			if(data.session_err == 1) {
				$.toast({
					heading: 'Session Error!',
					text: data.msg,
					icon: 'error'
				});

				form.find('button').prop('disabled', false);
				form.find('button[type="submit"]').html('Map User');
			}

			// If validation error exists
			if(data.status > 0) {
				for(var key in data) {
					var errorContainer = form.find(`.${key}.error`);
					if(errorContainer.length !== 0) {
						errorContainer.html(data[key]);
					}
				}
				form.find('button').prop('disabled', false);
				form.find('button[type="submit"]').html('Map User');
			}

			if(data.updatestatus == 1) {
				// If mapping completed
				$.toast({
					heading: 'Success!',
					text: data.msg,
					icon: 'success',
					afterHidden: function () {
						window.location.href = '<?php echo base_url(); ?>users/map';
					}
				});
			} else if(data.updatestatus == 0) {
				$.toast({
					heading: 'Error!',
					text: data.msg,
					icon: 'error'
				});
				form.find('button').prop('disabled', false);
				form.find('button[type="submit"]').html('Map User');
			}
		}
	});
});
</script>