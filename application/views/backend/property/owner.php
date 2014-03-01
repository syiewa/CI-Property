<form class="form-horizontal" role="form" id="form_owner"> 
    <div class="form-group" id="errors">
    </div>
    <?php echo form_input($id); ?>
    <div class="form-group has-feedback">
        <label class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-5">
            <?php echo form_input($name_owner); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-5">
            <?php echo form_input($email_owner); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputEmail3" class="col-md-2 control-label">Address</label>
        <div class="col-md-5">
            <?php echo form_textarea($adds_owner); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputPassword3" class="col-md-2 control-label">Telephone</label>
        <div class="col-md-5">
            <?php echo form_input($telp_owner); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputPassword3" class="col-md-2 control-label">Mobile Phone</label>
        <div class="col-md-5">
            <?php echo form_input($mob_owner); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" id="save_owner">SAVE</button>
        </div>
    </div> 
</form>