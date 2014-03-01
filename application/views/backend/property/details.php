<form class="form-horizontal" role="form" id="form_detail"> 
    <?php echo form_input($id); ?>
    <?php echo form_input($id_detail); ?>
    <div class="form-group">
        <label for="inputJab" class="col-lg-2 control-label">Status</label>
        <div class="col-lg-4">
            <?php echo form_dropdown('status', $status_detail, $detail->status, 'class="form-control" id="status"'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputJab" class="col-lg-2 control-label">Type</label>
        <div class="col-lg-5">
            <?php echo form_dropdown('id_type', $type, $detail->id_type, 'class="form-control" id="type"'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputName" class="col-lg-2 control-label">Price</label>
        <div class="col-lg-1">
            <label class="control-label"><?php echo $currency[getOptions('currency')]; ?></label>
        </div>
        <div class="col-lg-5">
            <?php echo form_input($prices); ?> 
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputName" class="col-lg-2 control-label">Year Built</label>
        <div class="col-lg-5">
            <?php echo form_input($year_built); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputName" class="col-lg-2 control-label">Lot Dimension</label>
        <div class="col-lg-5">
            <?php echo form_input($lot_dim); ?>
        </div>
        <div class="col-lg-5">
            <label class="control-label"><?php echo $floor[getOptions('floor_metric')]; ?></label>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Floor Dimension</label>
        <div class="col-lg-5">
            <?php echo form_input($floor_dim); ?>
        </div>
        <div class="col-lg-5">
            <label class="control-label"><?php echo $floor[getOptions('floor_metric')]; ?></label>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Bedrooms</label>
        <div class="col-lg-5">
            <?php echo form_input($bedrooms); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Bathrooms</label>
        <div class="col-lg-5">
            <?php echo form_input($bathrooms); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputJab" class="col-lg-2 control-label">Description</label>
        <div class="col-lg-7">
            <?php echo form_textarea($desc); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">SAVE</button>
        </div>
    </div> 
</form> 