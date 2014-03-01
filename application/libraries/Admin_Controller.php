<?php

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['meta_title'] = 'Admin Page';
        $this->load->library('ion_auth');
        $this->load->model('m_places');
        $this->lang->load('auth');
        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('login', 'refresh');
        } 
    }

}
