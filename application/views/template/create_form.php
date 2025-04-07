<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/font-awesome.min.css">
<style>
    .form-builder-access-control {
  display: none !important;
}

    </style>
<!-- <div class="container mt-2">
    <h2>Create Form</h2>
    <form id="form-meta" class="mb-3">
        <div class="mb-3">
            <label for="form_title" class="form-label">Form Title <span class="text-danger">*</span></label>
            <input type="text" id="form_title" name="form_title" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="form_subject" class="form-label">Form Subject <span class="text-danger">*</span></label>
            <input type="text" id="form_subject" name="form_subject" class="form-control" required />
        </div>
    </form>
    <div id="form-builder"></div>
    <button id="save-form" class="btn btn-primary mt-3">Create Form</button>
</div> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Custom Tasks</a></li>
                        <li class="breadcrumb-item active">Create Task</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <form id="form-meta" class="mb-3">
                            <div class="mb-3">
                                <label for="form_title" class="form-label">Task Title <span class="text-danger">*</span></label>
                                <input type="text" id="form_title" name="form_title" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="form_subject" class="form-label">Task Subject <span class="text-danger">*</span></label>
                                <input type="text" id="form_subject" name="form_subject" class="form-control" required />
                            </div>
                        </form>
                        <div id="form-builder"></div>
                        <button id="save-form" class="btn btn-primary mt-3">Create Task</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Extend the header, field to include a "name" attribute
        
            const options = {
                // fields: fields,
                disableFields: ['hidden','tinymce','paragraph'],
                disabledAttrs: [
                    'access',                    
                    // 'className',
                    // 'name',
                    'toggle',
                    'inline',
                ],
                typeUserAttrs: {
                    button: {
                        
                        subtype: {
                            label: 'Button Type',
                            options: {
                                // Only hide 'button' type, keeping 'submit' and 'reset'
                                // button: 'Button',
                                // submit: 'submit',
                                reset: 'reset'
                            }
                        }
                    },
                    file: {
                        subtype: {
                            label: 'Type', 
                            options: {
                                file: 'File', // Keep only the generic file uploader option
                                // accept: "image/jpeg, image/png, application/pdf, text/csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                // Other subtypes like 'image', 'video' are not included here
                            }
                        }
                    },
                    text: {
                        subtype: {
                            label: 'Type',
                            options: {
                                text: 'Text Field', // Keep the standard text option
                                email: 'Email',
                                password: 'Password',
                                tel: 'Telephone',
                                // url: 'URL',
                                number: 'Number'
                                // Note: Do not include 'color' here to hide it from the dropdown
                            }
                        }
                    },
                    textarea: {
                        subtype: {
                            label: 'Type',
                            options: {
                                textarea: 'textarea' // Only keep the plain textarea option
                                // quill: 'quill' // Only keep the plain textarea option
                                // You can add more textarea subtypes here if needed
                            }
                        }
                    },
                    header: {
                        name: {
                            label: 'Name',
                            type: 'text',
                            value: 'header_name', // Default value for name
                            description: 'The name attribute for this header field'
                        }
                    },
                    hidden: {
                        name: {
                            label: 'Name',
                            type: 'text',
                            value: '', // Default value (optional)
                            description: 'The name attribute for this hidden input'
                        }
                    },
                    paragraph: {
                        name: {
                            label: 'Name',
                            type: 'text',
                            value: '', // Default value (optional)
                            description: 'The name attribute for this paragraph'
                        }
                    }

                }
            };
        // var fb = $('#form-builder').formBuilder();
        var fb = $('#form-builder').formBuilder(options);

        // Function to disable 'className' and 'name' inputs after adding a new field
        function disableNameAndClass() {
            setTimeout(function () {
                $('#form-builder input[name="className"]').prop('disabled', true);
                $('#form-builder input[name="name"]').prop('disabled', true);
            }, 500); // Delay ensures that fields are fully rendered before disabling
        }
        $(document).on('click', '.frmb-control', function () {
            disableNameAndClass();
        });
        fb.promise.then(function () {
            disableNameAndClass();
        });
        
        // After rendering the form, modify the file upload field
        var fileInput = $('#file-upload-container').find('input[type="file"]');

        if (fileInput.length) {
        // Append the allowed file types info beside the file upload input
        fileInput.each(function() {
            var allowedTypes = ".jpg, .png, .pdf"; // Specify allowed file types
            var fileTypeInfo = $('<span class="file-type-info"> (Allowed file types: ' + allowedTypes + ')</span>');
            $(this).after(fileTypeInfo);
        });
        }


        $('#save-form').click(function(e) {
            e.preventDefault(); // Prevent default form submission
            
            var formTitle = $('#form_title').val().trim();
            var formSubject = $('#form_subject').val().trim();
            
            // Basic validation
            if (formTitle === '') {
                $.toast({
                    heading: 'Validation Error',
                    text: 'Form Title is required',
                    icon: 'error'
                });
                $('#form_title').focus();
                return false;
            }

            if (formSubject === '') {
                $.toast({
                    heading: 'Validation Error',
                    text: 'Form Subject is required',
                    icon: 'error'
                });
                $('#form_subject').focus();
                return false;
            }
            let isValid = true; // To track if the field configuration is valid
            $('.select-field').each(function() {
                var select = $(this);
                select.find('.fld-multiple')
                if (select.find('.fld-multiple').is(':checked')) {
                    //if multi select 
                    // var defaultSelected = select.find('input[type="checkbox"]:checked').length;
                    var defaultSelected = select.find('.option-selected').is(':checked');
                    if (!defaultSelected) {
                        alert('Please select a default option for the select.');
                        isValid = false;
                        $(this).addClass('error');
                        if ($(this).next('.error-message').length === 0) {
                            // $(this).after('<span class="error-message" style="color:red;">Please select a default option for the select.</span>');
                            $(this).focus();
                            // $(this).prev('form-field').after('<span class="error-message" style="color:red;">Please select a default option for the select.</span>');
                        }
                        return false;
                    }else{
                        $(this).removeClass('error');
                        $(this).closest('.form-field').next('.error-message').remove();
                    }
                }else{
                    
                    //if single select need to check
                    var defaultSelected = select.find('input[type="radio"]:checked').length;
                    if (!defaultSelected) {
                        alert('Please select a default option for the select.');
                        isValid = false;
                        $(this).addClass('error');
                        if ($(this).next('.error-message').length === 0) {
                            // $(this).after('<span class="error-message" style="color:red;">Please select a default option for the select.</span>');
                            $(this).focus();
                            // $(this).prev('form-field').after('<span class="error-message" style="color:red;">Please select a default option for the select.</span>');
                        }
                        return false;
                    }else{
                        $(this).removeClass('error');
                        $(this).closest('.form-field').next('.error-message').remove();
                    }
                }

            });
            // Loop through all checkbox options (assuming you have a class or ID to identify the option elements)
            $('.field-options').each(function() {
                $(this).find('li').each(function() {
                    let label = $(this).find('.option-label').val(); // Get the label of the option
                    let value = $(this).find('.option-value').val(); // Get the value of the option
                    // if($(this).next('.error-message'))
                    // Check if both label and value are filled
                    if (!label || !value) {
                        isValid = false;
                        $(this).addClass('error');
                        if ($(this).next('.error-message').length === 0) {
                            $(this).after('<span class="error-message" style="color:red;">Both label and value are required.</span>');
                            $(this).focus();
                            // $(this).prev('form-field').after('<span class="error-message" style="color:red;">Both label and value are required.</span>');
                        }
                        return false;
                    }else{
                        // alert("test");
                        $(this).removeClass('error');
                        $(this).next('.error-message').remove();
                        // $(this).prev('form-field').next('.error-message').remove();
                    }
                });
            });
            
            $('.radio-group').each(function() {
                var radioGroup = $(this);
                var defaultSelected = radioGroup.find('input[type="radio"]:checked').length;
                
                if (!defaultSelected) {
                    alert('Please select a default option for the radio group.');
                    isValid = false;
                    $(this).addClass('error');
                    if ($(this).next('.error-message').length === 0) {
                        // $(this).after('<span class="error-message" style="color:red;">Please select a default option for the radio group.</span>');
                        $(this).focus();
                        // $(this).prev('.form-group').after('<span class="error-message" style="color:red;">Please select a default option for the radio group.</span>');
                    }
                    return false;
                }else{
                        // alert("test");
                        $(this).removeClass('error');
                        $(this).next('.error-message').remove();
                        // $(this).prev('.form-group').next('.error-message').remove();
                    }
            });
            $('.checkbox-group').each(function() {
                var radioGroup = $(this);
                var defaultSelected = radioGroup.find('input[type="checkbox"]:checked').length;
                
                if (!defaultSelected) {
                    alert('Please select a default option for the checkbox group.');
                    isValid = false;
                    $(this).addClass('error');
                    if ($(this).next('.error-message').length === 0) {
                        // $(this).after('<span class="error-message" style="color:red;">Please select a default option for the radio group.</span>');
                        $(this).focus();
                        // $(this).prev('.form-group').after('<span class="error-message" style="color:red;">Please select a default option for the radio group.</span>');
                    }
                    return false;
                }else{
                        // alert("test");
                        $(this).removeClass('error');
                        $(this).next('.error-message').remove();
                        // $(this).prev('.form-group').next('.error-message').remove();
                    }
            });

            var formData = fb.actions.getData('json');
            const formJSON = JSON.parse(formData);
            let hasRequired = formJSON.some(field => field.required === true);
            if (!hasRequired || isValid == false) {
                if(!hasRequired){
                    alert("Please make at least one field mandatory.");
                }else{
                    //
                }
            }else{
                $('#save-form').prop('disabled', true); //added by sagar to disable save button not to resubmit while form saving
                $.post('<?php echo site_url('FormController/save_form'); ?>', {
                    form_data: formData,
                    form_title: formTitle,
                    form_subject: formSubject
                }, function(response) {
                    var res = JSON.parse(response);
                    $.toast({
                        heading: 'Successfully created task',
                        text: res.msg,
                        icon: 'success',
                        afterHidden: function() {
                            location.reload(); // Reload the page after the toast is hidden
                        }
                    });
                });
            }
        });
    });
</script>
    <script src="<?php echo base_url();?>assets_drag/js/vendor.js"></script>
  <script src="<?php echo base_url();?>assets_drag/js/form-builder.min.js"></script>
  <script src="<?php echo base_url();?>assets_drag/js/form-render.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
