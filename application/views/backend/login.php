<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Please sign in</h3>
    </div>
    <div class="panel-body">
        <?php echo form_open("login/login", 'id="form-login"'); ?>
        <fieldset>
            <div class="form-group">
                <input class="form-control" placeholder="E-Mail" name="identity" type="email" required>
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
            </div>
            <div class="checkbox">
                <label>
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?> Remember Me
                </label>
            </div>
            <input class="btn btn-lg btn-danger btn-block" type="submit" value="Login">
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
    $('#form-login').submit(function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(data) {
            if (data.valid) {
                window.location.href = "<?php echo site_url('admin/places'); ?>";
                $.notify(data.msg, {position: "top center", className: "success"});
            } else {
                $.notify(data.msg, {position: "top center", className: "error"});
            }
        }, 'json');

    });
</script>