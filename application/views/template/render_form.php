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

        // Create a FormData object
        var formElement = $('#rendered-form')[0];
        var formDataObj = new FormData(formElement);

        // Add custom fields to the FormData object
        formDataObj.append('form_id', <?php echo $form_id; ?>);

        console.log('Form Data:', formDataObj); // Debugging line

        // Check form validity
        if (!formElement.checkValidity()) {
            $('#rendered-form').addClass('was-validated');
            return;
        }

        // Submit form data via AJAX
        $.ajax({
            url: '<?php echo base_url();?>FormController/submit_form',
            type: 'POST',
            data: formDataObj,
            processData: false,  // Important! Prevents jQuery from automatically transforming the data into a query string
            contentType: false,  // Important! Prevents jQuery from overriding the content type of the request
            dataType: 'json',
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