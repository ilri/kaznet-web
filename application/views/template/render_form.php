<div class="container mt-5">
    <div id="success-message" class="alert alert-success d-none" role="alert">
        Form submitted successfully!
    </div>
    <form id="rendered-form" class="needs-validation" novalidate></form>
    <button id="submit-form" class="btn btn-primary mt-3">Submit Form</button>
</div>


<script>
    $(document).ready(function() {
        var formData = <?php echo $form_data; ?>;

        $('#rendered-form').formRender({
            formData: formData
        });

        $('#submit-form').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Collect form data manually
            var formDataArray = $('#rendered-form').serializeArray();
            var formData = {};
            $.each(formDataArray, function() {
                if (formData[this.name]) {
                    if (!formData[this.name].push) {
                        formData[this.name] = [formData[this.name]];
                    }
                    formData[this.name].push(this.value || '');
                } else {
                    formData[this.name] = this.value || '';
                }
            });
            console.log('Form Data:', formData); // Debugging line

            // Check form validity
            var form = $('#rendered-form')[0];
            if (!form.checkValidity()) {
                $('#rendered-form').addClass('was-validated');
                return;
            }

            // Submit form data via AJAX
            $.ajax({
                url: '<?php echo base_url();?>FormController/submit_form',
                type: 'POST',
                dataType: 'json',
                data: {
                    form_id: <?php echo $form_id; ?>,
                    submitted_data: JSON.stringify(formData) // Ensure data is JSON encoded
                },
                success: function(response) {
                    console.log('Server Response:', response); // Debugging line
                    if (response.status === 'success') {
                        $('#success-message').removeClass('d-none');
                        setTimeout(function() {
                            $('#success-message').addClass('d-none');
                        }, 9000);
                        $('#rendered-form')[0].reset();
                        $('#rendered-form').removeClass('was-validated');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', xhr.responseText); // Debugging line
                }
            });
        });
    });
</script>
<script src="<?php echo base_url();?>assets_drag/js/vendor.js"></script>
<script src="<?php echo base_url();?>assets_drag/js/form-builder.min.js"></script>
<script src="<?php echo base_url();?>assets_drag/js/form-render.min.js"></script>