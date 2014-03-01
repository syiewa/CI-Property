<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title><?php echo $meta_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <base href="<?php echo substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
        <link href="<?php echo base_url('assets/css/ui-lightness/jquery-ui-1.8.14.custom.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/fileUploader.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Optional theme -->
        <!--        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">-->
        <!-- Latest compiled and minified JavaScript -->
        <script src="<?php echo base_url('assets/js/jquery-1.10.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui-1.8.14.custom.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.fileUploader.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.blockUI.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/bootbox.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/notify.min.js'); ?>" type="text/javascript"></script>
        <script>
            $(document).ajaxStart(function() {
                $.blockUI();
            });
            $(document).ajaxStop($.unblockUI);
            $.validator.setDefaults({
                errorPlacement: function(error, element) {
                    $(element).notify($(error).text(), {elementPosition: "top center", globalPosition: 'top center', autoHideDelay: 2000, className: "error"});
                },
                //place all errors in a <div id="errors"> element
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                },
            });
        </script>
    </head>

    <body>
        <div class="container">
            <!-- Sidebar  -->
            <div class="container">
                <div class="row">
                    <?php if ($this->ion_auth->logged_in()) : ?>
                        <div class="col-sm-3 col-md-3">
                            <span class="btn btn-danger btn-sm btn-block" role="button">Dashboard</span>
                            <hr />
                            <ul class="nav nav-pills nav-stacked">
                                <?php
                                if ($this->ion_auth->is_admin()) {
                                    $menu = array(
                                        array('name' => 'Places', 'url' => site_url('admin/places'), 'slug' => 'places', 'glip' => 'home'),
                                        array('name' => 'Users', 'url' => site_url('admin/users'), 'slug' => 'users', 'glip' => 'user'),
                                        array('name' => 'Options', 'url' => site_url('admin/options'), 'slug' => 'options', 'glip' => 'cog'),
                                    );
                                } else {
                                    $menu = array(
                                        array('name' => 'Places', 'url' => site_url('admin/places'), 'slug' => 'places', 'glip' => 'home'),
                                    );
                                }
                                foreach ($menu as $m):
                                    $active = $this->uri->segment(2) == $m['slug'] ? TRUE : FALSE;
                                    echo $active ? '<li class=active>' : '<li>';
                                    ?>
                                    <a href="<?php echo $m['url']; ?>"><span class="glyphicon glyphicon-<?php echo $m['glip']; ?>"> <?php echo $m['name']; ?></span></a>
                                    </li>
                                <?php endforeach; ?>
                                <li>
                                    <a href="<?php echo site_url('front/places'); ?>"><span class="glyphicon glyphicon-list-alt"> Preview</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('login/logout'); ?>"><span class="glyphicon glyphicon-log-out"> Logout</span></a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Sidebar -->
                        <div class="col-md-9">
                            <?php if (!empty($content)): ?>
                                <?php $this->load->view($content); ?>
                            <?php else: ?>
                                <?php echo 'Halaman tidak ada'; ?>
                            <?php endif; ?>
                            <!-- Ad -->
                            <div class="row-md-12">
                                <div class="ad">
                                    <a href="http://www.arnosa.net" class="title">ArnosaDotNet</a>
                                    <div>
                                        Games , Programming , Curhat , Aku Ra popo</div>
                                    <a href="http://www.arnosa.net" class="url">www.arnosa.net</a>
                                </div>
                            </div>
                            <br />
                        </div>
                    <?php else: ?>
                        <div class="col-md-5 col-md-offset-3">
                            <?php if (!empty($content)): ?>
                                <?php $this->load->view($content); ?>
                            <?php else: ?>
                                <?php echo 'Halaman tidak ada'; ?>
                            <?php endif; ?>
                            <!-- Ad -->
                            <div class="row-md-12">
                                <div class="ad">
                                    <a href="http://www.arnosa.net" class="title">ArnosaDotNet</a>
                                    <div>
                                        Games , Programming , Curhat , Aku Ra popo</div>
                                    <a href="http://www.arnosa.net" class="url">www.arnosa.net</a>
                                </div>
                            </div>
                            <br />
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
