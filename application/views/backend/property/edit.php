<script type="text/javascript">
    var id = '<?php echo $this->uri->segment(4); ?>';
    function updateDatabase(newLat, newLng)
    {
        // make an ajax request to a PHP file
        // on our site that will update the database
        // pass in our lat/lng as parameters
        $.ajax({
            url: "<?php echo site_url('admin/places/edit'); ?>" + '/' + id,
            type: "post",
            data: {'newLat': newLat, 'newLng': newLng},
            dataType: "json",
            success: function(data)
            {
                $('#coord').val(data.lat + ',' + data.lng);
                codeLatLng(data.lat + ',' + data.lng);
            }
        });
    }
    function notif(url, data) {
        $.ajax({
            url: url,
            type: "post",
            data: data,
            dataType: "json",
            success: function(msg)
            {
                if (msg.validate) {
                    $.notify("Places Updated", {position: "top center", className: "success"});
                    if ($('#last_update').text().trim().length > 0) {
                        $('#last_update').contents().filter(function() {
                            return this.nodeType === 3; //Node.TEXT_NODE
                        }).remove();
                    }
                    $('#last_update').append(msg.last_update);
                } else {
                    $.notify("Error Occured", {position: "top center", className: "error"});
                }
            }
        });
    }
</script>
<div class="row">
    <div class="col-sm-9 col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#summary" data-toggle="tab"><span class="glyphicon glyphicon-home"></span>
                    Summary</a></li>
            <li><a href="#details" data-toggle="tab"><span class="glyphicon glyphicon-edit"></span>
                    Details</a></li>
            <li><a href="#address" data-toggle="tab"><span class="glyphicon glyphicon-map-marker"></span>
                    Address</a></li>
            <li><a href="#photos" data-toggle="tab"><span class="glyphicon glyphicon-picture"></span>
                    Photos</a></li>
            <li><a href="#features" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span>
                    Features</a></li>
            <li><a href="#owner" data-toggle="tab"><span class="glyphicon glyphicon-envelope">
                        Owner</span></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="summary">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/summary'); ?>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade in" id="details">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/details'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="address">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/map'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="photos">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/upload_img'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="features">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/features'); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="owner">
                <div class="list-group">
                    <div class="list-group-item">
                        <?php $this->load->view('backend/property/owner'); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var geocoder = new google.maps.Geocoder();
    function codeAddress(address) {
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                $('#coord').val(results[0].geometry.location.d + ',' + results[0].geometry.location.e);
                map.setCenter(results[0].geometry.location);
                marker = createMarker_map({map: map, position: results[0].geometry.location});
                iw_map.setContent(results[0].formatted_address);
                iw_map.open(map, marker);
            }
//            else {
//                alert('Geocode was not successful for the following reason: ' + status);
//            }
        });
    }
    function codeLatLng(coord) {
        var input = coord;
        var latlngStr = input.split(',', 2);
        var lat = parseFloat(latlngStr[0]);
        var lng = parseFloat(latlngStr[1]);
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({'latLng': latlng}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    for (var x in results[0].address_components)
                    {
                        if (results[0].address_components[x]['types'][0] === 'country')
                            $('#country').val(results[0].address_components[x]['long_name']);
                        if (results[0].address_components[x]['types'][0] === 'administrative_area_level_1')
                            $('#province').val(results[0].address_components[x]['long_name']);
                        if (results[0].address_components[x]['types'][0] === 'administrative_area_level_2')
                            $('#town').val(results[0].address_components[x]['long_name']);
                    }
                    marker = createMarker_map({map: map, position: latlng});
                    iw_map.setContent(results[0].formatted_address);
                    iw_map.open(map, marker);
                } else {
                    alert('No results found');
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });
    }
    function setAllMap(map) {
        for (var i = 0; i < markers_map.length; i++) {
            markers_map[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setAllMap(null);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers_map = [];
    }
    $(function() {
        $('a[href="#address"]').on('shown.bs.tab', function(e) {
            initialize_map();
            deleteMarkers();
            codeAddress($('#coord').val());
        });
//        $("#form_detail").submit(function(event) {
//            data = $(this).serialize();
//            notif("<?php echo site_url('admin/places/save_detail'); ?>", data);
//            return false;
//        });
        $('#form_detail').validate({
            rules: {
                prices: {
                    required: true,
                    min: 1,
                    number: true,
                },
                year_built: {
                    required: true,
                    min: 1,
                    number: true,
                },
                lot_dim: {
                    required: true,
                    min: 1,
                    number: true,
                },
                floor_dim: {
                    required: true,
                    min: 1,
                    number: true,
                },
                bedrooms: {
                    required: true,
                    number: true,
                },
                bathrooms: {
                    required: true,
                    number: true,
                },
            },
            messages: {
                prices: {
                    required: "Price Required!",
                    min: jQuery.format("Should be bigger than {0}!"),
                    number: "Must be Number!",
                },
                year_built: {
                    required: "Year Built Required!",
                    min: jQuery.format("Should be bigger than {0}!"),
                    number: "Must be Number!",
                },
                lot_dim: {
                    required: "Lot Dimension Required!",
                    min: jQuery.format("Should be bigger than {0}!"),
                    number: "Must be Number!",
                },
                floor_dim: {
                    required: "Floor Dimension Required!",
                    min: jQuery.format("Should be bigger than {0}!"),
                    number: "Must be Number!",
                },
                bedrooms: {
                    required: "Bedrooms Required!",
                    min: jQuery.format("Should be bigger than {0}!"),
                    number: "Must be Number!",
                },
                bathrooms: {
                    required: "Bathrooms Required!",
                    min: jQuery.format("Should be bigger than {0}!"),
                    number: "Must be Number!",
                },
            },
            submitHandler: function(form) {
                var data = $(form).serialize();
                notif("<?php echo site_url('admin/places/save_detail'); ?>", data);
            }
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
                    required: "Title required!",
                    minlength: jQuery.format("At least {0} characters required!")
                }
            },
            submitHandler: function(form) {
                var form_data = {
                    status: $('#status').val(),
                    title: $('#title').val(),
                    id_place: $('#id_places').val()
                };
                notif("<?php echo site_url('admin/places/update'); ?>", form_data);
            }
        });
        $('#form_owner').validate({
            rules: {
                name_owner: {
                    required: true,
                    minlength: 4
                },
                email_owner: {
                    required: true,
                    minlength: 4,
                    email: true
                },
                adds_owner: {
                    required: true,
                    minlength: 4
                },
                telp_owner: {
                    required: true,
                    minlength: 4,
                    digits: true
                },
                mob_owner: {
                    required: true,
                    minlength: 4,
                    digits: true
                },
            },
            messages: {
                name_owner: {
                    required: "Full Name required!",
                    minlength: jQuery.format("At least {0} characters required!")
                },
                email_owner: {
                    required: "Email required!",
                    minlength: jQuery.format("At least {0} characters required!"),
                    email: "Not Valid Email"
                },
                adds_owner: {
                    required: "Address required!",
                    minlength: jQuery.format("At least {0} characters required!")
                },
                telp_owner: {
                    required: "Telephone required!",
                    minlength: jQuery.format("At least {0} characters required!!"),
                    digits: "Only Number!"
                },
                mob_owner: {
                    required: "Mobile Phone required!",
                    minlength: jQuery.format("At least {0} characters required!"),
                    digits: "Only Number!"
                }
            },
            submitHandler: function(form) {
                var data = $(form).serialize();
                notif("<?php echo site_url('admin/places/save_owner'); ?>", data);
            }
        });
        $('#form_map').validate({
            rules: {
                address: {
                    required: true,
                    minlength: 4
                },
                town: {
                    required: true,
                    minlength: 4
                },
                province: {
                    required: true,
                    minlength: 4
                },
                country: {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                address: {
                    required: "Address required!</span>",
                    minlength: jQuery.format("At least {0} characters required!")
                },
                town: {
                    required: "Town required!</span>",
                    minlength: jQuery.format("At least {0} characters required!")
                },
                province: {
                    required: "Province required!</span>",
                    minlength: jQuery.format("At least {0} characters required!")
                },
                country: {
                    required: "Country required!</span>",
                    minlength: jQuery.format("At least {0} characters required!")
                }
            },
            submitHandler: function(form) {
                var data = $(form).serialize();
                notif("<?php echo site_url('admin/places/save_map'); ?>", data);
            }
        });
    });
</script>