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
class Places extends Frontend_Controller {

//put your code here
    var $template = 'frontend/template';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_options');
        $this->data['currency'] = $this->m_options->curr;
        $this->data['status'] = $this->m_places->status_detail;
        $this->data['type'] = $this->m_places->get_type();
        $this->data['floor'] = $this->m_options->floor;
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
    }

    public function index($offset = 0) {
        $this->data['content'] = 'frontend/index';
        $this->load->view($this->template, $this->data);
    }

    public function search($offset = 0) {
        $options = $this->m_places->array_from_post(array('title_s', 'type', 'city', 'minbed', 'maxbed', 'minbath', 'maxbath', 'minprice', 'maxprice', 'minfloor', 'maxfloor'));
        if ($this->form_validation->run('search')) {
            $count = $this->m_places->search($options, $status = FALSE);
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
            $telo = $this->m_places->search($options, $status = FALSE, $perpage, $offset);
            $str = '';
            if ($telo) {
                $str .= '<section class="col-xs-12 col-sm-6 col-md-12">';
                foreach ($telo as $s) {
                    $str .= '<article class="search-result row">';
                    $str .= $s->image ? '<div class="col-xs-12 col-sm-12 col-md-3"><img class="img-responsive thumbnail" src="' . base_url('assets/img/timthumb.php') . '?src=' . base_url($s->image) . '&zc=0&h=140&w=180"></div>' : '<div class="col-xs-12 col-sm-12 col-md-3"><img class="img-responsive thumbnail" src="http://placehold.it/250x140&text=no+primary+image"></div>';
                    $str .= '<div class="col-xs-12 col-sm-12 col-md-2"><ul class="meta-search">';
                    $str .= '<ul><i class="fa fa-money"></i><span> ' . ($s->prices === null ? 'Not Set' : $this->data['currency'][getOptions('currency')] . ' ' . currency($s->prices)) . '</span></li>';
                    $str .= '<ul><li><i class="glyphicon glyphicon-home"></i> <span>' . ($s->title_type === null ? 'Not Set' : $s->title_type) . '</span></li>';
                    $str .= '<ul><li><i class="fa fa-arrows"></i> <span>' . ($s->floor_dim === null ? 'Not Set' : $s->floor_dim . ' ' . $this->data['floor'][getOptions('floor_metric')]) . '</span></li>';
                    $str .= '<ul><li><i class="fa fa-table"></i> <span>' . ($s->bedrooms === null ? 'Not Set' : $s->bedrooms . ' bedrooms') . '</span></li>';
                    $str .= '<ul><li><a href=' . site_url('front/places/details') . '/' . $s->id_places . ' class="btn btn-primary btn-xs">View Details</a></li>';
                    $str .='</ul></div>';
                    $str .= '<div class="col-xs-12 col-sm-12 col-md-7 excerpet">';
                    $str .= '<h3>' . $s->title_places . ' / ' . $this->data['status'][$s->status] . '</h3>';
                    $str .= '<p>'.limit_to_numwords(strip_tags($s->desc),50).'</p></div>';
//                    $str .= '<td>' . ($s->title_type === null ? 'Not Set' : $s->title_type) . '</td>';
//                    $str .= '<td>' . ($s->prices === null ? 'Not Set' : $this->data['currency'][getOptions('currency')] . ' ' . currency($s->prices)) . '</td>';
                    $str .= '<span class="clearfix borda"></span></article>';
                }
                $str .= '<div>' . $this->pagination->create_links() . '</div>';
                $str .= '</section>';
            } else {
                $str .= 'No Data Found';
            }
            echo $str;
        }
    }

    public function details($id) {
        $this->data['meta_title'] = "View Details";
        $this->data['summary'] = $this->m_places->get($id);
        $this->data['detail'] = $this->m_places->get_detail(array('id_places' => $id));
        $this->data['feat_property'] = $this->m_places->get_pf_front(array('id_places' => $id,'type_features' => 1));
        $this->data['feat_com'] = $this->m_places->get_pf_front(array('id_places' => $id,'type_features' => 0));
        $this->data['owner'] = $this->m_places->get_owner(array('id_places' => $id));
        $this->data['location'] = $this->m_places->get_map(array('id_places' => $id));
        $this->data['image'] = $this->m_places->get_img(array('id_places' => $id))->result();
        if ($this->data['location']) {
            $this->load->library('googlemaps');
            $config['center'] = $this->data['location']->lat.','.$this->data['location']->lng;
            $config['zoom'] = '15';
            $config['onload'] = "google.maps.event.trigger(marker_0, 'click');";
            $this->googlemaps->initialize($config);
            $marker = array();
            $marker['position'] = $this->data['location']->lat.','.$this->data['location']->lng;
            $marker['infowindow_content'] = '<b>'.$this->data['summary']->title_places.'</b><br />'.$this->data['location']->address;
            $this->googlemaps->add_marker($marker);
            $this->data['map'] = $this->googlemaps->create_map();
        }
        $this->data['content'] = 'frontend/details';
        $this->load->view($this->template, $this->data);
    }

}
