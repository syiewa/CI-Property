<?php echo form_open("users/edit", 'class="form-horizontal" id="edit_user"'); ?>
<?php echo form_input($id); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Edit Users</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="first_name" class="col-md-3 control-label">First Name</label>
                <div class="col-md-5">
                    <?php echo form_input($first_name); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="last_name" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-5">
                    <?php echo form_input($last_name); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="company" class="col-md-3 control-label">Company</label>
                <div class="col-md-5">
                    <?php echo form_input($company); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-5">
                    <?php echo form_input($phone); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-md-3 control-label">Password</label>
                <div class="col-md-5">
                    <?php echo form_input($password); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirm" class="col-md-3 control-label">Password Confirm</label>
                <div class="col-md-5">
                    <?php echo form_input($password_confirm); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="groups" class="col-md-3 control-label">Role</label>
                <div class="col-md-5">
                    <?php echo form_dropdown('groups', $groups, $currentGroups[0]->id, 'class="form-control"'); ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php
            $data = array(
                "value" => 'Submit',
                "class" => 'btn btn-primary',
                "id" => 'x',
                "name" => 'submit'
            );
            ?>
            <?php echo form_submit($data); ?>
            <?php echo form_reset('reset', 'Reset', 'class="btn btn-primary"'); ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div>
<?php echo form_close(); ?>
<script>
    $(function() {
        
    });
</script>