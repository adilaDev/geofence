<?php

class M_Drawing extends CI_Model
{
    private $tb_drawing = 'tb_drawing';
    private $tb_info = 'tb_info';
    private $data_obj = array();
    
    // ==============================================
    // ALL QUERY FUNCTION FOR TB_DRAWING
    // ==============================================
    public function tb_drawing_data_insert($id_polygon, $name, $source_name = "", $layer_name = "", $link, $feature, $feature_collection){
        return $this->data_obj = array(
            'id_polygon' => $id_polygon,
            'name' => $name,
            'source_name' => $source_name,
            'layer_name' => $layer_name,
            'link' => $link,
            'feature' => $feature,
            'feature_collection' => $feature_collection,
        );
    }

    public function tb_drawing_check_name($polygon_name){
        $all_data = $this->db->get_where($this->tb_drawing, ['name' => $polygon_name])->num_rows();
        return ($all_data > 0); // true jika sudah ada polygon name di db
    }

    public function tb_drawing_get(){
        return $this->db->get($this->tb_drawing);
    }

    public function tb_drawing_get_where($where){
        return $this->db->get_where($this->tb_drawing, $where);
    }

    public function tb_drawing_save($data_object = null){
        if ($data_object == null) {
            $this->db->insert($this->tb_drawing, $this->data_obj);
        } else {
            $this->db->insert($this->tb_drawing, $data_object);
        }
        return $this->tb_drawing_get();
    }
    
    public function tb_drawing_update($data_object = null){
        if ($data_object == null) {
            $this->db->update($this->tb_drawing, $this->data_obj);
        } else {
            $this->db->update($this->tb_drawing, $data_object);
        }
        return $this->tb_drawing_get();
    }
    
    public function tb_drawing_delete($id){
        $this->db->delete($this->tb_drawing, ['id_drawing' => $id]);
        return $this->tb_drawing_get();
    }
    // ==============================================

    // ==============================================
    // ALL QUERY FUNCTION FOR TB_INFO
    // ==============================================
    public function tb_info_get_all_data($withJoin = false){
        if ($withJoin) {
            $this->db->select('tb_info.*, tb_users.*');
            $this->db->from('tb_info');
            $this->db->join('tb_users', 'tb_info.id_user = tb_users.id_user', 'left');
            $this->db->order_by('tb_info.last_updated', 'desc');
            $this->db->group_by('tb_info.latLon');
            return $this->db->get();
            
        } else {
            $this->db->order_by('last_updated', 'desc');
            return $this->db->get($this->tb_info);
        }
    }

    public function tb_info_get_data_by($where){
        $this->db->order_by('last_updated', 'desc');
        return $this->db->get_where($this->tb_info, $where);
    }
    
    public function tb_info_save($data){
        $this->db->insert($this->tb_info, $data);
        $insertId = $this->db->insert_id();
        $callback = array(
            'id_insert' => $insertId, 
            'result_all' => $this->tb_info_get_all_data()->result(),
            'result_by_id' => $this->tb_info_get_data_by(array('id_user' => $data['id_user']))->result()
        );
        return $callback;
    }

    public function tb_info_update($data_object = null){
        $this->db->update($this->tb_info, $data_object);
        return $this->tb_info_get_all_data();
    }

    public function tb_info_delete($id){
        $this->db->delete($this->tb_info, ['id_info' => $id]);
        return $this->tb_info_get_all_data();
    }
    // ==============================================
}