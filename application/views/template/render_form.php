<style>
    .error {
  border: 1px solid red;
}

.error-message {
  color: red;
  font-size: 12px;
  margin-left: 5px;
}
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Custom Tasks</a></li>
                        <li class="breadcrumb-item active">View Task</li>
                        <li class="breadcrumb-item active"><?php echo $form_title?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <div id="success-message" class="alert alert-success d-none" role="alert">
                            Task submitted successfully!
                        </div>
                        <form id="rendered-form" class="needs-validation" novalidate></form>
                        <button id="submit-form" class="btn btn-primary mt-3">Submit task</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    // $(document).on('change', '.formbuilder-file-field', function () {
    $(document).on('change', '#rendered-form input[type="file"]', function () {
        var $this = $(this); // the file input field
        var isMultiple = $this.prop('multiple'); // check if 'multiple' is enabled
        
        // Get the current name attribute
        var fieldName = $this.attr('name');
        
        // If 'multiple' is enabled and '[]' is not already present, append it
        if (isMultiple && !fieldName.endsWith('[]')) {
            $this.attr('name', fieldName + '[]');
        } else if (!isMultiple && fieldName.endsWith('[]')) {
            // If 'multiple' is disabled and '[]' is present, remove it
            $this.attr('name', fieldName.slice(0, -2));
        }

        // //handling files 
        // const fieldName = $(this).attr('name'); // Identify the field name
        // const files = event.target.files;
        
        // // Prepare an array to store file data
        // const fileData = [];

        // // Loop through each file
        // for (let i = 0; i < files.length; i++) {
        //     // Collect file data for each file, including field name to distinguish it
        //     fileData.push({
        //         fieldName: fieldName,
        //         fileName: files[i].name,
        //         fileContent: files[i], // File object itself, or file data if pre-processed
        //     });
        // }
        
        // Send to backend (e.g., via AJAX) if needed immediately on change,
        // or store it and send all data together on form submission.
    });
    $('#my-form').on('input', 'input, textarea, select', function() {
        $(this).removeClass('error');
        $(this).next('.error-message').remove();
    });
    var formData = <?php echo $form_data; ?>;

    $('#rendered-form').formRender({
        formData: formData
    });
    // After rendering, find the file upload field and append the accepted file types
    var fileInput = $('#rendered-form input[type="file"]');
    // var acceptedTypes = fileInput.attr('accept'); // Get the accepted file types
    
    // Display the accepted file types beside the file input
    // if (acceptedTypes) {
        // fileInput.after('<small class="accepted-types">Accepted file types: ' + acceptedTypes.split(', ').join(', ') + '</small>');
        // }
        fileInput.before('<br/><small class="accepted-types">Accepted file types:  .jpg, .png, .gif, .pdf, .csv, .doc, docx, .xlsx</small>');

    // Allowed file types
//   var allowedFileTypes = ['image/jpeg', 'image/png','image/gif', 'application/pdf', 'text/xlsx'];
    var allowedFileTypes = [
        'image/jpeg', 
        'image/png', 
        'image/gif',
        'application/pdf',
        'text/csv',          // MIME type for CSV
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' , // MIME type for XLSX
        'application/msword', //fro DOC
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // for DOCX
    ];
    // Listen for changes on the file input field
    // $('#rendered-form').on('change', 'input[type="file"]', function() {
    //     // Get the list of selected files
    //     var files = this.files;

    //     // Check if any files were selected
    //     if (files.length > 0) {
    //     // Get the type of the first uploaded file
    //     var fileType = files[0].type;

    //     // Display the file type in the console or append it to the form
    //     console.log("Uploaded file type: " + fileType);

    //     // Optionally, display the file type next to the file input
    //     $(this).after('<small class="file-type-info">Uploaded file type: ' + fileType + '</small>');
    //     }
    // });
    
    // Hide the "Other" text field initially
    // $('.other-val').hide();

    // Listen for changes on the radio group
    $('#rendered-form').on('change', 'input[type="radio"]', function() {
        // var selectedValue = $('input[type="radio"]:checked').val();
        var $this = $(this);
        var selectedValue = $this.val();
        // Show the "Other" text field if "Other" is selected, hide it otherwise
        if (selectedValue === '') {
            
            $this.closest('.form-group').next('.other-val').show();
        } else {
            $('.other-val').css('display', 'none');
        }
    });
    
    $('#rendered-form').on('click', 'button[type="reset"]', function() {

        $('.other-val').hide();
    });


    $('#submit-form').click(function(e) {
        e.preventDefault(); // Prevent the default form submission
        var isValid = true;
        var errorMessage = "Please fill out this field.";

        // Loop through each input field in the form
        $('#rendered-form').find('input, textarea, select').each(function() {
            var $this = $(this);
            $this.removeClass('error');
            $this.next('.error-message').remove();
            // Skip validation for file inputs that are not required
            // if ($this.attr('type') === 'file' && !$this.prop('required') && $this.val() === '') {
            //     return true; // Skip this iteration
            // }
            // Check if the field is required
            if ($this.prop('required')) {
                
                if ($(this).attr('type') != 'hidden'){
                    if ($(this).is('select')) {
                        
                        //skipping file value requierd is its empty
                    }else{
                        // Check if the field is empty
                        if ($this.val().trim() === '') {
                            othererrorMessage="Please fill out this other field.";
                            // Check if the input type is 'radio'
                            if ($(this).attr('type') === 'radio' ) {
                                // alert($(this).attr('type'));
                                // if ($this.closest('.other-option').is(':checked')) {
                                //     if ($this.next('.other-val').val().trim() === '') {
                                //         isValid = false;
                                //         // Add an inline error message
                                //         $this.addClass('error'); // Add a class to highlight the field
                                //         if ($this.next('.error-message').length === 0) {
                                //             $this.closest('.radio-group').after('<span class="error-message">' + othererrorMessage + '</span>');
                                //         }
                                //     }else{
                                //         $this.removeClass('error');
                                //         $this.closest('.radio-group').next('.error-message').remove();
                                //     }
                                // }else{
                                //     // alert("test");
                                //         $this.removeClass('error');
                                //         $this.closest('.radio-group').next('.error-message').remove();
                                //     }
                                if ($this.closest('.other-option').is(':checked')) {
                                    // Check if the input field next to the "Other" option is empty
                                    if ($this.next('.other-val').val().trim() === '') {
                                        isValid = false;
                                        // Add an inline error message
                                        $this.addClass('error'); // Add a class to highlight the field
                                        // Check if the error message is already present in the radio group
                                        var $errorMessage = $this.closest('.radio-group').next('.error-message');
                                        if ($errorMessage.length === 0) {
                                            // Add the error message if it does not exist
                                            $this.closest('.radio-group').after('<span class="error-message">' + othererrorMessage + '</span>');
                                        }
                                    } else {
                                        // If the field is not empty, remove the error class and message
                                        $this.removeClass('error');
                                        var $errorMessage = $this.closest('.radio-group').next('.error-message');
                                        if ($errorMessage.length > 0) {
                                            // Remove the error message if it exists
                                            $errorMessage.remove();
                                        }
                                    }
                                } else {
                                    // If the "Other" radio button is not checked, remove the error class and message
                                    $this.removeClass('error');
                                    var $errorMessage = $this.closest('.radio-group').next('.error-message');
                                    if ($errorMessage.length > 0) {
                                        // Remove the error message if it exists
                                        $errorMessage.remove();
                                    }
                                }
                             } else if ( $(this).attr('type') === 'checkbox' ) {
                                // alert($(this).attr('type'));
                                if ($this.closest('.other-option').is(':checked')) {
                                    if ($this.next('.other-val').val().trim() === '') {
                                        isValid = false;
                                        // Add an inline error message
                                        $this.addClass('error'); // Add a class to highlight the field
                                        if ($this.next('.error-message').length === 0) {
                                            $this.closest('.checkbox-group').after('<span class="error-message">' + othererrorMessage + '</span>');
                                        }
                                    }else{
                                        $this.removeClass('error');
                                        $this.closest('.checkbox-group').next('.error-message').remove();
                                    }
                                }else{
                                    // alert("test");
                                        $this.removeClass('error');
                                        $this.closest('.checkbox-group').next('.error-message').remove();
                                    }
                            }else{
                                
                                
                                if($(this).attr('type') ==undefined){
                                    
                                    // alert($this.closest('.fb-autocomplete-label'));
                                    isValid = false;
                                    // Add an inline error message
                                    // $this.addClass('error'); // Add a class to highlight the field
                                    if ($this.closest('.form-group').next('.error-message').length === 0) {
                                        // $this.after('<span class="error-message">' + errorMessage + '</span>');
                                        $this.closest('.form-group').after('<span class="error-message">' + errorMessage + '</span>');
                                    }else{
                                       
                                    //    $this.closest('.form-group').removeClass('error');
                                    //    $this.closest('.form-group').next('.error-message').remove();
                                   }

                                }else{
                                    if($(this).attr('type')=="text"){
                                        if ($this.is(':visible')) {
                                            // alert("test");

                                            if ($this.val().trim() === '') {
                                                isValid = false;
                                                // Add an inline error message
                                                $this.addClass('error'); // Add a class to highlight the field
                                                if ($this.next('.error-message').length === 0) {
                                                    $this.after('<span class="error-message">' + errorMessage + '</span>');
                                                }
                                            }
                                        }
                                    }else{
                                        // alert($(this).attr('type'));
                                        isValid = false;
                                        // Add an inline error message
                                        $this.addClass('error'); // Add a class to highlight the field
                                        if ($this.next('.error-message').length === 0) {
                                            $this.after('<span class="error-message">' + errorMessage + '</span>');
                                        }
                                    }
                                    
                                    
                                }
                                
                            }
                        } else {
                            switch ($(this).attr('type')) {
                                case 'number':
                                    
                                    break;
                            
                                default:
                                    break;
                            }
                            if ($(this).attr('type') === 'number'){   
                                $this =$(this);
                                if (typeof $this.prop('min') === 'undefined' || $this.prop('min') === '') {
                                    let inputValue = $this.val();  // Get the current input value as a string
                                    let maxValue = parseInt($this.prop('maxlength'));  // Get maxlength, default to Infinity if not set
                                    $this.closest('.form-group').removeClass('error');
                                    $this.closest('.form-group').next('.error-message').remove();
                                    if (maxValue !== -1  && inputValue.length > maxValue) {
                                        isValid = false;
                                        isValid1 = false;
                                        $this.addClass('error');
                                        
                                        if ($this.closest('.form-group').next('.error-message').length === 0) {
                                            $this.closest('.form-group').after('<span class="error-message" style="color:red;">Maximum length allowed is ' + maxValue + ' characters.</span>');
                                        }
                                    } else {
                                        $this.closest('.form-group').removeClass('error');
                                        $this.closest('.form-group').next('.error-message').remove();
                                    }
                                    //skip
                                }else{   
                                    isValid1 =true;
                                    let minValue = parseFloat($this.prop('min'));  // Get the min value
                                    let maxValue = parseFloat($this.prop('max'));  // Get the max value
                                    let inputValue = parseFloat($this.val());  // Get the current input value
                                    
                                    $this.closest('.form-group').removeClass('error');
                                    $this.closest('.form-group').next('.error-message').remove();
                                    if (inputValue < minValue) {
                                        isValid = false;
                                        isValid1 = false;
                                        $this.addClass('error');
                                        
                                        if ($this.closest('.form-group').next('.error-message').length === 0) {
                                            $this.closest('.form-group').after('<span class="error-message" style="color:red;">Minimum value allowed is ' + minValue + '.</span>');
                                        }
                                    } else if (inputValue > maxValue) {
                                        isValid = false;
                                        isValid1 = false;
                                        $this.addClass('error');
                                        if ($this.closest('.form-group').next('.error-message').length === 0) {
                                            $this.closest('.form-group').after('<span class="error-message" style="color:red;">Maximum value allowed is ' + maxValue + '.</span>');
                                        }
                                    } else {
                                        $this.closest('.form-group').removeClass('error');
                                        $this.closest('.form-group').next('.error-message').remove();
                                    }
                                }
                                if(typeof $this.prop('max') === 'undefined' || $this.prop('max') === '') { 
                                    // skip
                                }else{
                                    if(isValid1 == false){
                                        //skip if alread min errorr
                                    }else{
                                        if (parseFloat($this.val()) > parseFloat($this.prop('max'))) {
                                            isValid = false;
                                            $this.addClass('error');
                                            if ($this.closest('.form-group').next('.error-message').length === 0) {
                                                // $this.after('<span class="error-message">Maximum value allowed is ( '+$this.prop('max')+' ).</span>');
                                                $this.closest('.form-group').after('<span class="error-message">Maximum value allowed is  '+$this.prop('max')+' .</span>');
                                            }else{
                                       
                                                // $this.closest('.form-group').removeClass('error');
                                                // $this.closest('.form-group').next('.error-message').remove();
                                            }
                                        }else{
                                            $this.closest('.form-group').removeClass('error');
                                            $this.closest('.form-group').next('.error-message').remove();
                                        }
                                    }
                                    
                                }
                            } else if ($(this).attr('type') === 'textarea' || $(this).attr('type') === 'text'){   
                                $this =$(this);
                                let inputValue = $this.val();  // Get the current input value as a string
                                let maxValue = parseInt($this.prop('maxlength'));  // Get maxlength, default to Infinity if not set
                                $this.closest('.form-group').removeClass('error');
                                $this.closest('.form-group').next('.error-message').remove();
                                if (maxValue !== -1 && inputValue.length > maxValue) {
                                    isValid = false;
                                    isValid1 = false;
                                    $this.addClass('error');
                                    
                                    if ($this.closest('.form-group').next('.error-message').length === 0) {
                                        $this.closest('.form-group').after('<span class="error-message" style="color:red;">Maximum length allowed is ' + maxValue + ' characters.</span>');
                                    }
                                } else {
                                    $this.closest('.form-group').removeClass('error');
                                    $this.closest('.form-group').next('.error-message').remove();
                                }
                                //skip
                            } else if ($(this).attr('type') === 'tel') {
                                // Check if the input field is of type 'telephone'
                                var phoneValue = $(this).val();
                                
                                // Regular expression to validate a 10-digit phone number (adjust if needed)
                                // var phoneRegex = /^\d{10}$/;
                                // var phoneRegex = /^[+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,4}[-\s\.]?[0-9]{1,9}$/;
                                var phoneRegex = /^[+]?[(]?[0-9]{1,1}[)]?[-\s\.]?[0-9]{1,1}[-\s\.]?[0-9]{1,9}$/;
                                
                                if (!phoneRegex.test(phoneValue)) {
                                    // Show an alert if the validation fails
                                    // alert('Please enter a valid 10-digit phone number.'); 
                                    isValid = false;
                                    $this.addClass('error');
                                    if ($this.closest('.form-group').next('.error-message').length === 0) {
                                        $this.closest('.form-group').after('<span class="error-message">Please enter a valid phone number</span>');
                                    }
                                }else{
                                        $this.closest('.form-group').removeClass('error');
                                        $this.closest('.form-group').next('.error-message').remove();
                                    }
                            }else if ($(this).attr('type') === 'email') {
                                var emailValue = $(this).val();
                                
                                // Regular expression for validating email
                                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                                
                                if (!emailRegex.test(emailValue)) {
                                    isValid = false;
                                    $this.addClass('error');
                                    if ($this.closest('.form-group').next('.error-message').length === 0) {
                                        $this.closest('.form-group').after('<span class="error-message">Please enter a valid Email</span>');
                                    }
                                }else{
                                    $this.closest('.form-group').removeClass('error');
                                    $this.closest('.form-group').next('.error-message').remove();
                                }
                            }else{
                                // Remove the error message if the field is not empty
                                $this.removeClass('error');
                                $this.next('.error-message').remove();
                                                                       
                                       $this.closest('.form-group').removeClass('error');
                                       $this.closest('.form-group').next('.error-message').remove();
                                   
                            }
                        }
                    }
                }
            }else{
                if ($(this).attr('type') === 'number'){   
                    $this =$(this);
                    isValid1 =true; 
                    if (typeof $this.prop('min') === 'undefined' || $this.prop('min') === '') {
                        
                        //skip
                    }else{   
                                                
                        if (parseFloat($this.val()) < parseFloat($this.prop('min'))) {
                            isValid = false;
                            isValid1 = false;
                            $this.addClass('error');
                            
                            if ($this.closest('.form-group').next('.error-message').length === 0) {
                                // $this.after('<span class="error-message">Minimum value allowed is ( '+$this.prop('min')+' ).</span>');
                                $this.closest('.form-group').after('<span class="error-message" style="color:red;">Minimum value allowed is  '+$this.prop('min')+' .</span>');
                            }else{                                
                                // $this.closest('.form-group').removeClass('error');
                                // $this.closest('.form-group').next('.error-message').remove();
                            }
                        }else{
                            
                            $this.closest('.form-group').removeClass('error');
                            $this.closest('.form-group').next('.error-message').remove();
                        }
                    }
                    if(typeof $this.prop('max') === 'undefined' || $this.prop('max') === '') { 
                        // skip
                    }else{
                        if(isValid1 == false){
                            //skip if alread min errorr
                        }else{
                            if (parseFloat($this.val()) > parseFloat($this.prop('max'))) {
                                isValid = false;
                                $this.addClass('error');
                                if ($this.closest('.form-group').next('.error-message').length === 0) {
                                    // $this.after('<span class="error-message">Maximum value allowed is ( '+$this.prop('max')+' ).</span>');
                                    $this.closest('.form-group').after('<span class="error-message">Maximum value allowed is  '+$this.prop('max')+' .</span>');
                                }else{                                       
                                    //    $this.closest('.form-group').removeClass('error');
                                    //    $this.closest('.form-group').next('.error-message').remove();
                                   }
                            }else{
                                $this.closest('.form-group').removeClass('error');
                                $this.closest('.form-group').next('.error-message').remove();
                            }
                        }
                        
                    }
                }else if ($(this).attr('type') === 'tel') {
                    // Check if the input field is of type 'telephone'
                    var phoneValue = $(this).val();
                    
                    // Regular expression to validate a 10-digit phone number (adjust if needed)
                    // var phoneRegex = /^\d{10}$/;
                    // var phoneRegex = /^[+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,4}[-\s\.]?[0-9]{1,9}$/;
                    var phoneRegex = /^[+]?[(]?[0-9]{1,1}[)]?[-\s\.]?[0-9]{1,1}[-\s\.]?[0-9]{1,9}$/;
                    
                    if (phoneValue && !phoneRegex.test(phoneValue)) {
                        // Show an alert if the validation fails
                        // alert('Please enter a valid 10-digit phone number.'); 
                        isValid = false;
                        $this.addClass('error');
                        if ($this.closest('.form-group').next('.error-message').length === 0) {
                            $this.closest('.form-group').after('<span class="error-message">Please enter a valid phone number</span>');
                        }
                    }else{
                            $this.closest('.form-group').removeClass('error');
                            $this.closest('.form-group').next('.error-message').remove();
                        }
                }else if ($(this).attr('type') === 'checkbox' ) {
                    // alert($(this).attr('type'));
                    othererrorMessage="Please fill out this other field.";
                    if ($this.closest('.other-option').is(':checked')) {
                        // alert($this.next('.other-val'))
                        if ($this.next('.other-val').val().trim() === '') {
                            isValid = false;
                            // Add an inline error message
                            $this.addClass('error'); // Add a class to highlight the field
                            if ($this.next('.error-message').length === 0) {
                                $this.closest('.checkbox-group').after('<span class="error-message">' + othererrorMessage + '</span>');
                            }
                        }else{
                            $this.removeClass('error');
                            $this.closest('.checkbox-group').next('.error-message').remove();
                        }
                    }else {
                        // alert("test");
                        $this.removeClass('error');
                        $this.closest('.checkbox-group').next('.error-message').remove();
                    }
                }else if ($(this).attr('type') === 'radio') {
                    // alert($(this).attr('type'));
                    othererrorMessage="Please fill out this other field.";
                    if ($this.closest('.other-option').is(':checked')) {
                        // alert($this.next('.other-val'))
                        if ($this.next('.other-val').val().trim() === '') {
                            isValid = false;
                            // Add an inline error message
                            $this.addClass('error'); // Add a class to highlight the field
                            if ($this.next('.error-message').length === 0) {
                                $this.closest('.radio-group').after('<span class="error-message">' + othererrorMessage + '</span>');
                            }
                        }else{
                            $this.removeClass('error');
                            $this.closest('.radio-group').next('.error-message').remove();
                        }
                    }else {
                        // alert("test");
                        $this.removeClass('error');
                        $this.closest('.radio-group').next('.error-message').remove();
                    }
                }else if ($(this).attr('type') === 'email') {
                        var emailValue = $(this).val();
                        
                        // Regular expression for validating email
                        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                        
                        if (emailValue && !emailRegex.test(emailValue)) {
                            isValid = false;
                            $this.addClass('error');
                            if ($this.closest('.form-group').next('.error-message').length === 0) {
                                $this.closest('.form-group').after('<span class="error-message">Please enter a valid Email</span>');
                            }
                        }else{
                            $this.closest('.form-group').removeClass('error');
                            $this.closest('.form-group').next('.error-message').remove();
                        }
                    }
            }
            
            // if($(this).attr('type') === 'checkbox' ) {
            //     // alert($(this).attr('type'));
            //     //
            //     // if ($('.other-option').is(':checked') && $this.val().trim() === '') {
            //     if ($this.closest('.other-option').is(':checked') && $this.val().trim() === '') {
            //         if ($('.other-val').val().trim() === '') {
            //             isValid = false;
            //             // Add an inline error message
            //             $this.addClass('error'); // Add a class to highlight the field
            //             if ($this.next('.error-message').length === 0) {
            //                 $this.after('<span class="error-message">' + errorMessage + '</span>');
            //             }
            //         }else{
            //             $this.removeClass('error');
            //             $this.closest('.radio-group').next('.error-message').remove();
            //         }
            //     }else{
            //         // alert("test");
            //             $this.removeClass('error');
            //             $this.closest('.radio-group').next('.error-message').remove();
            //         }
            // }
            if($(this).attr('type') === 'file'){
                
                var $this = $(this);
                var name = $this.attr('name');
                var name1 ='#'+name+''; 
                // Get the file input element
                // if ($this.val().trim() === '') {
                // var fileInput = $(name1)[0];
                // var file = fileInput.files[0]; // Get the first (and likely only) file
                var files = this.files;
                // alert(files.type);
                if (files.length > 0) {
                    var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
                    if (files.length > 1) {
                        
                        for (let i = 0; i < files.length; i++) {
                        // files.forEach(element => {
                            // var fileType = element.type;
                            var fileType = files[i].type;
                            // alert(fileType);
                            // Check if the file type is allowed
                            if ($.inArray(fileType, allowedFileTypes) === -1) {
                                // alert(fileType);
                                isValid = false;
                                $this.addClass('error');
                                if ($this.next('.error-message').length === 0) {
                                    $this.after('<span class="error-message">Invalid file type/s. Please upload valid file/s</span>');
                                }
                            }else if (files[i].size > maxSize) {
                                isValid = false;
                                $this.addClass('error');
                                if ($this.next('.error-message').length === 0) {
                                    $this.after('<span class="error-message">One or more selected files exceed 2 MB. Please choose smaller files.</span>');
                                }
                            }else{
                                // alert("no");
                                $this.removeClass('error');
                                $this.closest('.radio-group').next('.error-message').remove();
                            }
                        // });
                        }
                    }else{
                        //single file
                        var fileType = files[0].type;
                        // Check if the file type is allowed
                        if ($.inArray(fileType, allowedFileTypes) === -1) {
                            isValid = false;
                            $this.addClass('error');
                            if ($this.next('.error-message').length === 0) {
                                $this.after('<span class="error-message">Invalid file type/s. Please upload valid file/s</span>');
                            }
                        }else if (files[0].size > maxSize) {
                                isValid = false;
                                $this.addClass('error');
                                if ($this.next('.error-message').length === 0) {
                                    $this.after('<span class="error-message">The selected file exceeds 2 MB. Please choose a smaller file.</span>');
                                }
                        }else{
                            $this.removeClass('error');
                            $this.closest('.radio-group').next('.error-message').remove();
                        }
                    }
                    
                }else{
                    if ($this.prop('required')) {
                        isValid = false;
                        $this.addClass('error');
                        if ($this.next('.error-message').length === 0) {
                            $this.after('<span class="error-message">' + errorMessage + '</span>');
                        }
                    }else{
                            $this.removeClass('error');
                            $this.closest('.radio-group').next('.error-message').remove();
                        }
                }
            }
        });
        // // Iterate over each checkbox group that has aria-required set to true
        // $('#rendered-form').find('.checkbox-group input[type="checkbox"]').each(function() {
        //     var $this = $(this);
        //     var isAriaRequired = $this.attr('aria-required') === 'true';
        //     var isChecked = $this.is(':checked');
        //     // If aria-required is true and the checkbox is checked
        //     // if (isAriaRequired && isChecked) {
        //     if (isChecked) {
        //         // var $otherInput = $this.closest('.checkbox-group').find('.other-value');
        //         var otherInput = $this.next('.other-value');
        //         // alert("tets");
        //         alert(otherInput.val());
                
        //         // Check if the 'Other' input field is empty
        //         if(!$this.next('.other-value').val()) {
        //             // alert('Please fill out the "Other" field.');
        //             // hasError = true;
        //             // return false;  // Stop further validation
        //             isValid = false;
        //             // Add an inline error message
        //             $this.addClass('error'); // Add a class to highlight the field
        //             if ($this.closest('.radio-group').next('.error-message').length === 0) {
        //                 $this.closest('.radio-group').after('<span class="error-message">' + errorMessage + '</span>');
        //             }
        //         }else{
        //             $this.removeClass('error');
        //             $this.closest('.radio-group').next('.error-message').remove();
        //         }
            
        //         if($checkbox.next('.other-value').val().trim() === ''){
        //             isValid = false;
        //             // Add an inline error message
        //             $this.addClass('error'); // Add a class to highlight the field
        //             if ($this.next('.error-message').length === 0) {
        //                 $this.after('<span class="error-message">' + errorMessage + '</span>');
        //             }
        //         }else{
        //             $this.removeClass('error');
        //             $this.closest('.radio-group').next('.error-message').remove();
        //         }
            
        //     }
        // });

        // Loop through each select, radio, and checkbox group in the form
        $('#rendered-form').find('select, input[type="radio"], input[type="checkbox"]').each(function() {
            var $this = $(this);
            var reqValue =$(this).prop('aria-required');
            // alert(reqValue);
            // Check if the field is required
            // if ($this.prop('aria-required')) {
            if ($this.prop('required')) {

                if ($this.is('select')) {
                   
                    // Check if a value is selected in the dropdown
                    if ($this.val() === null || $this.val() === '') {
                        if ($this.val() === null){
                            isValid = false;
                            $this.addClass('error');
                            if ($this.next('.error-message').length === 0) {
                                $this.after('<span class="error-message">' + errorMessage + '</span>');
                            }
                        }else{
                            if ($('#other-text').val().trim() === '') {
                                //skip if other text box is not selected
                            }else{
                                isValid = false;
                                $this.addClass('error');
                                if ($this.next('.error-message').length === 0) {
                                    $this.after('<span class="error-message">' + errorMessage + '</span>');
                                }
                            }
                        }
                        
                    } else {
                    // $this.removeClass('error');
                    // $this.next('.error-message').remove();
                        
                    }
                }

                if ($this.is('input[type="radio"]')) {
                    // Check if any radio in the group is selected
                    var name = $this.attr('name');
                    if ($('input[name="' + name + '"]:checked').length === 0) {
                        if ($('.other-val').val().trim() === '') {
                            //skip if other text box is not selected
                        }else{
                            isValid = false;
                            $('input[name="' + name + '"]').addClass('error');
                            if ($this.closest('.radio-group').next('.error-message').length === 0) {
                                $this.closest('.radio-group').after('<span class="error-message">' + errorMessage + '</span>');
                            }
                        }
                    } else {
                        if ($('.other-option').is(':checked')) {
                            if ($('.other-val').val().trim() === '') {
                                //skip if other text box is not 
                                // alert("test");
                            }else{
                                $('input[name="' + name + '"]').removeClass('error');
                                $this.closest('.radio-group').next('.error-message').remove();
                            }
                        }else{
                            // alert("test");
                                $('input[name="' + name + '"]').removeClass('error');
                                $this.closest('.radio-group').next('.error-message').remove();
                            }
                    }
                }

                if ($this.is('input[type="checkbox"]')) {
                    // alert("test2");
                    // Check if any checkbox in the group is selected
                    var name = $this.attr('name');
                    if ($('input[name="' + name + '"]:checked').length === 0) {
                        isValid = false;
                        $('input[name="' + name + '"]').addClass('error');
                        if ($this.closest('.checkbox-group').next('.error-message').length === 0) {
                            $this.closest('.checkbox-group').after('<span class="error-message">' + errorMessage + '</span>');
                        }
                    } else {
                        
                        if ($('.other-option').is(':checked')) {
                            
                            if ($('.other-val').val().trim() === '') {
                                isValid = false;
                                // Add an inline error message
                                $('input[name="' + name + '"]').addClass('error'); // Add a class to highlight the field
                                if ($this.next('.error-message').length === 0) {
                                    $this.after('<span class="error-message">' + errorMessage + '</span>');
                                }
                            }else{
                                $('input[name="' + name + '"]').removeClass('error');
                                $this.closest('.radio-group').next('.error-message').remove();
                            }
                        }else{
                            // alert("test");
                            $('input[name="' + name + '"]').removeClass('error');
                            $this.closest('.checkbox-group').next('.error-message').remove();
                        }
                    }
                }
            }
            // Capture the form data
            var formData = $('#rendered-form').serializeArray(); // Serialize form data into an array of name-value pairs

            // Initialize an object to store the data
            var dataToSave = {};

            // Loop through the serialized data to save values instead of labels
            $.each(formData, function(index, field) {
            var fieldName = field.name;
            var fieldValue = field.value;

            // Store the field's value in the dataToSave object
            dataToSave[fieldName] = fieldValue;
            });
        });
        
        
        // If the form is valid, submit it
        if (isValid) {
            // Create a FormData object
            var formElement = $('#rendered-form')[0];
            var formDataObj = new FormData(formElement);

            // Add custom fields to the FormData object
            formDataObj.append('form_id', <?php echo $form_id; ?>);

            // console.log('Form Data:', formDataObj); // Debugging line
            //  // Collect files again or use pre-collected file data
            // $('input[type="file"]').each(function() {
            //     const fieldName = $(this).attr('name');
            //     const files = this.files;

            //     for (let i = 0; i < files.length; i++) {
            //         // Append each file with a unique key in FormData
            //         formDataObj.append(`${fieldName}[]`, files[i]); // Use field name as key
            //     }
            // });
            
            $('#rendered-form').find('select, input[type="radio"], input[type="checkbox"]').each(function() {
                // Capture the form data
                var formData = $('#rendered-form').serializeArray(); // Serialize form data into an array of name-value pairs

                // Initialize an object to store the data
                var dataToSave = {};

                // Loop through the serialized data to save values instead of labels
                $.each(formData, function(index, field) {
                var fieldName = field.name;
                // var fieldValue = field.value;
                var fieldLable = field.lable;

                // Store the field's value in the dataToSave object
                // formDataObj[fieldName] = fieldValue;
                formDataObj[fieldName] = fieldLable;
                });
            });
            // Check form validity
            if (!formElement.checkValidity()) {
                $('#rendered-form').addClass('was-validated');
                return;
            }
            $('#submit-form').prop('disabled', true); //added by sagar to disable save button not to resubmit while form saving
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
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                        
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', xhr.responseText); // Debugging line
                }
            });
        }
    });
});

</script>
<script src="<?php echo base_url();?>assets_drag/js/vendor.js"></script>
<script src="<?php echo base_url();?>assets_drag/js/form-builder.min.js"></script>
<script src="<?php echo base_url();?>assets_drag/js/form-render.min.js"></script>