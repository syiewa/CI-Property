<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" id="search"> 
            <div class="form-group">
                <label for="inputtitle" class="col-md-3 control-label">Title</label>
                <div class="col-md-8">
                    <?php echo form_input($title_s); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputtype" class="col-md-3 control-label">Type</label>
                <div class="col-md-8">
                    <?php echo form_dropdown('type', $type, '', 'class="form-control" id="type"'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputtown" class="col-md-3 control-label">City</label>
                <div class="col-md-8">
                    <?php echo form_input($city); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Bedrooms</label>
                <div class="col-md-3">
                    <?php echo form_input($minbed); ?>
                </div>
                <div class="col-md-2">
                    <p class="text-center">-</p>
                </div>
                <div class="col-md-3">
                    <?php echo form_input($maxbed); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Bathrooms</label>
                <div class="col-md-3">
                    <?php echo form_input($minbath); ?>
                </div>
                <div class="col-md-2">
                    <p class="text-center">-</p>
                </div>
                <div class="col-md-3">
                    <?php echo form_input($maxbath); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Prices</label>
                <div class="col-md-3">
                    <?php echo form_input($minprice); ?>
                </div>
                <div class="col-md-2">
                    <p class="text-center">-</p>
                </div>
                <div class="col-md-3">
                    <?php echo form_input($maxprice); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Floor Area</label>
                <div class="col-md-3">
                    <?php echo form_input($minfloor); ?>
                </div>
                <div class="col-md-2">
                    <p class="text-center">-</p>
                </div>
                <div class="col-md-3">
                    <?php echo form_input($maxfloor); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                    <input type="submit" class="btn btn-primary" name="search" value="Search">
                </div>
            </div> 
        </form> 
    </div>
</div>
