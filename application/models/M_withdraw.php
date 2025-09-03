<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_withdraw extends CI_Model {

    var $tbl         = 'dwigital_withdraw';
    var $tblPlatform = 'md_platform';

    public function list($q = null) {
        $this->db->select('w.id, w.sumber, w.nominal, w.tanggal, p.nama AS nama_platform');
        $this->db->from($this->tbl.' w');
        $this->db->join($this->tblPlatform.' p', 'p.id = w.sumber', 'left');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('p.nama', $q);
            $this->db->or_like('w.nominal', $q);
            $this->db->or_like('w.tanggal', $q);
            $this->db->group_end();
        }
        return $this->db->get()->result();
    }

    public function get($id) {
        $this->db->select('w.*, p.nama AS nama_platform');
        $this->db->from($this->tbl.' w');
        $this->db->join($this->tblPlatform.' p', 'p.id = w.sumber', 'left');
        $this->db->where('w.id', $id);
        return $this->db->get()->row();
    }

    public function platforms() {
        return $this->db->select('id, nama')
                        ->from($this->tblPlatform)
                        ->order_by('nama','ASC')
                        ->get()->result();
    }

    public function insert($data) {
        return $this->db->insert($this->tbl, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->tbl, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->tbl);
    }
}
