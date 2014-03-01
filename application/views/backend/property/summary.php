<form class="form-horizontal" role="form" id="form_new_place"> 
    <?php echo form_input($id); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">Added On</label>
        <div class="col-sm-10">
            <p class="form-control-static"><?php echo date("D, F j Y, g:i a", strtotime($place->created_on)); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Last Update</label>
        <div class="col-sm-10">
            <p class="form-control-static" id="last_update"><?php echo $place->last_update != NULL ? date("D, F j Y, g:i a", strtotime($place->last_update)) : ''; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-md-2 control-label">Status</label>
        <div class="col-md-3">
            <?php echo form_dropdown('status', $status, $place->status_places, 'class="form-control" id="status"'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <label for="inputPassword3" class="col-md-2 control-label">Title</label>
        <div class="col-md-5">
            <?php echo form_input($title); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" id="save_places">SAVE</button>
        </div>
    </div> 
</form> 