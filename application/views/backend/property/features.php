<form class="form-horizontal" role="form" id="form_fp">
    <?php echo form_input($id); ?>
    <h3>Property Features</h3>
    <div class="form-group">
        <div class="col-md-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox"  name="check_all_prop" value=""> Check / Uncheck All
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php
        foreach ($feat_property as $fp):?>
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="prop_feat" name="features[]" value="<?php echo $fp->id_features; ?>" <?php echo (!empty($fp->checked) ? $fp->checked :''); ?> > <?php echo $fp->title_features; ?>
                    </label>
                </div>
            </div>
<?php endforeach; ?>
    </div>
    <h3>Community Features</h3>
    <div class="form-group">
        <div class="col-md-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox"  name="check_all_com" value=""> Check / Uncheck All
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
<?php foreach ($feat_com as $fc): ?>
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="com_feat" name="features[]" value="<?php echo $fc->id_features; ?>" <?php echo (!empty($fc->checked) ? $fc->checked :''); ?>> <?php echo $fc->title_features; ?>
                    </label>
                </div>
            </div>
<?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-default">Save</button>
</form>
<script>
    $(document).on('change', 'input[name="check_all_prop"]', function() {
        $('.prop_feat').prop("checked", this.checked);
    });
    $(document).on('change', 'input[name="check_all_com"]', function() {
        $('.com_feat').prop("checked", this.checked);
    });
    $(document).ready(function() {
        $('#form_fp').submit(function(e) {
            e.preventDefault();
            var data = $(this).serializeArray();
            var url = "<?php echo site_url('admin/places/save_feat'); ?>";
            notif(url,data);
            
        });
    });
</script>