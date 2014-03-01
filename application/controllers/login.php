<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Frontend_Controller {

    var $template = 'backend/template';

    function __construct() {
        parent::__construct();
    }

    function index() {
        $log = array(
            'valid' => FALSE
        );
        $this->form_validation->set_rules('identity', 'Identity', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|strip_tags');
        if ($this->input->is_ajax_request()) {
            if ($this->form_validation->run() == true) {
                $remember = (bool) $this->input->post('remember');

                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    $log = array('valid' => TRUE, 'msg' => 'Login Success');
                } else {
                    $log = array('valid' => FALSE, 'msg' => strip_tags($this->ion_auth->errors()));
                }
            }
            echo json_encode($log);
        } else {
            $this->data['meta_title'] = "Login";
            if (!$this->ion_auth->logged_in()) {
                $this->data['content'] = 'backend/login';
                $this->load->view($this->template, $this->data);
            } else {
                redirect('admin/places');
            }
        }
    }

    function logout() {
        $this->data['meta_title'] = "Logout";
        $logout = $this->ion_auth->logout();
        redirect('login', 'refresh');
    }

}
