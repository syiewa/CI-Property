<div class="col-sm-4 col-md-4">
    <span class="btn btn-danger btn-sm btn-block" role="button">Search</span>
    <hr />
    <?php $this->load->view('frontend/search'); ?>
</div>
<div class="col-md-8">
    <hgroup class="mb20">
        <h1>Property</h1>
    </hgroup>
    <div id="result">
    </div>
</div>
<script>
    function search(index) {
        index = index || 0;
        var option = $("form#search").serialize();
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "<?php echo site_url('front/places/search'); ?>/" + index, //Where to make Ajax calls
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
        search();
        $("#search").on("submit", function(e) {
            e.preventDefault();
            search();
        });
        $(document.body).on('click', '.pagination a', function(e) {
            e.preventDefault();
            //grab the last paramter from url
            var link = $(this).attr("href").split(/\//g).pop();
            search(link);
        });
    })
</script>