<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of options
 *
 * @author Syiewa
 */
class Options extends Admin_Controller {

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
        $this->load->model('m_options');
        $this->load->model('m_places');
    }

    public function index() {
        $this->data['options'] = $this->m_options->get_all();
        $this->data['curr'] = $this->m_options->curr;
        $this->data['floor_metric'] = $this->m_options->floor;
        // form general
        $this->data['paging'] = array(
            'name' => 'options[]',
            'id' => 'paging',
            'value' => $this->data['options'][2]->value,
            'class' => 'form-control',
        );
        $this->data['contact_form'] = $this->m_options->status_contact;
        // form type
        $this->data['title_type'] = array(
            'name' => 'title_type',
            'id' => 'title_type',
            'placeholder' => 'Input Title',
            'value' => '',
            'class' => 'form-control',
        );
        $this->data['id_type'] = array(
            'name' => 'id_type',
            'id' => 'id_type',
            'value' => '',
            'type' => 'hidden',
        );
        $this->data['types'] = $this->m_options->get_type();
        // form features
        $this->data['title_feature'] = array(
            'name' => 'title_feature',
            'id' => 'title_feature',
            'placeholder' => 'Input Title',
            'value' => '',
            'class' => 'form-control',
        );
        $this->data['id_feature'] = array(
            'name' => 'id_feature',
            'id' => 'id_feature',
            'value' => '',
            'type' => 'hidden',
        );
        $this->data['features'] = $this->m_options->get_features();
        $this->data['type_feat'] = $this->m_options->type_feat;
        $this->data['content'] = 'backend/options/index';
        $this->load->view($this->template, $this->data);
    }

    public function action_general() {
        $i = 1;
        foreach ($this->input->post('options') as $g) {
            $this->m_options->update(array('value' => mysql_real_escape_string($g)), $i);
            $i++;
        }
        $hasil = array('validate' => TRUE);
        echo json_encode($hasil);
    }

    public function action_type() {
        $data = array(
            'title_type' => $this->input->post('title_type'),
            'id_type' => $this->input->post('id_type')
        );
        $str = '';
        if ($this->form_validation->run('type') == true) {
            if ($this->input->post('title_type') && $data['id_type'] == '') {
                $id = $this->m_options->save_type($data);
                if ($id) {
                    $str .= '<tr id="item-' . $id . '">';
                    $str .= '<td class="col-md-6" id="type-' . $id . '">' . $data['title_type'] . '</td>';
                    $str .='<td class="col-md-6"><a href="#" class="edit" id="del-' . $id . '"><span class="glyphicon glyphicon-edit"></span></a> <a id="del-' . $id . '" href="" class="del text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>';
                    $str .='</tr>';
                    echo $str;
                }
            }
            if ($data['title_type'] != '' & $data['id_type'] != '') {
                $this->m_options->update_type($data, $data['id_type']);
                echo json_encode($data);
            }
        }
        if ($this->input->post('id_type') && $data['title_type'] == '') {
            $id_type = $this->input->post('id_type');
//            $this->m_places->update_detail_by(array('id_type' => $id_type), array('id_type' => 0));
            if ($this->m_options->delete_type($id_type)) {
                echo 'sukses';
            }
        }
    }

    public function action_feat() {
        $cat = $this->m_options->type_feat;
        $data = $this->m_options->array_from_post(array('id_features', 'type_features', 'title_features'));
        $str = '';
        if ($this->form_validation->run('feature')) {
            if ($data['title_features'] != '' && $data['id_features'] == '') {
                $id = $this->m_options->save_feat($data);
                if ($id) {
                    $str .= '<tr id="item-feat-' . $id . '">';
                    $str .= '<td class="col-md-5" id="feat-' . $id . '">' . $data['title_features'] . '</td>';
                    $str .= '<td class="col-md-4" id="cat-' . $id . '">' . $cat[$data['type_features']] . '</td>';
                    $str .='<td class="col-md-3"><a href="#" class="edit-feat" id="edit-feat-' . $id . '"><span class="glyphicon glyphicon-edit"></span></a> <a id="del-feat' . $id . '" href="" class="del-feat text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>';
                    $str .='</tr>';
                    echo $str;
                }
            }
            if ($data['title_features'] != '' & $data['id_features'] != '') {
                $this->m_options->update_feat($data, $data['id_features']);
                $data['type_features'] = $cat[$data['type_features']];
                echo json_encode($data);
            }
        }
        if ($this->input->post('id_features') && $data['title_features'] == '') {
            $id_features = $this->input->post('id_features');
            if ($this->m_options->delete_feat($id_features)) {
                echo 'sukses';
            }
        }
    }

}

?>
