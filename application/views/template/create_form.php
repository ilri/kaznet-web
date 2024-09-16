<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/font-awesome.min.css">
<style>
    .form-builder-access-control {
  display: none !important;
}

    </style>
<div class="container mt-5">
    <h1>Create Form</h1>
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
</div>

    <script>
    $(document).ready(function() {
        // Extend the header, field to include a "name" attribute
        
            const options = {
                // fields: fields,
                disableFields: ['hidden','tinymce'],
                disabledAttrs: [
                    'access'
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
                                text: 'Text Filed', // Keep the standard text option
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

            var formData = fb.actions.getData('json');
            const formJSON = JSON.parse(formData);
            let hasRequired = formJSON.some(field => field.required === true);
            if (!hasRequired) {
                alert("Please make at least one field mandatory.");
            }else{
                $('#save-form').prop('disabled', true); //added by sagar to disable save button not to resubmit while form saving
                $.post('<?php echo site_url('FormController/save_form'); ?>', {
                    form_data: formData,
                    form_title: formTitle,
                    form_subject: formSubject
                }, function(response) {
                    var res = JSON.parse(response);
                    $.toast({
                        heading: 'Successfully created form',
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
