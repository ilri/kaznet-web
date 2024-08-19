<!-- Main content -->
<style>
	.mobile_code{
		position: absolute;
		top: 56px;
		left: 22px;
	}
	.mobile_count{
		padding-left: 80px;
	}
</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 mt-3">
				<nav>
					<ol class="breadcrumb mb-0 bg-transparent">
						<!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
						<li class="breadcrumb-item"><a href="#">Custom Template</a></li>
						<li class="breadcrumb-item active">Create Template</li>
					</ol>
				</nav>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="card mt-3 border-0">
					<div class="card-body">
						<h4 class="title">Template Details</h4>
						<div class="row">
					      <div class="col-md-12">
					        <div class="panel panel-default">
					          <div class="panel-body">
					          <p id="message"></p>
					              <?php echo form_open('policymaker/drag_data',array('class' => 'form-group'));?>
					              <div class="col-md-12">
					                <label class="bt" style="margin-left: -10px;">Template Title<font color="red">*</font></label>
					                <input type="text" name="title" class="form-control" placeholder="Template Title" style="margin-top: 0px;">
					              </div>
					              <div class="col-md-12 mt-10">
					                <label class="bt" style="margin-left: -10px;">Template Subject<font color="red">*</font></label>
					                <input type="text" name="subject" class="form-control" placeholder="Template Subject" style="margin-top: 0px;">
					              </div>
					              <div class="col-md-12 mt-10">
					                <label class="bt" style="margin-left: -10px;">Enable location</label><br>
					                <input type="checkbox" name="checkbox" id="agree" /><label for="agree">Please select the checkbox to enable the location while submitting the data</label>
					                <p class="term_checkbox_error red-800"></p>
					              </div>
					            <?php echo form_close(); ?>
					            <div class="col-md-12">
					              <div class="content">
					                <div id="stage1" class="build-wrap" style="border: 1px solid gray; border-radius: 5px;"></div>
					                <form class="render-wrap"></form>
					                <button id="save" type="button" class="btn btn-primary pull-right btn-sm mt-20">Add Template</button>
					              </div>
					            </div>
					          </div>
					        </div>
					      </div>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Main content -->

<script type="text/javascript">
  $(function() {
    /*var fields = [
      {
        type: 'autocomplete',
        label: 'Custom Autocomplete',
        required: true,
        values: [
          {label: 'SQL'},
          {label: 'C#'},
          {label: 'JavaScript'},
          {label: 'Java'},
          {label: 'Python'},
          {label: 'C++'},
          {label: 'PHP'},
          {label: 'Swift'},
          {label: 'Ruby'}
        ]
      },
      {
        label: 'Star Rating',
        attrs: {
          type: 'starRating'
        },
        icon: '🌟'
      }
    ];*/



    var actionButtons = [{
      id: 'smile',
      className: 'btn btn-success',
      label: '😁',
      type: 'button',
      events: {
        click: function() {
          alert('😁😁😁 !SMILE! 😁😁😁');
        }
      }
    }];

    /*var templates = {
      starRating: function(fieldData) {
        return {
          field: '<span id="'+fieldData.name+'">',
          onRender: function() {
            $(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
          }
        };
      }
    };*/

    /*var inputSets = [{
      label: 'User Details',
      name: 'user-details', // optional
      showHeader: true, // optional
      fields: [{
        type: 'text',
        label: 'First Name',
        className: 'form-control'
      }, {
        type: 'select',
        label: 'Profession',
        className: 'form-control',
        values: [{
          label: 'Street Sweeper',
          value: 'option-2',
          selected: false
        }, {
          label: 'Brain Surgeon',
          value: 'option-3',
          selected: false
        }]
      }, {
        type: 'textarea',
        label: 'Short Bio:',
        className: 'form-control'
      }]
    }];*/

    var typeUserDisabledAttrs = {
      autocomplete: ['access'],
      file:['multiple'],
      text: ['maxlength'],
      textarea: ['maxlength']
    };

    var typeUserAttrs = {
      text: {
        className: {
          label: 'Class',
          options: {
            'red form-control': 'Red',
            'green form-control': 'Green',
            'blue form-control': 'Blue'
          },
          style: 'border: 1px solid red'
        }
      },
      //text
      text: {
          subType: {
          label: 'Type',
          options: {
            'text': 'Text',
            'email': 'Email',
            'password': 'Password'
          }
        }
      },
      //textarea
      textarea: {
          maxlength: {
          label: 'Max Length',
          options: {
            '1': '1',
            '10': '10',
            '100': '100',
            '1000': '1000',
            '10000': '10000',
            '100000': '100000'
          }
        }
      },
      //file
      file: {
        subType: {
          label: 'File Type',
          options: {
            'document': 'Document',
            'excel': 'Excel',
            'image': 'Image'
          }
        },
        maxlength: {
          label: 'Max Number of file',
          options: {
            '1': '1',
            '2': '2',
            '3': '3'
          }
        }
      }
    };

    // test disabledAttrs

    var fbOptions = {
      subtypes: {
        text: ['datetime-local']
      },
      onSave: function(e, formData) {
        toggleEdit();
        $('.render-wrap').formRender({
          formData: formData,
          templates: templates
        });
        window.sessionStorage.setItem('formData', JSON.stringify(formData));
      },
      stickyControls: {
        enable: true
      },
      sortableControls: true,
      //fields: fields,
      //templates: templates,
      //inputSets: inputSets,
      typeUserDisabledAttrs: typeUserDisabledAttrs,
      typeUserAttrs: typeUserAttrs,
      disableInjectedStyle: false,
      //actionButtons: actionButtons,
      showActionButtons: false,
      disableFields: ['autocomplete','hidden','paragraph','button'],
      disabledAttrs: ['class', 'value', 'placeholder', 'rows', 'access', 'min', 'max', 'step', 'subtype', 'other']
      // controlPosition: 'left'
      //disabledAttrs
    };

    var formBuilder = $('.build-wrap').formBuilder(fbOptions);
    var fbPromise = formBuilder.promise;
    
    fbPromise.then(function(fb) {
      /*console.log('=====');
      console.log($('[name="checkbox"]:checked').length);
      if($('[name="checkbox"]:checked').length == 1){
        var location_val = 1;
      }else{
        var location_val = 0;
      }*/
      var apiBtns = {
        showData: fb.actions.showData,
        clearFields: fb.actions.clearFields,
        getData: function() {
          $.ajax({
            url: '<?php echo base_url(); ?>template/drag_data',
            type: 'POST',
            dataType: 'json',
            data: {
              formdata: fb.actions.getData('json', true),
              title: $('input[name="title"]').val(),
              subject: $('input[name="subject"]').val(),
              location_val : $('[name="checkbox"]:checked').length
            },
            error: function() {
              $('#message').html('<h4 class="red-800">Sorry!!! Can not connect to the server. Please check your internet connection or refresh the page and try again.</h4>');
              $('#save').removeAttr('disabled', 'disabled');
            },
            success: function(data) {
              $('#save').removeAttr('disabled', 'disabled');
              
              if(data.msg.length > 0){
                formBuilder.actions.clearFields();
                $('input[name="title"]').val('');
                $('input[name="subject"]').val('');
                $('#message').html(data.msg);
                $("input[name='checkbox']:checkbox").prop('checked',false);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                window.setTimeout(function() { 
                  $("#message").html(''); 
                }, 5000);
              }

              if(data.query.length > 0) {
                data.query.forEach(function(value, index) {
                  callNode(value);
                });
              }
            }
          });
        }
      };

      /*Object.keys(apiBtns).forEach(function(action) {
        document.getElementById(action)
        .addEventListener('click', function(e) {
          apiBtns[action]();
        });
      });*/


      document.getElementById('save')
      .addEventListener('click', function(e) {
        $('#save').attr('disabled','disabled');
        $('.error').remove();
        $('#message').html('');
        var formfeild = fb.actions.getData('json', true); 
        var obj = JSON.parse(formfeild);
        var labelerror = 0;
        var requiredstatus = 0;

        $.each(obj, function(key,value) {
          if(typeof value.label === "undefined"){
            $('#stage1').after('<span class="error" style="color:red;">Please enter label to '+value.type+' field.<br></span>');
            labelerror++; 
          }
          if(typeof value.required !== "undefined"){
            requiredstatus++;
          }
        });
        var error_count = 0;
        var length = Object.keys(obj).length;        
        var title = $('input[name="title"]').val();
        var subject = $('input[name="subject"]').val();
        if(title == ''){
          $('input[name="title"]').after('<span class="error" style="color:red;">Title is mandatory</span>');
        }else{
          if(title.length > 250){
            $('input[name="title"]').after('<span class="error" style="color:red;">This field can contain less than or equal to 250 characters.</span>');
            error_count++;
          }
          /*if(!title.match(/^[a-zA-Z ]*$/)){
            $('input[name="title"]').after('<span class="error" style="color:red;">Contain only Alphabets and spaces</span>');
          }*/
        }
        if(subject == ''){
          $('input[name="subject"]').after('<span class="error" style="color:red;">Subject is mandatory</span>');
        }else{
          if(subject.length > 250){
            $('input[name="subject"]').after('<span class="error" style="color:red;">This field can contain less than or equal to 250 characters.</span>');
            error_count++;
          }
          /* if(!subject.match(/^[a-zA-Z ]*$/)){
            $('input[name="subject"]').after('<span class="error" style="color:red;">Contain only Alphabets and spaces</span>');
          }*/
        }
        if(length == 0){
          $('#stage1').after('<span class="error" style="color:red;">Select atleast one field</span>');
        }else{
          if(requiredstatus == 0){
            $("#stage1").after('<h5 class="error red-800">Please select atleast one field as required.</h5>');
          }
        }
        if(title != '' && subject != '' && length != 0 && labelerror == 0 && requiredstatus != 0 && error_count == 0){          
          apiBtns['getData']();
        }else{
          $('#save').removeAttr('disabled','disabled');
        }
      });
    });
  });
  </script>
  <script src="<?php echo base_url();?>assets_drag/js/vendor.js"></script>
  <script src="<?php echo base_url();?>assets_drag/js/form-builder.min.js"></script>
  <script src="<?php echo base_url();?>assets_drag/js/form-render.min.js"></script>