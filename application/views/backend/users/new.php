<h1><?php echo lang('create_user_heading'); ?></h1>
<p><?php echo lang('create_user_subheading'); ?></p>

<div id="infoMessage"><?php echo $message; ?></div>

<?php echo form_open("", 'class="form-horizontal" id="form-user"'); ?>

<div class="form-group">
    <label for="first_name" class="col-md-2 control-label">First Name</label>
    <div class="col-md-5">
        <?php echo form_input($first_name); ?>
    </div>
</div>

<div class="form-group">
    <label for="last_name" class="col-md-2 control-label">Last Name</label>
    <div class="col-md-5">
        <?php echo form_input($last_name); ?>
    </div>
</div>

<div class="form-group">
    <label for="company" class="col-md-2 control-label">Company</label>
    <div class="col-md-5">
        <?php echo form_input($company); ?>
    </div>
</div>

<div class="form-group">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-5">
        <?php echo form_input($email); ?>
    </div>
</div>

<div class="form-group">
    <label for="phone" class="col-md-2 control-label">Phone</label>
    <div class="col-md-5">
        <?php echo form_input($phone); ?>
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-md-2 control-label">Password</label>
    <div class="col-md-5">
        <?php echo form_input($password); ?>
    </div>
</div>

<div class="form-group">
    <label for="password_confirm" class="col-md-2 control-label">Password Confirm</label>
    <div class="col-md-5">
        <?php echo form_input($password_confirm); ?>
    </div>
</div>
<div class="form-group">
    <label for="groups" class="col-md-2 control-label">Role</label>
    <div class="col-md-5">
        <?php echo form_dropdown('groups', $groups, '', 'class="form-control"'); ?>
    </div>
</div>


<div class="form-group">
    <label for="first_name" class="col-md-2 control-label sr-only">First Name</label>
    <div class="col-md-5">
        <?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="btn btn-default"'); ?>
    </div>
</div>

<?php echo form_close(); ?>
<script>
    $('#form-user').validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            company: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                minlength: 2,
                email: true,
                remote: {
                    url: "<?php echo site_url('admin/users/cek_email'); ?>",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#email").val();
                        }
                    }
                }
            },
            phone: {
                required: true,
                number: true,
                min: 1,
            },
            password: {
                required: true,
                minlength: 2
            },
            password_confirm: {
                equalTo: "#password"
            }
        },
        messages: {
            first_name: {
                required: "First Name Required!",
                minlength: jQuery.format("At least {0} characters!"),
            },
            last_name: {
                required: "Last Name Required!",
                minlength: jQuery.format("At least {0} characters!"),
            },
            company: {
                required: "Company Required!",
                minlength: jQuery.format("Should be bigger than {0}!"),
            },
            email: {
                required: "Email Required!",
                minlength: jQuery.format("At least {0} characters!"),
                email: "Not a Valid Email!",
                remote: jQuery.format("{0} is already in use")
            },
            phone: {
                required: "Phone Required!",
                min: jQuery.format("Should be bigger than {0}!"),
                number: "Must be Number!",
            },
            password: {
                required: "Password Required!",
                minlength: jQuery.format("At least {0} characters!"),
            },
            password_confirm: {
                equalTo: "Different with password",
            }
        },
        submitHandler: function(form) {
            $.post("<?php echo site_url('admin/users/create_new'); ?>", $(form).serialize(), function(msg) {
                $('#form-user input[type="text"]').val('');
                $('#form-user input[type="password"]').val('');
                $.notify("User Saved", {position: "top center", className: "success"});
            }).done(function(e){
                $('#myTab a:first').tab('show');
            });
        }
    });
</script>