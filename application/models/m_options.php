<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_places
 *
 * @author Syiewa
 */
class M_options extends MY_Model {

    var $table_details = 'details_place';
    var $table_types = 'types';
    var $table_features = 'features';
    var $curr = array(
        0 => 'USD',
        1 => 'Rp.'
    );
    var $floor = array(
        0 => 'sq meter',
        1 => 'sq feet'
    );
    var $status_contact = array(
        0 => 'No',
        1 => 'Yes',
    );
    var $type_feat = array(
        0 => 'Community Feature',
        1 => 'Property Feature'
    );

    public function __construct() {
        parent::__construct();
        parent::set_tabel('options', 'id_option');
    }

    public function get_type() {
        return $this->db->get($this->table_types)->result();
    }

    public function get_features() {
        return $this->db->get($this->table_features)->result();
    }

    public function get_many_by_feat($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->get_features();
        }
        return FALSE;
    }

    public function save_feat($data = array()) {
        if ($this->db->insert($this->table_features, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function save_type($data = array()) {
        if ($this->db->insert($this->table_types, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_type($data = array(), $id = 0) {
        $this->db->where(array('id_type' => $id));
        if ($this->db->update($this->table_types, $data)) {
            return true;
        }
        return false;
    }

    public function update_feat($data = array(), $id = 0) {
        $this->db->where(array('id_features' => $id));
        if ($this->db->update($this->table_features, $data)) {
            return true;
        }
        return false;
    }

    public function delete_type($id = 0) {
        if ($this->db->delete($this->table_types, array('id_type' => $id))) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_feat($id = 0) {
        if ($this->db->delete($this->table_features, array('id_features' => $id))) {
            return TRUE;
        }
        return FALSE;
    }

}

?>