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
class Users extends Admin_Controller {

//put your code here
    var $template = 'backend/template';

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) { //remove this elseif if you want to enable this for non-admins
            //redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }
    }

    public function get_alluser() {
        //list the users
        $users = $this->ion_auth->users()->result();
        $groups = $this->ion_auth->groups()->result_array();
        foreach ($users as $k => $user) {
            $users[$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }
        $table = "";
        if ($users) {
            $table .= " <table class='table table-bordered table-condensed'>
                        <tr class='active' >
                            <th>" . lang('index_fname_th') . "</th>
                            <th>" . lang('index_lname_th') . "</th>
                            <th>" . lang('index_email_th') . "</th>
                            <th>" . lang('index_groups_th') . "</th>
                            <th>" . lang('index_status_th') . "</th>
                            <th>" . lang('index_action_th') . "</th>
                        </tr>";
            foreach ($users as $u) {
                if ($this->session->userdata('user_id') == $u->id) {
                    $disabled = 'disabled';
                } else {
                    $disabled = '';
                }
                $table .='<tr><td>' . $u->first_name . '</td>';
                $table .='<td>' . $u->last_name . '</td>';
                $table .='<td>' . $u->email . '</td>';
                $table .='<td>';
                foreach ($u->groups as $g) {
                    $table .= $g->name . '<br />';
                }
                $table .='</td><td>';
                $table .= ($u->active) ? anchor("admin/users/deactivate/" . $u->id, lang('index_active_link'), array('class' => 'btn btn-success '.$disabled, 'id' => 'active')) : anchor("admin/users/activate/" . $u->id, lang('index_inactive_link'), array('class' => 'btn btn-default '.$disabled, 'id' => 'inactive'));
                ($u->active) ? anchor("admin/users/deactivate/" . $u->id, lang('index_active_link')) : anchor("admin/users/activate/" . $u->id, lang('index_inactive_link'));
                $table .='</td><td>';
                $table .= anchor("admin/users/edit/" . $u->id, 'Edit', array('class' => 'btn btn-primary', 'id' => 'edit', 'data-toggle' => 'modal', 'data-target' => '#telo')) . '</td>';
            }
            echo $table;
        } else {
            $table .= '<p> No Data Yet </p>';
        }
    }

    public function index() {
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        //list the users
        $this->data['users'] = $this->ion_auth->users()->result();
        $groups = $this->ion_auth->groups()->result_array();
        $this->data['groups'] = array();
        foreach ($groups as $g) {
            $this->data['groups'][$g['id']] = $g['name'];
        }
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }

        // form create user
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('email'),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('company'),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('phone'),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('password'),
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('password_confirm'),
        );
        $this->data['content'] = 'backend/users/index';
        $this->load->view($this->template, $this->data);
    }

    public function create_new() {
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
        $email = strtolower($this->input->post('email'));
        $password = $this->input->post('password');
        $group = array($this->input->post('groups'));

        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'phone' => $this->input->post('phone'),
        );
        $this->ion_auth->register($username, $password, $email, $additional_data, $group);
        echo $this->db->last_query();
    }

    public function cek_email() {
        $email = $this->input->post('email');
        if (isset($email)) {
            if ($this->ion_auth->email_check($email)) {
                echo "false";
            } else {
                echo "true";
            }
        }
    }

    public function deactivate($id = null) {
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;
        $this->ion_auth->deactivate($id);
        echo $this->db->last_query();
        die();
    }

    public function activate($id = null) {
        $this->ion_auth->activate($id);
        echo $this->db->last_query();
        die();
    }

    public function edit($id = null) {
        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $groups_combo = array();
        foreach ($groups as $g) {
            $groups_combo[$g['id']] = $g['name'];
        }
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
//pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups_combo;
        $this->data['currentGroups'] = $currentGroups;
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');
        $this->data['id'] = array(
            'name' => 'id',
            'id' => 'id',
            'type' => 'hidden',
            'class' => 'form-control',
            'value' => $user->id,
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password_e',
            'class' => 'form-control',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'class' => 'form-control',
            'type' => 'password'
        );

        $this->load->view('backend/users/edit', $this->data);
        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );

            //Update the groups user belongs to
            $groupData = $this->input->post('groups');

            if (isset($groupData) && !empty($groupData)) {

                $this->ion_auth->remove_from_group('', $id);
                $this->ion_auth->add_to_group($groupData, $id);
            }

            //update the password if it was posted
            if ($this->input->post('password') != '') {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE) {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
            }
        }
    }

}
