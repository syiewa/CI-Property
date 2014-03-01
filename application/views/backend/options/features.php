<form id="form-general" class="form-horizontal">
    <?php echo form_input($id_feature); ?>
    <div class="form-group">
        <label for="inputTitle" class="col-sm-2 control-label">Title</label>
        <div class="col-md-6">
            <?php echo form_input($title_feature); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputCat" class="col-sm-2 control-label">Category</label>
        <div class="col-md-6">
            <?php echo form_dropdown('type_features', $type_feat, '0', 'class="form-control" id="type_features"'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-default show" id="add_feat">Add</button>
            <div class="hidden" id="update_btn">
                <button type="submit" class="btn btn-default" id="update_feat">Update</button>
                <button type="button" class="btn btn-default" id="cancel_feat">Cancel</button>
            </div>
        </div>
    </div>
</form>
<table id="feat_res" class="table table-condensed" style="font-size: 12px">
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th></th>
    </tr>
    <?php if ($features): ?>
        <?php foreach ($features as $t): ?>
            <tr id="item-feat-<?php echo $t->id_features; ?>">
                <td class="col-md-5" id="feat-<?php echo $t->id_features; ?>"><?php echo $t->title_features; ?></td>
                <td class="col-md-4" id="cat-<?php echo $t->id_features; ?>"><?php echo$type_feat[$t->type_features]; ?></td>
                <td class="col-md-3"><a href="" class="edit-feat" id="edit-feat-<?php echo $t->id_features; ?>"><span class="glyphicon glyphicon-edit"></span></a> <a id="del-feat-<?php echo $t->id_features; ?>" href="" class="del-feat text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<script>
    $(document).ready(function() {
        $("#add_feat").click(function(e) {
            e.preventDefault();
            if ($("#title_feature").val() === "") //simple validation
            {
                bootbox.alert("Input Title Feature cannot be empty!", function() {
                });
            } else {

                var myData = {
                    title_features: $('#title_feature').val(),
                    id_features: $('#id_feature').val(),
                    type_features: $('#type_features').val(),
                };
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "./index.php/admin/options/action_feat", //Where to make Ajax calls
                    dataType: "text", // Data type, HTML, json etc.
                    data: myData, //post variables
                    success: function(response) {
                        $("#feat_res").append(response);
                        $("#title_feature").val(''); //empty text field after successful submission
                        $.notify("Feature Saved", {position: "top center", className: "success"});
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.notify(thrownError, {position: "top center", className: "error"});
                    }
                });
            }
        });
        $("table").on("click", "td a.del-feat", function(e) {
            e.preventDefault();
            var clickedID = this.id.split("-"); //Split string (Split works as PHP explode)
            var DbNumberID = clickedID[2]; //and get number from array
            var myData = 'id_features=' + DbNumberID; //build a post data structure
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    $.ajax({
                        type: "POST", // HTTP method POST or GET
                        url: "./index.php/admin/options/action_feat", //Where to make Ajax calls
                        dataType: "text", // Data type, HTML, json etc.
                        data: myData, //post variables
                        success: function(response) {
                            //on success, hide element user wants to delete.
                            $('#item-feat-' + DbNumberID).fadeOut("slow");
                            $.notify("Feature Deleted", {position: "top center", className: "success"});
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            //On error, we alert user
                            $.notify(thrownError, {position: "top center", className: "error"});
                        }
                    });
                }
            });
        });
//        $('a[href="#features"]').on('shown.bs.tab', function(e) {
//            $("#id_feature").val('');
//            $("#title_feature").val('');
////            $('button#update_type').removeAttr('id').attr('id', 'add_type').html('Add');
//        });
        $("table").on("click", "td a.edit-feat", function(e) {
            e.preventDefault();
            var clickedID = this.id.split("-"); //Split string (Split works as PHP explode)
            var DbNumberID = clickedID[2];
            $("#id_feature").val(DbNumberID);
            $("#title_feature").val($("#feat-" + DbNumberID).text());
            $("#type_features option:contains(" + $("#feat_res #cat-" + DbNumberID).text() + ")").attr('selected', 'selected');
            $('button#add_feat').removeClass('show').addClass('hidden');
            $('#update_btn').removeClass('hidden').addClass('show');
        });
        $('button#cancel_feat').click(function() {
            $("#id_feature").val('');
            $("#title_feature").val('');
            $('button#add_feat').removeClass('hidden').addClass('show');
            $('#update_btn').removeClass('show').addClass('hidden');
        });
        $("#update_feat").click(function() {
            if ($("#title_feature").val() === "") //simple validation
            {
                bootbox.alert("Input Title Feature cannot be empty!", function() {
                });
            } else {
                var myData = {
                    title_features: $('#title_feature').val(),
                    id_features: $('#id_feature').val(),
                    type_features: $('#type_features').val(),
                };
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "./index.php/admin/options/action_feat", //Where to make Ajax calls
                    dataType: "json", // Data type, HTML, json etc.
                    data: myData, //post variables
                    success: function(response) {
                        $("#id_feature").val('');
                        $("#title_feature").val('');
                        $('button#add_feat').removeClass('hidden').addClass('show');
                        $('#update_btn').removeClass('show').addClass('hidden');
                        $('#feat_res #feat-' + response.id_features).html(response.title_features);
                        $('#feat_res #cat-' + response.id_features).html(response.type_features);
                        $.notify("Feature Updated", {position: "top center", className: "success"});
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.notify(thrownError, {position: "top center", className: "error"});
                    }
                });
            }
            return false;
        });
    });
</script>