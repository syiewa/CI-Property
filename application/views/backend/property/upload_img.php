<script>
    var id_places = $('#id_places').val();
    var form_data = {
        id_place: $('#id_places').val()
    };
    function myfunc()
    {
        var tinythumb = '<?php echo base_url('assets/img'); ?>';
        var path = '<?php echo base_url(); ?>';
        $.ajax({cache: false,
            url: "<?php echo site_url('admin/places/get_img'); ?>",
            type: "POST",
            data: {'id_places': id_places}
        }).done(function(data) {
            $("#galery").html(data);
        });
    }
    function to_active(url, id, str) {
        if (str == 0) {
            var url = "<?php echo site_url(); ?>/" + url + '/' + id + '/' + '1';
        } else {
            var url = "<?php echo site_url(); ?>/" + url + '/' + id + '/' + '0';
        }
        $('#activate' + id).click(function(e) {
            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                dataType: "json",
            }).done(function(data) {
                if (data.respond) {
                    $('#galery').empty();
                    myfunc();
                }
            });
            return false;
        });
    }
    function del_img(id) {
        $('#delete_img' + id).click(function(e) {
            $.ajax({
                url: "<?php echo site_url('admin/places/del_img'); ?>" + '/' + id,
                type: "POST",
                data: form_data,
                dataType: 'json',
            }).done(function(data) {
                if (data.respond) {
                    $('#galery').empty();
                    myfunc();
                    if ($('#alert').children().length > 0) {
                        $('#alert').empty();
                        // do something
                    }
                    $('#alert').append(
                            '<div class="alert alert-success fade in">' +
                            '<button type="button" class="close" data-dismiss="alert">' +
                            '&times;</button>Updated</div>');
                    if ($('#last_update').text().trim().length > 0) {
                        $('#last_update').contents().filter(function() {
                            return this.nodeType == 3; //Node.TEXT_NODE
                        }).remove();
                    }
                    $('#last_update').append(data.last_update);
                } else {
                    if ($('#alert').children().length > 0) {
                        $('#alert').empty();
                        // do something
                    }
                    $('#alert').append(
                            '<div class="alert alert-danger fade in">' +
                            '<button type="button" class="close" data-dismiss="alert">' +
                            '&times;</button>Error</div>');
                }
            });
            return false;
        });
    }
    ;</script>
<div class="row">
    <div id="galery">
    </div>
</div>
<hr>
<form action="index.php/admin/places/upload" method="post" enctype="multipart/form-data">
    <?php echo form_input($id); ?>
    <input type="file" name="userfile" class="fileUpload" multiple>

    <button id="px-submit" type="submit">Upload</button>
    <button id="px-clear" type="reset">Clear</button>
</form>

<script type="text/javascript">
    jQuery(function($) {
        $('a[href="#photos"]').on('shown.bs.tab', function(e) {
            myfunc();
        });
        $('.fileUpload').fileUploader({
            allowedExtension: 'jpg|jpeg|gif|png|zip|avi',
            afterEachUpload: function(data, status, formContainer) {
                $jsonData = $.parseJSON($(data).find('#upload_data').text());
                if ($('#last_update').text().trim().length > 0) {
                    $('#last_update').contents().filter(function() {
                        return this.nodeType == 3; //Node.TEXT_NODE
                    }).remove();
                }
                $('#last_update').append($jsonData.last_update);
                var id_places = $('#id_places').val();
                $.ajax({
                    url: "<?php echo site_url('admin/places/upload'); ?>",
                    type: "post",
                    data: {'id_places': id_places},
                    dataType: "json",
                    success: function(data) {
                    }
                });
                $('#galery').empty();
                myfunc();
            }
        });
    });
</script>