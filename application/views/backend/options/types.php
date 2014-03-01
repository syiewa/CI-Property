<form id="form-general" class="form-horizontal">
    <?php echo form_input($id_type); ?>
    <div class="form-group">
        <label for="exampleInputPassword2" class="col-md-2 control-label">Input Title </label>
        <div class="col-md-6">
            <?php echo form_input($title_type); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-default" id="add_type">Add</button>
            <div class="hidden" id="update_type_btn">
                <button type="submit" class="btn btn-default" id="update_type">Update</button>
                <button type="button" class="btn btn-default" id="cancel_type">Cancel</button>
            </div>
        </div>
    </div>
</form>
<table id="responds" class="table" style="font-size: 12px">
    <tr>
        <th>Title</th>
        <th></th>
    </tr>
    <?php if ($types): ?>
        <?php foreach ($types as $t): ?>
            <tr id="item-<?php echo $t->id_type; ?>">
                <td class="col-md-9" id="type-<?php echo $t->id_type; ?>"><?php echo $t->title_type; ?></td>
                <td class="col-md-3"><a href="" class="edit" id="edit-<?php echo $t->id_type; ?>"><span class="glyphicon glyphicon-edit"></span></a> <a id="del-<?php echo $t->id_type; ?>" href="" class="del text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
            <?php
        endforeach;
    else:
        ?>
        No data
    <?php endif; ?>
</table>
<script>
    $(document).ready(function() {
        $('button#cancel_type').click(function() {
            $("#id_type").val('');
            $("#title_type").val('');
            $('button#add_type').removeClass('hidden').addClass('show');
            $('#update_type_btn').removeClass('show').addClass('hidden');
        });
        //##### Add record when Add Record Button is clicked #########
        $("#add_type").click(function(e) {

            e.preventDefault();

            if ($("#title_type").val() === "") //simple validation
            {
                bootbox.alert("Input Type cannot be empty!", function() {
                });
            } else {

                var myData = {
                    title_type: $('#title_type').val(),
                    id_type: $('#id_type').val()
                };

                jQuery.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "./index.php/admin/options/action_type", //Where to make Ajax calls
                    dataType: "text", // Data type, HTML, json etc.
                    data: myData, //post variables
                    success: function(response) {
                        $("#responds").append(response);
                        $("#title_type").val(''); //empty text field after successful submission
                        $.notify("Type Saved", {position: "top center", className: "success"});
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.notify(thrownError, {position: "top center", className: "error"});
                    }
                });
            }
        });

        //##### Delete record when delete Button is clicked #########
        $("body").on("click", "#responds a.del", function(e) {

            var clickedID = this.id.split("-"); //Split string (Split works as PHP explode)
            var DbNumberID = clickedID[1]; //and get number from array
            var myData = 'id_type=' + DbNumberID; //build a post data structure
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    jQuery.ajax({
                        type: "POST", // HTTP method POST or GET
                        url: "./index.php/admin/options/action_type", //Where to make Ajax calls
                        dataType: "text", // Data type, HTML, json etc.
                        data: myData, //post variables
                        success: function(response) {
                            //on success, hide element user wants to delete.
                            $('#item-' + DbNumberID).fadeOut("slow");
                            $.notify("Type Deleted", {position: "top center", className: "success"});
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            //On error, we alert user
                            $.notify(thrownError, {position: "top center", className: "error"});
                        }
                    });
                }
            });
            e.preventDefault();
        });

        $("body").on("click", "#responds a.edit", function(e) {
            e.preventDefault();
            var clickedID = this.id.split("-"); //Split string (Split works as PHP explode)
            var DbNumberID = clickedID[1];
            $("#id_type").val(DbNumberID);
            $("#title_type").val($("#responds #type-" + DbNumberID).text());
            $('button#add_type').removeClass('show').addClass('hidden');
            $('#update_type_btn').removeClass('hidden').addClass('show');
        });

        $('a[href="#type"]').on('shown.bs.tab', function(e) {
            $("#id_type").val('');
            $("#title_type").val('');
            $('button#add_type').removeClass('hidden').addClass('show');
            $('#update_type_btn').removeClass('show').addClass('hidden');
        });
        $("#update_type").click(function() {
            if ($("#title_type").val() === "") //simple validation
            {
                alert("Please enter some text!");
                return false;
            } else {
                var myData = {
                    title_type: $('#title_type').val(),
                    id_type: $('#id_type').val()
                };

                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "./index.php/admin/options/action_type", //Where to make Ajax calls
                    dataType: "json", // Data type, HTML, json etc.
                    data: myData, //post variables
                    success: function(response) {
                        $("#id_type").val('');
                        $("#title_type").val('');
                        $('button#add_type').removeClass('hidden').addClass('show');
                        $('#update_type_btn').removeClass('show').addClass('hidden');
                        $('#responds #type-' + response.id_type).html(response.title_type);
                        $.notify("Type Updated", {position: "top center", className: "success"});

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
