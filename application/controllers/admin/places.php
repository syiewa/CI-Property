<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kelas
 *
 * @author Syiewa
 */
class Places extends Admin_Controller {

//put your code here
    var $template = 'backend/template';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_options');
        $this->data['currency'] = $this->m_options->curr;
    }

    public function index() {
        $this->data['places'] = $this->m_places->get_place(5);
        $this->data['content'] = 'backend/property/index';
        //form 
        $this->data['status'] = $this->m_places->status_place;
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'class' => 'form-control',
        );
        $this->data['type'] = $this->m_places->get_type();
        // form searh 
        $this->data['title_s'] = array(
            'name' => 'title_s',
            'id' => 'title_s',
            'class' => 'form-control',
        );
        $this->data['city'] = array(
            'name' => 'city',
            'id' => 'city',
            'class' => 'form-control',
        );
        $this->data['minbed'] = array(
            'name' => 'minbed',
            'id' => 'minbed',
            'class' => 'form-control',
        );
        $this->data['maxbed'] = array(
            'name' => 'maxbed',
            'id' => 'maxbed',
            'class' => 'form-control',
        );
        $this->data['minbath'] = array(
            'name' => 'minbath',
            'id' => 'minbath',
            'class' => 'form-control',
        );
        $this->data['maxbath'] = array(
            'name' => 'maxbath',
            'id' => 'maxbath',
            'class' => 'form-control',
        );
        $this->data['minprice'] = array(
            'name' => 'minprice',
            'id' => 'minprice',
            'class' => 'form-control',
        );
        $this->data['maxprice'] = array(
            'name' => 'maxprice',
            'id' => 'maxprice',
            'class' => 'form-control',
        );
        $this->data['minfloor'] = array(
            'name' => 'minfloor',
            'id' => 'minfloor',
            'class' => 'form-control',
        );
        $this->data['maxfloor'] = array(
            'name' => 'maxfloor',
            'id' => 'maxfloor',
            'class' => 'form-control',
        );
        $this->load->view($this->template, $this->data);
    }

    public function search($offset = 0) {
        $options = $this->m_places->array_from_post(array('title_s', 'type', 'city', 'minbed', 'maxbed', 'minbath', 'maxbath', 'minprice', 'maxprice', 'minfloor', 'maxfloor'));
        if ($this->form_validation->run('search')) {
            $count = $this->m_places->search($options);
            $perpage = getOptions('paging');
            if (count($count) > $perpage) {
                $this->load->library('pagination');
                $config['base_url'] = site_url('admin/places/search');
                $config['total_rows'] = count($count);
                $config['per_page'] = $perpage;
                $config['uri_segment'] = 4;
                $q = $this->pagination->initialize($config);
                $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            } else {
                $this->data['pagination'] = '';
                $offset = 0;
            }
            $status = $this->m_places->status_place;
            $telo = $this->m_places->search($options, $perpage, $offset);
            $str = '';
            if ($telo) {
                $str .= '<table class="table table-bordered table-condensed"">
                        <thead>
                            <tr class="active">
                                <th class="text-center">Image</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
                foreach ($telo as $s) {
                    $str .= '<tr class="text-center">';
                    $str .= $s->image ? '<td class="col-md-1"><img src="'.base_url('assets/img/timthumb.php').'?src='. base_url($s->image) .'&zc=0&h=140&w=180"></td>' : '<td class="col-md-1"><img class="img-responsive" src="http://placehold.it/100x100&text=no+primary+image"></td>';
                    $str .= '<td>' . $s->title_places . '</td>';
                    $str .= '<td>' . ($s->title_type === null ? 'Not Set' : $s->title_type) . '</td>';
                    $str .= '<td>' . ($s->prices === null ? 'Not Set' : $this->data['currency'][getOptions('currency')] . ' ' . currency($s->prices)) . '</td>';
                    $str .= '<td><a href="' . site_url('admin/places/edit') . '/' . $s->id_places . '" class="btn btn-default">Edit</a>';
                    $str .= '<a id="del-' . $s->id_places . '" href="' . site_url('admin/places/del_places') . '/' . $s->id_places . '" class="btn btn-default del">Delete</a></td>';
                    $str .= '</tr>';
                }
                $str .= '<tbody></table>';
                $str .= '<div>' . $this->pagination->create_links() . '</div>';
            } else {
                $str .= 'No Data Found';
            }
            echo $str;
        }
    }

    public function get_ajax($offset = 0) {
        $count = $this->m_places->get_place();
        $perpage = getOptions('paging');
        if (count($count) > $perpage) {
            $this->load->library('pagination');
            $config['base_url'] = site_url('admin/places/get_ajax');
            $config['total_rows'] = count($count);
            $config['per_page'] = $perpage;
            $config['uri_segment'] = 4;
            $q = $this->pagination->initialize($config);
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        } else {
            $this->data['pagination'] = '';
            $offset = 0;
        }
        $telo = $this->m_places->get_place($perpage, $offset);
        $str = '';
        if ($telo) {
            $str .= '<table class="table table-bordered table-condensed"">
                        <thead>
                            <tr class="active">
                                <th class="text-center">Image</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($telo as $s) {
                $str .= '<tr class="text-center">';
                $str .= $s->image ? '<td class="col-md-1"><img src="'.base_url('assets/img/timthumb.php').'?src='. base_url($s->image) .'&zc=0&h=140&w=180"></td>' : '<td class="col-md-1"><img class="img-responsive" src="http://placehold.it/100x100&text=no+primary+image"></td>';
                $str .= '<td>' . $s->title_places . '</td>';
                $str .= '<td>' . ($s->title_type === null ? 'Not Set' : $s->title_type) . '</td>';
                $str .= '<td>' . ($s->prices === null ? 'Not Set' : $this->data['currency'][getOptions('currency')] . ' ' . currency($s->prices)) . '</td>';
                $str .= '<td><a href="' . site_url('admin/places/edit') . '/' . $s->id_places . '" class="btn btn-default">Edit</a>';
                $str .= '<a id="del-' . $s->id_places . '" href="' . site_url('admin/places/del_places') . '/' . $s->id_places . '" class="btn btn-default del-in">Delete</a></td>';
                $str .= '</tr>';
            }
            $str .= '<tbody></table>';
            $str .= '<div>' . $this->pagination->create_links() . '</div>';
        } else {
            $str .= 'No Data Found';
        }
        echo $str;
    }

    public function del_places($id) {
        $this->m_places->delete($id);
    }

    public function save() {
        $hasil = array(
            'validate' => FALSE
        );
        $data = array(
            'status_places' => $this->input->post('status'),
            'title_places' => strip_tags($this->input->post('title')),
            'created_on' => date('Y-m-d H:m:s')
        );
        if ($this->form_validation->run('places') == true) {
            $id_types = $this->input->post('type');
            $id_places = $this->m_places->insert($data);

            if ($id_places) {
                $detail = array('id_places' => $id_places, 'id_type' => $id_types);
                if ($this->m_places->insert_detail($detail)) {
                    $hasil = array('validate' => TRUE, 'id_places' => $id_places);
                }
            }
        }
        echo json_encode($hasil);
    }

    public function edit($id) {
        $id || show(404);
        $this->data['currency'] = $this->m_options->curr;
        $this->data['floor'] = $this->m_options->floor;
        $this->data['place'] = $this->m_places->get($id);
//form summary
        $this->data['id'] = array(
            'name' => 'id_places',
            'type' => 'hidden',
            'id' => 'id_places',
            'value' => $id
        );
        $this->data['status'] = $this->m_places->status_place;
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'data-validation' => "length",
            'data-validation-length' => "3-200",
            'class' => 'form-control',
            'value' => $this->data['place']->title_places
        );
        $this->data['detail'] = $this->m_places->get_detail(array('id_places' => $id));
//form detail
        $this->data['id_detail'] = array(
            'name' => 'id_detail',
            'type' => 'hidden',
            'id' => 'id_detail',
            'value' => $this->data['detail']->id_detail
        );
        $this->data['status_detail'] = $this->m_places->status_detail;
        $this->data['type'] = $this->m_places->get_type();
        $this->data['prices'] = array(
            'name' => 'prices',
            'class' => 'form-control',
            'id' => 'prices',
            'value' => $this->data['detail']->prices
        );
        $this->data['year_built'] = array(
            'name' => 'year_built',
            'class' => 'form-control',
            'id' => 'year_built',
            'value' => $this->data['detail']->year_built
        );
        $this->data['lot_dim'] = array(
            'name' => 'lot_dim',
            'class' => 'form-control',
            'id' => 'lot_dim',
            'value' => $this->data['detail']->lot_dim
        );
        $this->data['floor_dim'] = array(
            'name' => 'floor_dim',
            'class' => 'form-control',
            'id' => 'floor_dim',
            'value' => $this->data['detail']->floor_dim
        );
        $this->data['bedrooms'] = array(
            'name' => 'bedrooms',
            'class' => 'form-control',
            'id' => 'bedrooms',
            'value' => $this->data['detail']->bedrooms
        );
        $this->data['bathrooms'] = array(
            'name' => 'bathrooms',
            'class' => 'form-control',
            'id' => 'bathrooms',
            'value' => $this->data['detail']->bathrooms
        );
        $this->data['desc'] = array(
            'name' => 'desc',
            'class' => 'form-control',
            'id' => 'desc',
            'value' => $this->data['detail']->desc
        );
// maps
        $this->load->library('googlemaps');
        $map = $this->m_places->get_map(array('id_places' => $id));
        if ($map) {
            $config['center'] = $map->lat . ',' . $map->lng;
            $config['zoom'] = '15';
            $config['onload'] = "google.maps.event.trigger(marker_0, 'click');";
            $config['onclick'] = 'deleteMarkers();createMarker_map({ map: map, position:event.latLng });updateDatabase(event.latLng.lat(), event.latLng.lng());';
            $this->googlemaps->initialize($config);
            $marker = array();
            $marker['position'] = $map->lat . ',' . $map->lng;
            $marker['infowindow_content'] = $map->address;
            $marker['animation'] = 'DROP';
            $this->googlemaps->add_marker($marker);
        } else {
            $config = array();
            $config['center'] = 'Indonesia';
            $config['zoom'] = '15';
            $config['onclick'] = 'deleteMarkers();createMarker_map({ map: map, position:event.latLng });updateDatabase(event.latLng.lat(), event.latLng.lng());';
            $this->googlemaps->initialize($config);
        }
        $this->data['map'] = $this->googlemaps->create_map();
//form map
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address_text',
            'value' => $map ? $map->address : '',
            'class' => 'form-control'
        );
        $this->data['country'] = array(
            'name' => 'country',
            'id' => 'country',
            'value' => $map ? $map->country : '',
            'class' => 'form-control'
        );
        $this->data['province'] = array(
            'name' => 'province',
            'id' => 'province',
            'value' => $map ? $map->province : '',
            'class' => 'form-control'
        );
        $this->data['town'] = array(
            'name' => 'town',
            'id' => 'town',
            'value' => $map ? $map->town : '',
            'class' => 'form-control'
        );
        $this->data['coord'] = array(
            'name' => 'coord',
            'id' => 'coord',
            'value' => $map ? $map->lat . ',' . $map->lng : '',
            'type' => 'hidden',
        );
        if ($this->input->post('newLat', FALSE) && $this->input->post('newLng', FALSE)) {
            $coord = array(
                'lat' => $this->input->post('newLat'),
                'lng' => $this->input->post('newLng')
            );
            echo json_encode($coord);
            exit();
        }
        // form features
        $prop = $this->m_options->get_many_by_feat(array('type_features' => 1));
        $com = $this->m_options->get_many_by_feat(array('type_features' => 0));
        $pf = $this->m_places->get_pf(array('id_places' => $id));
        if ($pf) {
            foreach ($pf as $p) {
                foreach ($prop as $k => $v) {
                    if ($p->id_feature == $prop[$k]->id_features) {
                        $prop[$k]->checked = 'checked';
                    }
                }
                foreach ($com as $c => $cv) {
                    if ($p->id_feature == $com[$c]->id_features) {
                        $com[$c]->checked = 'checked';
                    }
                }
            }
            $this->data['feat_property'] = $prop;
            $this->data['feat_com'] = $com;
        } else {
            $this->data['feat_property'] = $this->m_options->get_many_by_feat(array('type_features' => 1));
            $this->data['feat_com'] = $this->m_options->get_many_by_feat(array('type_features' => 0));
        }
        // form owner
        $this->data['owner'] = $this->m_places->get_owner(array('id_places' => $id));
        $this->data['name_owner'] = array(
            'name' => 'name_owner',
            'id' => 'name_owner',
            'value' => $this->data['owner'] ? $this->data['owner']->name_owner : '',
            'class' => 'form-control'
        );
        $this->data['email_owner'] = array(
            'name' => 'email_owner',
            'id' => 'email_owner',
            'value' => $this->data['owner'] ? $this->data['owner']->email_owner : '',
            'class' => 'form-control'
        );
        $this->data['adds_owner'] = array(
            'name' => 'adds_owner',
            'id' => 'adds_owner',
            'value' => $this->data['owner'] ? $this->data['owner']->adds_owner : '',
            'class' => 'form-control'
        );
        $this->data['telp_owner'] = array(
            'name' => 'telp_owner',
            'id' => 'telp_owner',
            'value' => $this->data['owner'] ? $this->data['owner']->telp_owner : '',
            'class' => 'form-control'
        );
        $this->data['mob_owner'] = array(
            'name' => 'mob_owner',
            'id' => 'mob_owner',
            'value' => $this->data['owner'] ? $this->data['owner']->mob_owner : '',
            'class' => 'form-control'
        );
        $this->data['content'] = 'backend/property/edit';
        $this->load->view($this->template, $this->data);
    }

    public function save_owner() {
        $id_places = $this->input->post('id_places');
        $data = $this->m_places->array_from_post(array('name_owner', 'email_owner', 'adds_owner', 'telp_owner', 'mob_owner'));
        $hasil = array(
            'validate' => FALSE
        );
        $data_place = array(
            'last_update' => date('Y-m-d H:i:s')
        );
        if ($this->form_validation->run('owner') == true) {
            if ($this->m_places->update_owner($data, $id_places)) {
                $this->m_places->update($data_place, $id_places);
                $hasil = array(
                    'validate' => TRUE,
                    'last_update' => date("D, F j Y, g:i a", strtotime($data_place['last_update'])));
            }
        } else {
            echo validation_errors();
        }
        echo json_encode($hasil);
    }

    public function save_map() {
        $hasil = array(
            'validate' => FALSE
        );
        $id_places = $this->input->post('id_places');
        $address = explode(',', strip_tags($this->input->post('address')));
        $coord = explode(',', $this->input->post('coord'));
        $data = array(
            'address' => strip_tags($this->input->post('address')),
            'province' => strip_tags($this->input->post('province')),
            'country' => strip_tags($this->input->post('country')),
            'town' => strip_tags($this->input->post('town')),
            'lat' => (floatval($coord[0])),
            'lng' => (floatval($coord[1])),
        );
        $data_place = array(
            'last_update' => date('Y-m-d H:i:s')
        );
        if ($this->form_validation->run('maps') == true) {
            if (!$this->m_places->get_map(array('id_places' => $id_places))) {
                $data['id_places'] = $id_places;
                if ($this->m_places->insert_map($data))
                    $this->m_places->update($data_place, $id_places);
                $hasil = array(
                    'validate' => TRUE,
                    'last_update' => date("D, F j Y, g:i a", strtotime($data_place['last_update']))
                );
            } else {
                if ($this->m_places->update_map($data, $id_places))
                    $this->m_places->update($data_place, $id_places);
                $hasil = array(
                    'validate' => TRUE,
                    'last_update' => date("D, F j Y, g:i a", strtotime($data_place['last_update']))
                );
            }
        }
        echo json_encode($hasil);
    }

    public function save_detail() {
        $hasil = array(
            'validate' => FALSE
        );
        $data = $this->m_places->array_from_post(array(
            'status', 'id_type', 'prices', 'year_built', 'lot_dim', 'floor_dim', 'bedrooms', 'bathrooms', 'desc'
        ));
        $id = $this->input->post('id_places');
        $data_place = array(
            'last_update' => date('Y-m-d H:i:s')
        );
        if ($this->form_validation->run('details')) {
            if ($this->m_places->update_detail($data, $id)) {
                $this->m_places->update($data_place, $id);
                $hasil = array_merge($data, array(
                    'validate' => TRUE,
                    'last_update' => date("D, F j Y, g:i a", strtotime($data_place['last_update']))));
            }
        }
        echo json_encode($hasil);
    }

    public function save_feat() {
        $feat = $this->input->post('features');
        $id_places = $this->input->post('id_places');
        if ($this->m_places->get_pf(array('id_places' => $id_places))) {
            $this->m_places->del_pf($id_places);
        }
        if ($feat) {
            foreach ($feat as $f) {
                $this->m_places->insert_pf(array('id_places' => $id_places, 'id_feature' => $f));
            }
        }
        $this->m_places->update(array('last_update' => date('Y-m-d H:i:s')), $id_places);
        $hasil = array(
            'validate' => TRUE,
            'last_update' => date("D, F j Y, g:i a", strtotime(date('Y-m-d H:i:s'))));
        echo json_encode($hasil);
    }

    public function get_img() {
        $tinythumb = base_url('assets/img');
        $id_places = $this->input->post('id_places');
        $data = $this->m_places->get_img(array('id_places' => $id_places));
        $str = '';
        if ($data->result()) {
            foreach ($data->result() as $row) {
                $str .='<div class="col-md-3 thumb" style="margin-bottom:5px">';
                $str .='<img class="responsive" src="' . $tinythumb . '/timthumb.php?src=' . base_url() . $row->image . '&h=150&w=150&zc=1">';
                $str .='<a href="' . site_url('places/del_img') . '" class="btn btn-primary" id="delete_img' . $row->id_photo . '">Delete</a>';
                $str .= _toaktif('admin/places/set_default' . '/' . $id_places, $row->id_photo, $row->default);
                $str .='</div>';
                $str.='<script>del_img(' . $row->id_photo . ');</script>';
                $str.='<script>to_active("admin/places/set_default/' . $id_places . '",' . $row->id_photo . ',' . $row->default . ');</script>';
            }
        } else {
            $str .= '<div class="col-md-3 thumb" style="margin-bottom:5px"><p>No Photos Yet</p></div>';
        }
        echo $str;
    }

    public function set_default($id = 0, $id_foto = 0) {
        $id_places = $this->input->post('id_place');
        $hasil = array(
            'respond' => false,
        );
        $id OR redirect(site_url('admin/kelas/gambar'));
        if ($this->m_places->set_default($id, $id_foto)) {
            $this->m_places->update(array('last_update' => date('Y-m-d H:i:s')), $id_places);
            $hasil = array(
                'respond' => TRUE,
                'last_update' => date('D, F j Y, g:i a')
            );
        }
        echo json_encode($hasil);
    }

    public function del_img($id) {
        $id_places = $this->input->post('id_place');
        $hasil = array(
            'respond' => FALSE
        );
        if ($this->m_places->del_img($id)) {
            $this->m_places->update(array('last_update' => date('Y-m-d H:i:s')), $id_places);
            $hasil = array(
                'respond' => TRUE,
                'last_update' => date('D, F j Y, g:i a')
            );
        }
        echo json_encode($hasil);
    }

    public function upload() {
        $id_places = $this->input->post('id_places');
        $config['upload_path'] = './assets/upload';
        $config['allowed_types'] = 'gif|jpg|png|zip|avi';
        /* $config['max_size']	= '1000';
          $config['max_width']  = '1024';
          $config['max_height']  = '768'; */

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            echo '<div id="status">error</div>';
            echo '<div id="message">' . $this->upload->display_errors() . '</div>';
        } else {
            $data = array('upload_data' => $this->upload->data(), 'last_update' => date('D, F j Y, g:i a'));
            $konfigurasi = array(
                'source_image' => $data['upload_data']['full_path'],
                'new_image' => './assets/upload/thumb',
                'maintain_ratio' => false,
                'width' => 100,
                'height' => 120
            );
            $this->load->library('image_lib', $konfigurasi);
            $this->image_lib->resize();
            $photo = array(
                'id_places' => $id_places,
                'image' => 'assets/upload/' . $data['upload_data']['file_name'],
                'thumb' => 'assets/upload/thumb/' . $data['upload_data']['file_name']
            );
            if ($this->m_places->insert_photo($photo)) {
                $this->m_places->update(array('last_update' => date('Y-m-d H:i:s')), $id_places);
            }
            echo '<div id="status">success</div>';
            //then output your message (optional)
            echo '<div id="message">' . $data['upload_data']['file_name'] . ' Successfully uploaded.</div>';
            //pass the data to js
            echo '<div id="upload_data">' . json_encode($data) . '</div>';
        }
    }

    public function update() {
        $hasil = array(
            'validate' => FALSE
        );
        $id = $this->input->post('id_place');
        $data = array(
            'status_places' => $this->input->post('status'),
            'title_places' => strip_tags($this->input->post('title')),
            'last_update' => date('Y-m-d H:i:s')
        );
        if ($this->m_places->update($data, $id)) {
            $hasil = array(
                'validate' => TRUE,
                'last_update' => date("D, F j Y, g:i a", strtotime($data['last_update']))
            );
        }
        echo json_encode($hasil);
    }

}

?>