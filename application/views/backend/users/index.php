<div class="row">
    <div class="col-sm-9 col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#users" data-toggle="tab"><span class="glyphicon glyphicon-user">
                    </span> All</a></li>
            <li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span>
                    New</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="users">
                <div class="table-responsive" id="result_table">
                    <div id="infoMessage"><?php echo $message; ?></div>
                </div>
                <div id="pagination">
                </div>
            </div>
            <div class="tab-pane fade in" id="profile">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/users/new'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="telo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Event</h4>
            </div>
            <div class="modal-body">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
</div><!-- /.modal-dialog -->
<script>
    $(function() {
        $('#telo').on('hidden.bs.modal', function() {
            $(this).removeData('bs.modal');
            $.get("<?php echo site_url('admin/users/get_alluser'); ?>", function(data) {
                $("#result_table").html(data);
            });
        });
        $('#telo').on('loaded.bs.modal', function() {
            $("#telo form").validate({
                rules: {
                    first_name: {
                        required: true,
                        minlength: 2
                    },
                    last_name: {
                        required: true,
                        minlength: 2
                    },
                    company: {
                        required: true,
                        minlength: 2
                    },
                    phone: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    password: {
                        minlength: 2
                    },
                    password_confirm: {
                        equalTo: "#password_e"
                    }
                },
                messages: {
                    first_name: {
                        required: "First Name Required!",
                        minlength: jQuery.format("At least {0} characters!"),
                    },
                    last_name: {
                        required: "Last Name Required!",
                        minlength: jQuery.format("At least {0} characters!"),
                    },
                    company: {
                        required: "Company Required!",
                        minlength: jQuery.format("Should be bigger than {0}!"),
                    },
                    phone: {
                        required: "Phone Required!",
                        min: jQuery.format("Should be bigger than {0}!"),
                        number: "Must be Number!",
                    },
                    password: {
                        minlength: jQuery.format("At least {0} characters!"),
                    },
                    password_confirm: {
                        equalTo: "Different with password",
                    }
                },
                submitHandler: function(form) {
                    var hmm = "<?php echo site_url('admin/users/edit'); ?>/" + $("#id").val();
                    var dah = $("#edit_user").serialize();
                    $.post(hmm, dah, function(msg) {
                        $.notify("Users Updated", {position: "top center", className: "success"});
                    }).done(function() {
                        $('#telo').modal('hide')
                    })
                    return false;
                }
            });
        });
        $.get("<?php echo site_url('admin/users/get_alluser'); ?>", function(data) {
            $("#result_table").html(data);
        });
        $('#result_table').on('click', 'a#inactive', function(e) {
            e.preventDefault();
            var url = $(this).attr("href");
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    $.post(url, function(data) {
                        $.get("<?php echo site_url('admin/users/get_alluser'); ?>", function(data) {
                            $("#result_table").html(data);
                        });
                    }).done(function() {
                        $.notify("Users Updated", {position: "top center", className: "success"});
                    });
                }
            });
        });
        $('#result_table').on('click', 'a#active', function(e) {
            e.preventDefault();
            var url = $(this).attr("href");
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    $.post(url, function(data) {
                        $.get("<?php echo site_url('admin/users/get_alluser'); ?>", function(data) {
                            $("#result_table").html(data);
                        });
                    }).done(function() {
                        $.notify("Users Updated", {position: "top center", className: "success"});
                    });
                }
            });
        });
    });
    $('a[href="#users"]').on('shown.bs.tab', function(e) {
        $.get("<?php echo site_url('admin/users/get_alluser'); ?>", function(data) {
            $("#result_table").html(data);
        });
    });
</script>