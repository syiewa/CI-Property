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
class M_places extends MY_Model {

    var $table_details = 'details_place';
    var $table_photo = 'photos';
    var $table_maps = 'maps';
    var $table_types = 'types';
    var $table_pf = 'place_feat';
    var $table_owner = 'owner';
    var $status_place = array(
        0 => 'Show',
        1 => 'Hide'
    );
    var $status_detail = array(
        0 => '<span class="label label-success">Available</span>',
        1 => '<span class="label label-danger">Sold</span>',
        2 => '<span class="label label-primary">Under Offer</span>',
        3 => '<span class="label label-warning">Premium</span>'
    );

    public function __construct() {
        parent::__construct();
        parent::set_tabel('places', 'id_places');
    }

    public function search($options = array(), $status = true, $limit = 5, $offset = 0) {
        $str = '';
        if (isset($options['type'])) {
            if ($options['type'] == 0) {
                $str .= '';
            } else {
                $str .= 'AND d.id_type = ' . $this->db->escape($options['type']);
            }
        }
        if ($options['city'] != '') {
            $str .= ' AND m.town LIKE "%' . $this->db->escape($options['city']) . '%"';
        }
        if ($options['minbed'] != '') {
            $str .= ' AND d.bedrooms >=' . $this->db->escape($options['minbed']);
        }
        if ($options['maxbed'] != '') {
            $str .= ' AND d.bedrooms <=' . $this->db->escape($options['maxbed']);
        }
        if ($options['minbath'] != '') {
            $str .= ' AND d.bathrooms >=' . $this->db->escape($options['minbath']);
        }
        if ($options['maxbath'] != '') {
            $str .= ' AND d.bathrooms <=' . $this->db->escape($options['maxbath']);
        }
        if ($options['minprice'] != '') {
            $str .= ' AND d.prices >=' . $this->db->escape($options['minprice']);
        }
        if ($options['maxprice'] != '') {
            $str .= ' AND d.prices <=' . $this->db->escape($options['maxprice']);
        }
        if ($options['minfloor'] != '') {
            $str .= ' AND d.floor_dim >=' . $this->db->escape($options['minfloor']);
        }
        if ($options['maxfloor'] != '') {
            $str .= ' AND d.floor_dim <=' . $this->db->escape($options['maxfloor']);
        }
        if (!$status) {
            $str .= ' AND p.status_places =0';
        }
        $search = $this->db->query('
            SELECT `p`.`id_places`,p.title_places, dp.title_type,d.prices,d.floor_dim,d.status,d.bedrooms,d.desc,ph.`image` FROM `places` p
            LEFT JOIN (
                    SELECT d.`id_places`,t.title_type FROM details_place d
                    LEFT JOIN `types` t ON t.`id_type` = d.`id_type`
            ) dp ON dp.id_places = p.`id_places`
            LEFT JOIN details_place d
            ON d.`id_places` = p.`id_places`
            LEFT JOIN maps m
            ON d.`id_places` = m.`id_places`
            LEFT JOIN (
                SELECT * FROM `photos`
                WHERE `default` = 1
            ) ph ON ph.`id_places` = p.`id_places`
            WHERE p.title_places LIKE "%' . $options['title_s'] . '%"
                ' . $str . '
            GROUP BY `p`.`id_places` LIMIT ' . $offset . ',' . $limit);
        return $search->result();
    }

    public function get_place($limit = 5, $offset = 0) {
        $q = $this->db->query('SELECT `p`.`id_places`,p.title_places, dp.title_type,d.prices,ph.`image` FROM `places` p
            LEFT JOIN (
                    SELECT d.`id_places`,t.title_type FROM details_place d
                    LEFT JOIN `types` t ON t.`id_type` = d.`id_type`
            ) dp ON dp.id_places = p.`id_places`
            LEFT JOIN details_place d
            ON d.`id_places` = p.`id_places`
            LEFT JOIN (
                SELECT * FROM `photos`
                WHERE `default` = 1
            ) ph ON ph.`id_places` = p.`id_places`
            GROUP BY `p`.`id_places`
            LIMIT ' . $offset . ',' . $limit);
        return $q->result();
    }

    public function get_detail($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->db->get($this->table_details)->row();
        }
        return FALSE;
    }

    public function get_owner($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->db->get($this->table_owner)->row();
        }
        return FALSE;
    }

    public function get_pf($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->db->get($this->table_pf)->result();
        }
        return FALSE;
    }

    public function get_img($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->db->get($this->table_photo);
        }
        return FALSE;
    }

    public function insert($data = array()) {
        if (parent::insert($data)) {
            $id_places = $this->db->insert_id();
            return $id_places;
        }
        return FALSE;
    }

    public function insert_detail($data = array()) {
        $this->db->insert($this->table_details, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function insert_map($data = array()) {
        $this->db->insert($this->table_maps, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function insert_pf($data = array()) {
        $this->db->insert($this->table_pf, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function insert_photo($data = array()) {
        $this->db->insert($this->table_photo, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function update($data = array(), $id = 0) {
        parent::update($data, $id);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function update_detail($data = array(), $id = 0) {
        $this->db->where(array('id_places' => $id));
        if ($this->db->update($this->table_details, $data)) {
            return true;
        }
        return false;
    }

    public function update_detail_by($where = array(), $data = array()) {
        $this->db->where($where);
        if ($this->db->update($this->table_details, $data)) {
            return TRUE;
        }
        return false;
    }

    public function update_owner($data = array(), $id = 0) {
        if (!$this->get_owner(array('id_places' => $id))) {
            $data['id_places'] = $id;
            $this->db->insert($this->table_owner, $data);
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        } else {
            $this->db->where(array('id_places' => $id));
            if ($this->db->update($this->table_owner, $data)) {
                return true;
            }
        }
        return false;
    }

    public function update_map($data = array(), $id = 0) {
        $this->db->where(array('id_places' => $id));
        if ($this->db->update($this->table_maps, $data)) {
            return true;
        }
        return false;
    }

    public function get_map($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->db->get($this->table_maps)->row();
        }
        return FALSE;
    }

    function get_type() {
        $this->db->select('id_type,title_type');
        $query = $this->db->get($this->table_types);
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[$row['id_type']] = $row['title_type'];
        }
        return $data;
    }

    public function insert_file($filename, $title) {
        $data = array(
            'image' => $filename,
            'photoplan' => $title
        );
        $this->db->insert($this->table_photo, $data);
        return $this->db->insert_id();
    }

    public function del_pf($id = null) {
        if ($this->db->delete($this->table_pf, array('id_places' => $id))) {
            return TRUE;
        }
        return FALSE;
    }

    public function del_img($id = null) {
        $images = $this->get_img(array('id_photo' => $id));
        if ($images->num_rows > 0) {
            $file_gmbr = './' . $images->row()->image;
            $file_thumb = './' . $images->row()->thumb;
            unlink($file_gmbr);
            unlink($file_thumb);
            if ($this->db->delete($this->table_photo, array('id_photo' => $id))) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function set_default($id = 0, $id_foto = 0) {
        $data1 = array('default' => '0');
        $this->db->where(array('id_places' => $id));
        if ($this->db->update($this->table_photo, $data1)) {
            $this->_set_to_default($id_foto);
            return true;
        }
        return false;
    }

    private function _set_to_default($id_foto = 0) {
        $data2 = array('default' => 1);
        $this->db->where(array('id_photo' => $id_foto));
        $this->db->update($this->table_photo, $data2);
    }

}

?>
