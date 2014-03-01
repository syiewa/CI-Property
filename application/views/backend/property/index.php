<div class="row">
    <div class="col-sm-9 col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-home">
                    </span>All</a></li>
            <li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span>
                    New</a></li>
            <li><a href="#search" data-toggle="tab"><span class="glyphicon glyphicon-search"></span>
                    Search</a></li>
            <li><a href="#settings" data-toggle="tab"><span class="glyphicon glyphicon-plus no-margin">
                    </span></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <div class="table-responsive" id="result_table">
                </div>
                <div id="pagination">
                </div>
            </div>
            <div class="tab-pane fade in" id="profile">
                <div class="list-group">
                    <div class="list-group-item">
                        <form class="form-horizontal" role="form" id="form_new_place">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-md-2 control-label">Status</label>
                                <div class="col-md-3">
                                    <?php echo form_dropdown('status', $status, 0, 'class="form-control" id="status"'); ?>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="title_form">
                                <label for="inputPassword3" class="col-md-2 control-label">Title</label>
                                <div class="col-md-5">
                                    <?php echo form_input($title); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-md-2 control-label">Type</label>
                                <div class="col-md-3">
                                    <?php echo form_dropdown('type', $type, 0, 'class="form-control" id="type"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default" id="save_places">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade in" id="search">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/search'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="settings">
                This tab is empty.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function load_result(index) {
        index = index || 0;
        $.post("<?php echo site_url('admin/places/get_ajax'); ?>/" + index, function(response) {
            $("#result_table").html(response);
        }, 'text');
    }
    $(function() {
        $('a[href="#home"]').on('shown.bs.tab', function(e) {
            load_result();
        });
        //calling the function 
        load_result();
        $(document.body).on("click", "td a.del-in", function(e) {
            e.preventDefault();
            var clickedID = this.id.split("-"); //Split string (Split works as PHP explode)
            var DbNumberID = clickedID[1]; //and get number from array
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    $.post("<?php echo site_url('admin/places/del_places'); ?>/" + DbNumberID, function(data) {
                        load_result();
                    });
                }
            });
        });
        $(document.body).on('click', '.pagination a', function(e) {
            e.preventDefault();
            //grab the last paramter from url
            var link = $(this).attr("href").split(/\//g).pop();
            load_result(link);
        });
        $('#form_new_place').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                title: {
                    required: "<span class='glyphicon glyphicon-remove form-control-feedback'></span>Title required!",
                    minlength: jQuery.format("<span class='glyphicon glyphicon-remove form-control-feedback'></span>At least {0} characters required!")
                }
            },
            submitHandler: function(form) {
                var form_data = {
                    status: $('#status').val(),
                    title: $('#title').val(),
                    type: $('#type').val()
                };
                $.ajax({
                    url: "<?php echo site_url('admin/places/save'); ?>",
                    type: "post",
                    data: form_data,
                    dataType: "json",
                    success: function(msg)
                    {
                        if (msg.validate)
                        {
                            window.location.href = "<?php echo site_url('admin/places/edit'); ?>/" + msg.id_places;
                            $.notify("Places Saved", {position: "top center", className: "success"});
                        }
                        else {
                            console.log(msg.error);
                        }
                    }
                });
            }
        });
    });
</script>