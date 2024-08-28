<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/jquery.toast.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>include/css/font-awesome.min.css">
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
    <button id="save-form" class="btn btn-primary mt-3">Save Form</button>
</div>

    <script>
    $(document).ready(function() {
        var fb = $('#form-builder').formBuilder();

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
        });
    });
</script>
    <script src="<?php echo base_url();?>assets_drag/js/vendor.js"></script>
  <script src="<?php echo base_url();?>assets_drag/js/form-builder.min.js"></script>
  <script src="<?php echo base_url();?>assets_drag/js/form-render.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
