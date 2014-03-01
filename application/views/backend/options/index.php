<div class="row">
    <div class="col-sm-9 col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                    </span> General</a></li>
            <li><a href="#type" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
                    Type</a></li>
            <li><a href="#features" data-toggle="tab"><span class="glyphicon glyphicon-tags"></span>
                    Features</a></li>
            <li><a href="#settings" data-toggle="tab"><span class="glyphicon glyphicon-plus no-margin">
                    </span></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <div class="list-group">
                    <div class="list-group-item">
                        <form id="form-general" class="form-horizontal">
                            <div class="form-group">
                                <label for="inputPassword3" class="col-md-3 control-label">Currency</label>
                                <div class="col-md-2">
                                    <?php echo form_dropdown('options[]', $curr, $options[0]->value, 'class="form-control"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-md-3 control-label">Floor Metric</label>
                                <div class="col-md-3">
                                    <?php echo form_dropdown('options[]', $floor_metric, $options[1]->value, 'class="form-control"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-md-3 control-label">Record per table</label>
                                <div class="col-md-5">
                                    <?php echo form_input($paging); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-md-3 control-label">Show Contact Form</label>
                                <div class="col-md-3">
                                    <?php echo form_dropdown('options[]', $contact_form, $options[3]->value, 'class="form-control"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-2">
                                    <?php echo form_submit('submit', 'Save', 'class="btn btn-primary form-control" id="gen-sub"'); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="type">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/options/types'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="features">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/options/features'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="settings">
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#form-general").on("submit", function(event) {
            event.preventDefault();
            var data = $(this).serializeArray();
            $.ajax({
                url: "<?php echo site_url('admin/options/action_general'); ?>",
                type: "post",
                data: data,
                dataType: "json",
                success: function(msg)
                {
                    if (msg.validate) {
                        $.notify("Options Saved", {position: "top center", className: "success"});
                    } else {
                        $.notify("Error occured", {position: "top center", className: "error"});
                    }
                }
            });
        });
    });
</script>