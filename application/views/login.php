<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/custom.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/css/style.css">
        <title> :: Kaznet ::</title>
    </head>
    <style>
        .login-text {
    font-size: 50px;
    font-weight: 800;
}

.w-384px {
    max-width: 384px;
}

.btn-signin {
    background: #6D1024;
    border-radius: 5px;
    height: 39px;
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 19px;
    text-align: center;
    color: #FFFFFF;
}
.form-control:focus {
    color: #475F7B;
    background-color: #FFF;
    border-color: #6F1B28;
    outline: 0;
    box-shadow: none!important;
}
.form-control.login-form {
    height: calc(1.5em + 0.75rem + 10px) !important;
    border: 1px solid #c6c6c670 !important;
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    font-size: 14px!important;
    line-height: 19px;
    color: #00000080!important;
}


.btn-signin:hover {
    background: #6D1024;
    border-radius: 5px;
    height: 39px;
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 19px;
    text-align: center;
    color: #FFFFFF;
}

.text-forget {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 19px;
    text-align: center;
    color: #0054A2;
}

.text-forget:hover {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    line-height: 19px;
    text-align: center;
    color: #0054A2;
}

.text-label {
    font-style: normal;
    font-weight: 700;
    font-size: 12px;
    line-height: 16px;
    color: #000000;
}

.grid-align {
    display: grid;
    align-items: center;
}

.login-banner-image {
    width: 100%;
    height: 100vh;
    object-fit: cover;
}

.login-banner-image img {
    height: 100vh;
}
    </style>

    <body class="">
        
        <div class="wrapper bg-white">
        <section class="bg-white">
            <div class="container-fluid pl-0">
                <div class="row  no-gutters">
                    <div class="col-md-6 d-none d-md-block">
                        <img src="<?php echo base_url(); ?>include/assets/images/left-bg-login-light.png"
                            class="img-fluid" style="min-height:100vh;" />
                    </div>
                    <div class="col-md-6 bg-white grid-align">
                       <div class="w-384px m-auto">
                        <div class="form-style">
                        <?php echo form_open('', array('class' => 'form-horizontal form-simple')); ?>
                                <h3 class="pb-3 login-text">Kaznet Login</h3>
                                <div class="form-group pb-2">
                                    <label class="text-label">Email Address/Username</label>
                                    <input type="text" placeholder="Email / Username" name="email" class="form-control login-form" id="email" value="<?php echo $email; ?>" autocomplete="off" />
                                    <span class="text-danger email error" id="email-error"></span>
                                </div>
                                <div class="form-group">
                                    <label class="text-label" for="password">Password</label>
                                    <input type="password" placeholder="Password" class="form-control login-form" name="password" id="password"/>
                                    <span class="text-danger password error" id="password-error"></span>
                                </div>
                                <span class="text-danger error" id="form-error"></span>
                                <!-- <div class="d-flex align-items-center justify-content-end">
                                    <div><a class="text-forget" href="#">Forget Password?</a></div>
                                </div> -->
                                <div class="pb-2 mt-3">
                                    <button type="submit" class="btn btn-signin w-100 mt-2">SignIn</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo base_url(); ?>include/assets/js/jquery.slim.min.js"></script>
        <script src="<?php echo base_url(); ?>include/js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/bootstrap.bundle.min.js"></script>

        <!-- Page Script -->
        <script type="text/javascript">
            $(function(){
                $('form').on('submit', function(event) {
                    event.preventDefault();
                    $('.error').html('');
                    $('button[type="submit"]').attr('disabled', 'disabled').html('Please Wait...');

                    initLogin($(this), false);
                });
            });

            function initLogin(form, email) {
                var url = '<?php echo base_url(); ?>auth/login/';
                
                fromData = new FormData(form[0]);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fromData,
                    processData: false,
                    contentType: false,
                    complete: function(data) {
                        var csrfData = JSON.parse(data.responseText);
                        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                            $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                        }
                    },
                    error: function() {
                        $('#form-error').html('Could not establish connection to server. Please refresh the page and try again.');
                        $('button[type="submit"]').removeAttr('disabled').html('Sign in');
                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        if(data.status == 0) {
                            $('button[type="submit"]').removeAttr('disabled').html('LOGIN');
                            $('#email-error').html(data.email);
                            $('#password-error').html(data.password);
                            $('#form-error').html(data.form);
                        } else {
                            window.location.href = data.redirect;
                        }
                    }
                });
            }
        </script>
    </body>

</html>