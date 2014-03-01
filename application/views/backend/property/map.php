<?php echo $map['js']; ?>
<form class="form-horizontal" role="form" id="form_map"> 
    <?php echo form_input($id); ?>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Address</label>
        <div class="col-lg-7">
            <?php echo form_input($address); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Town</label>
        <div class="col-lg-7">
            <?php echo form_input($town); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Province</label>
        <div class="col-lg-7">
            <?php echo form_input($province); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Country</label>
        <div class="col-lg-7">
            <?php echo form_input($country); ?>
        </div>
    </div>
    <?php echo form_input($coord); ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">SAVE</button>
        </div>
    </div>
</form>
<?php echo $map['html']; ?>