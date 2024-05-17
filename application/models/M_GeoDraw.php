<?php

class M_GeoDraw extends CI_Model
{
    private $tb_geo_draw = 'tb_geo_draw';

    public function getIdUser(){
        $data_user = $this->session->userdata("data_login");
        return $data_user['id'];
    }

    public function getAllData(){
        $id_user = $this->getIdUser();
        if (isset($id_user) || !empty($id_user)) {
            $this->db->where('id_user', $id_user);
        }
        $this->db->group_by('polygon_name');
        $this->db->order_by('last_update', 'desc');
        return $this->db->get($this->tb_geo_draw);
    }
    
    public function getDataBy($where, $withGroupBy = true){
        $id_user = $this->getIdUser();
        if (isset($id_user) || !empty($id_user)) {
            $this->db->where('id_user', $id_user);
        }
        if ($withGroupBy) {
            $this->db->group_by('polygon_name');
        }
        $this->db->order_by('last_update', 'desc');
        return $this->db->get_where($this->tb_geo_draw, $where);
    }

    public function getDataDownloadAll(){
        $id_user = $this->getIdUser();
        if (isset($id_user) && empty($id_user)) {
            return [];
        }
        $this->db->select('id_drawing, id_user, polygon_name, link, last_update');
        $this->db->where('id_user', $id_user);
        $this->db->group_by('polygon_name');
        $this->db->order_by('last_update', 'desc');
        return $this->db->get($this->tb_geo_draw);
    }

    public function addData($object){
        $this->db->insert($this->tb_geo_draw, $object);
        // $this->removeDuplicateRows('polygon_name');
        return $this->getAllData()->result();
    }

    public function editData($id, $object){
        $this->db->where('id_drawing', $id);
        $this->db->update($this->tb_geo_draw, $object);
    }

    public function deleteData($where){
        // $this->db->delete($this->tb_geo_draw, ['id_drawing' => $id]);
        $this->db->delete($this->tb_geo_draw, $where);
        return $this->getAllData()->result();
    }

    public function removeDuplicateRows($column_name) {
        $this->db->select_min('id_drawing'); // Pilih id terkecil dari baris duplikat
        $this->db->from($this->tb_geo_draw);
        $this->db->group_by($column_name);
        $subquery = $this->db->get_compiled_select();

        $this->db->where("id_drawing NOT IN ($subquery)", NULL, FALSE);
        $this->db->delete($this->tb_geo_draw);
        return $this->getAllData()->result();
    }
    
    public function deleteAllData(){
        // // Hapus semua data dari tabel
        // $this->db->truncate($this->tb_geo_draw);
        
        // // Setel ulang auto-increment ke nilai awal (1)
        // $query = "ALTER TABLE $this->tb_geo_draw AUTO_INCREMENT = 1";
        // $this->db->query($query);
        
        $id_user = $this->getIdUser();
        $this->db->delete($this->tb_geo_draw, ['id_user' => $id_user]);
        return $this->getAllData()->result();
    }

}