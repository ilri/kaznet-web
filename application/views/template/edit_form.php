<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Form</title>
        <link rel="stylesheet" href="https://formbuilder.online/assets/css/form-builder.min.css">
    </head>
    <body>
        <div class="container mt-2">
            <h2 class="">Edit Form : </h2>
            <!-- Form Title Input -->
            <div class="mb-3">
                <label for="form-title">Form Title <span class="required-asterisk" style="display:inline"> *</span> :</label>
                <input type="text" class="form-control" id="form_title" placeholder="Enter form title" required="required" aria-required="true">
            </div>
            <!-- Form Subject Input -->
            <div class="mb-3">
                <label for="form-subject">Form Subject <span class="required-asterisk" style="display:inline"> *</span> :</label>
                <input type="text" class="form-control" id="form_subject" placeholder="Enter form subject" required="required" aria-required="true">
            </div>

            <div id="fb-editor"></div>
            <button id="save-form" class="btn btn-primary mt-3">Update Form</button>
        </div>

        <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script> -->
        <script src="<?php echo base_url();?>assets_drag/js/vendor.js"></script>
        <script src="<?php echo base_url();?>assets_drag/js/form-builder.min.js"></script>
        <script src="<?php echo base_url();?>assets_drag/js/form-render.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
        <script>
            $(document).ready(function() {
                // Extend the header, field to include a "name" attribute
            
                
                // Example pre-existing form data (from the server or database)
                var formTitle = '<?php echo $form_title; ?>'; // Example title
                var formSubject = '<?php echo $form_subject; ?>'; // Example title
                // Set the initial form title
                $('#form_title').val(formTitle);
                $('#form_subject').val(formSubject);

                // var formData = '[{"type": "text", "label": "First Name", "className": "form-control", "name": "first_name"}, {"type": "email", "label": "Email", "className": "form-control", "name": "email"}]';
                var formData = JSON.stringify(<?php echo $form_data; ?>);
                // Initialize Form Builder with existing form data
                // var formBuilder = $('#fb-editor').formBuilder({
                //     formData: formData
                // });
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
                            },
                            // attrs: {
                            //     disabled: true // Disables the className field but keeps it visible
                            // }
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

                    },
                    '*': { // '*' applies to all field types
                        className: {
                            label: 'Class Name',
                            type: 'text',
                            value: '', // Default value for className
                            attrs: {
                                disabled: true // Disables the className field but keeps it visible
                            }
                            },
                            name: {
                            label: 'Name',
                            type: 'text',
                            value: '', // Default value for name
                            attrs: {
                                disabled: true // Disables the name field but keeps it visible
                            }
                            }
                    },
                    onAddField: function(fieldId, fieldData) {
                    // Callback for field addition if needed
                    },
                    onEditField: function($field) {
                    // Any additional actions when a field is edited
                    },


                    // Other options
                    // disabledActionButtons: ['data'],  // Disable the 'View Data' button
                    // showActionButtons: false,  // Hide default action buttons

                    // Load the form with the provided form data
                    formData: formData

                };
                // Initialize form builder with form data and additional options
                var fb = $('#fb-editor').formBuilder(options);

                
            
                // Delete user
                $('body').on('click', '#save-form', function(event) {
                    var elem = $(this);
                    swal({
                        title: "Are you sure?",
                        text: "you want to Update form",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, Update it!"
                    }, function() {
                        // elem.addClass('disabled');
                        // elem.html('Please Wait.... Deleting form.');
                        editData(elem);
                    });
                });
                // Save updated form data
                // $('#save-form').on('click', function() {
                // $('#save-form').click(function(e) {
                function editData(elem){
                    // e.preventDefault(); // Prevent default form submission
                    // Force the builder to update its internal state
                    fb.actions.save();

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

                    var updatedFormData = fb.actions.getData('json'); // Get updated form data in JSON formatvar formData = fb.actions.getData('json');
                    const formJSON = JSON.parse(updatedFormData);
                    
                    let hasRequired = formJSON.some(field => field.required === true);
                    if (!hasRequired || isValid == false) {
                        if(!hasRequired){
                            alert("Please make at least one field mandatory.");
                        }else{
                            //
                        }
                    }else{
                        $('#save-form').prop('disabled', true); //added by sagar to disable save button not to resubmit while form saving
                        $.post('<?php echo site_url('FormController/update_form'); ?>', {
                            form_id:<?php echo $this->uri->segment(3); ?>,
                            form_data: updatedFormData,
                            form_title: formTitle,
                            form_subject: formSubject
                        }, function(response) {
                            var res = JSON.parse(response);
                            $.toast({
                                heading: 'Successfully Updated form',
                                text: res.msg,
                                icon: 'success',
                                afterHidden: function() {
                                    location.reload(); // Reload the page after the toast is hidden
                                }
                            });
                        });
                        // Example: Send the updated form data to the server
                        // $.ajax({
                        //     url: '/save-form', // Server-side script to handle form saving
                        //     type: 'POST',
                        //     data: { formData: updatedFormData },
                        //     success: function(response) {
                        //         alert('Form saved successfully!');
                        //     },
                        //     error: function(xhr, status, error) {
                        //         alert('An error occurred: ' + error);
                        //     }
                        // });
                    }
                // });
                }

            });
        </script>

    </body>
</html>
