<div class="col-sm-12 col-md-12">
    <a href='<?php echo site_url(); ?>' class='btn btn-primary'>Home</a>
    <h1><?php echo $summary->title_places . ' / ' . $status[$detail->status]; ?></h1>
    <hr />
    <div class="row">
        <div class="col-md-7">
            <span class="btn btn-primary btn-block disabled" role="button"><h4>Summary</h4></span>
            <hr />
            <div class="panel panel-default">
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt><p class="pull-left">Price</p></dt>
                        <dd><p class="pull-right"><?php echo $currency[getOptions('currency')] . ' ' . currency($detail->prices); ?></p></dd>
                        <dt><p class="pull-left">Type</p></dt>
                        <dd><p class="pull-right"><?php echo $type[$detail->id_type]; ?></p></dd>
                        <dt><p class="pull-left">Bedrooms</p></dt>
                        <dd><p class="pull-right"><?php echo $detail->bedrooms; ?></p></dd>
                        <dt><p class="pull-left">Bathrooms</p></dt>
                        <dd><p class="pull-right"><?php echo $detail->bathrooms; ?></p></dd>
                        <dt><p class="pull-left">Year Built</p></dt>
                        <dd><p class="pull-right"><?php echo $detail->year_built; ?></p></dd>
                        <dt><p class="pull-left">Lot Dimension</p></dt>
                        <dd><p class="pull-right"><?php echo $detail->lot_dim . ' ' . $floor[getOptions('floor_metric')]; ?></p></dd>
                        <dt><p class="pull-left">Floor Dimension</p></dt>
                        <dd><p class="pull-right"><?php echo $detail->floor_dim . ' ' . $floor[getOptions('floor_metric')]; ?></p></dd>
                    </dl>
                </div>
            </div>
            <span class="btn btn-primary btn-block disabled" role="button"><h4>Description</h4></span>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        <?php echo $detail->desc; ?>
                    </p>
                </div>
            </div>
            <span class="btn btn-primary btn-block disabled" role="button"><h4>Property Features</h4></span>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">                   
                    <?php if ($feat_property):foreach ($feat_property as $fp): ?>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <i class="fa fa-check"></i><?php echo $fp->title_features; ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <p>No Present Features</p>
                    <?php endif; ?>
                </div>
            </div>
            <span class="btn btn-primary btn-block disabled" role="button"><h4>Community Features</h4></span>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if ($feat_com):foreach ($feat_com as $fc): ?>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <i class="fa fa-check"></i><?php echo $fc->title_features; ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <p>No Present Features</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if ($image):foreach ($image as $img): ?>
                            <div class="col-lg-6 col-sm-4 col-xs-6">
                                <a class="fancybox-thumbs" data-fancybox-group="thumb" href="<?php echo base_url($img->image); ?>">
                                    <img class="thumbnail img-responsive" src="<?php echo base_url('assets/img/timthumb.php'); ?>?src=<?php echo base_url($img->image); ?>&zc=0&h=140&w=180">
                                </a>
                            </div>
                            <?php
                        endforeach;
                    else:
                        ?>
                        Photo's is not provided
                    <?php endif; ?>
                </div>
            </div>
            <span class="btn btn-primary btn-block disabled" role="button"><h4>Maps</h4></span>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="map">
                        <?php if (isset($map)): ?>
                            <?php echo $map['js']; ?>
                            <?php echo $map['html']; ?>
                        <?php else: ?>
                            Location is not provided
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <span class="btn btn-primary btn-block disabled" role="button"><h4>Property Address</h4></span>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if ($location): ?>
                        <dl>
                            <dt>Address</dt>
                            <dd><?php echo $location->address; ?></dd>
                            <dt>Town</dt>
                            <dd><?php echo $location->town; ?></dd>
                            <dt>Province</dt>
                            <dd><?php echo $location->province; ?></dd>
                            <dt>Country</dt>
                            <dd><?php echo $location->country; ?></dd>
                        </dl>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <span class="btn btn-primary btn-block disabled" role="button"><h4>Contact Details</h4></span>
        <hr>
        <div class="col-md-8">
            <div class="well well-sm">
                <form id='form-message'>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                    </span>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Message</label>
                                <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                          placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                                Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <legend><span class="glyphicon glyphicon-globe"></span> Owner Address</legend>
            <?php if ($owner): ?>
                <address>
                    <strong><?php echo $owner->name_owner; ?></strong><br>
                    <i class="fa fa-map-marker"></i> <?php echo $owner->adds_owner; ?><br />
                    <abbr title="Phone">
                        <i class="fa fa-phone"></i></abbr>
                    <?php echo $owner->telp_owner; ?><br/>
                    <abbr title="Phone">
                        <i class="fa fa-mobile-phone"></i></abbr>
                        <?php echo $owner->mob_owner; ?>
                </address>
                <address>
                    <strong><?php echo $owner->name_owner; ?></strong><br>
                    <a href="mailto:<?php echo $owner->email_owner; ?>"><?php echo $owner->email_owner; ?></a>
                </address>
            <?php else: ?>
                <p> No Preset Data</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<br />
<script>
    $(document).ready(function() {
        $('.fancybox-thumbs').fancybox({
            prevEffect: 'none',
            nextEffect: 'none',
            closeBtn: false,
            arrows: false,
            nextClick: true,
            helpers: {
                thumbs: {
                    width: 50,
                    height: 50
                }
            }
        });
        $('#form-message').submit(function(e) {
            e.preventDefault();
            $('#form-message input[type="text"]').val('');
            $('#form-message input[type="email"]').val('');
            $('#form-message textarea').val('');
            $.notify("Message send", {position: "top center", className: "success"});
        });
    });
</script>