<form class="form-horizontal" role="form" id="search"> 
    <div class="form-group">
        <label for="inputtitle" class="col-lg-2 control-label">Title</label>
        <div class="col-lg-7">
            <?php echo form_input($title_s); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputtype" class="col-lg-2 control-label">Type</label>
        <div class="col-lg-7">
            <?php echo form_dropdown('type', $type, '', 'class="form-control" id="type"'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputtown" class="col-lg-2 control-label">City</label>
        <div class="col-lg-7">
            <?php echo form_input($city); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-lg-2 control-label">Bedrooms</label>
        <div class="col-lg-3">
            <?php echo form_input($minbed); ?>
        </div>
        <div class="col-lg-1">
            <p class="text-center">-</p>
        </div>
        <div class="col-lg-3">
            <?php echo form_input($maxbed); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-lg-2 control-label">Bathrooms</label>
        <div class="col-lg-3">
            <?php echo form_input($minbath); ?>
        </div>
        <div class="col-lg-1">
            <p class="text-center">-</p>
        </div>
        <div class="col-lg-3">
            <?php echo form_input($maxbath); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-lg-2 control-label">Prices</label>
        <div class="col-lg-3">
            <?php echo form_input($minprice); ?>
        </div>
        <div class="col-lg-1">
            <p class="text-center">-</p>
        </div>
        <div class="col-lg-3">
            <?php echo form_input($maxprice); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-lg-2 control-label">Floor Area</label>
        <div class="col-lg-3">
            <?php echo form_input($minfloor); ?>
        </div>
        <div class="col-lg-1">
            <p class="text-center">-</p>
        </div>
        <div class="col-lg-3">
            <?php echo form_input($maxfloor); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" class="btn btn-default" name="search" value="Search">
        </div>
    </div> 
</form> 
<div id="result">

</div>
<script>
    $("#search").on("submit", function(e) {
        e.preventDefault();
        search();
    });
    function search(index) {
        index = index || 0;
        var option = $("form#search").serialize();
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "<?php echo site_url('admin/places/search'); ?>/" + index, //Where to make Ajax calls
            dataType: "text", // Data type, HTML, json etc.
            data: option, //post variables
            success: function(response) {
                $("#result").html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError); //throw any errors
            }
        });
    }
    $(function() {
        function del(id) {
            var url = "<?php echo site_url('admin/places/del_places'); ?>/" + id;
            $.ajax({
                url: url,
                type: "POST",
            }).done(function(e) {
                 search();
            });
        }
        $(document.body).on('click', '.pagination a', function(e) {
            e.preventDefault();
            //grab the last paramter from url
            var link = $(this).attr("href").split(/\//g).pop();
            search(link);
        });
        $(document.body).on("click", "td a.del", function(e) {
            e.preventDefault();
            var clickedID = this.id.split("-"); //Split string (Split works as PHP explode)
            var DbNumberID = clickedID[1]; //and get number from array
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    del(DbNumberID);
                }
            });
        });
    });
</script>