<?php

class Frontend_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['meta_title'] = 'FrontEnd';
        $this->load->library('ion_auth');
        $this->load->model('m_places');
        $this->lang->load('auth');
    }

}
