<link href="<?php echo base_url(); ?>include/assets/css/bootstrap-select.min.css" rel="stylesheet" />
<style>
  .vertical-layout{
    margin-top: 10px;
  }
  .error {
    color: red;
    font-size: 13px;
  }
  .treeview {
        float: left;
        width: 100%;
        background-color: #f5f5f5;
        padding: 15px 30px 30px;
    }

    .treeview ul {
        float: left;
        width: 100%;
        position: relative;
    }

    .treeview ul li {
        float: left;
        width: 100%;
        border-left: 1px solid #C6C6C6 !important;
        padding: 9px 0px;
        list-style-type: none;
    }

    .treeview ul li div {
        float: left;
        width: 100%;
        font-family: Arial;
        font-size: 15px;
        color: #444;
        line-height: 1.5;
        padding-left: 33px;
        position: relative;
        bottom: -20px;
    }

    .treeview ul li div:before {
        content: "";
        width: 30px;
        height: 1px;
        background-color: #C6C6C6 !important;
        position: absolute;
        top: 50%;
        bottom: 50%;
        left: 0;
    }

    .treeview ul li ul {
        margin: 20px 0;
    }

    .treeview ul li ul li {
        border-left-color: #aaa;
        margin-left: 50px;
        width: calc(100% - 50px);
    }

    .treeview ul li ul li div {
        color: #444;
        padding-left: 15px;
    }

    .treeview ul li ul li div:before {
        background-color: #aaa;
        width: 10px;
    }
</style>



    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item">
                            <a href="#">Notification</a>
                        </li>
                        <li class="breadcrumb-item active">Send Alert</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card mt-3 border-0">
                    <div class="card-body">
                    <?php echo form_open('', array('id' => 'notificationForm', 'autocomplete' => 'off')); ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="label-text-1">Select Contributor</label>
                                    <select class="form-control selectpicker" name="user[]" title="Search and select user(s)" data-live-search="true" multiple>
                                        <?php foreach ($contributers as $key => $user) { ?>
                                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="label-text-1">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter....">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="label-text-1">Message</label>
                                    <textarea class="form-control" name="message" rows="4" style="resize:vertical;" placeholder="Enter...."></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h6 class="error"></h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-submit text-white" type="submit">Send Alert</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>include/assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('.selectpicker').selectpicker();
});

// Define global variable ajaxData
var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

//Handle form submit
$('body').on('submit', '#notificationForm', function(event) {
    event.preventDefault();
    $('.error').empty();

    let user = $('[name="user[]"]');
    let title = $('[name="title"]');
    let message = $('[name="message"]');

    if(user.val().length == 0 || title.val() == '' || message.val() == '') {
      $('.error').html('All the fields are mandatory.');
      return false;
    }

    $('#notificationForm').find('button').prop('disabled', true);
    //send ajax request to send alert notification
    ajaxData['user_id'] = user.val();
    ajaxData['title'] = title.val();
    ajaxData['message'] = message.val();
    $.ajax({
        url: '<?php echo base_url(); ?>notification/manual_push',
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
            $('#notificationForm').find('button').prop('disabled', false);
            $.toast({
                heading: 'Network Error!',
                text: 'Could not establish connection to server. Please refresh the page and try again.',
                icon: 'error'
            });
        },
        success: function(response) {
            $('#notificationForm').find('button').prop('disabled', false);

            // If session error exists
            if(response.session_err == 1) {
                $.toast({
                    heading: 'Session Error!',
                    text: response.msg,
                    icon: 'error'
                });
                return false;
            }

            if(response.status == 1) {
                // If update completed
                $.toast({
                    heading: 'Success!',
                    text: response.msg,
                    icon: 'success'
                });
                $('#notificationForm')[0].reset();
                $('.selectpicker').selectpicker('refresh');
            } else if(response.status == 0) {
                $.toast({
                    heading: 'Error!',
                    text: response.msg,
                    icon: 'error'
                });
            }
        }
    });
});
</script>
