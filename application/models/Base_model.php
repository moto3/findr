<?php
class base_model extends CI_Model {

    public $table_name = '';
    public $primary_key = 'id';
    function __construct()
    {
    }
    function get($where = array(), $select = "*"){
        $query = $this->db->select($select);
        $query = $this->db->get_where($this->table_name, $where, 1);
        if ($query->num_rows()){
            foreach($query->result_array() as $row){
                return $row;
            }
        }
        return false;
    }
    function get_all($where = array(), $select = "*", $limit = 0, $order_by = '', $group_by = ''){
        $this->db->select($select);
        if($limit){
            $this->db->limit($limit);
        }
        if(!empty($order_by)){
            $this->db->order_by($order_by);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        $query = $this->db->get_where($this->table_name, $where);
        return $query->result_array();
    }
    function get_where_in($column_name, $where = array()){
        $this->db->where_in($column_name, $where);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }
    function get_by_id($id, $select = "*"){
        return $this->get(array($this->primary_key=>$id), $select);
    }
    function delete_by_id($id){
        return $this->delete(array($this->primary_key=>$id), $select);
    }
    function get_name($id, $select = "name"){
        $data = $this->get_by_id($id, $select);
        return $data->$select;
    }
    function get_fields(){
        $fields = $this->db->list_fields($this->table_name);
        $ret = (object) array();
        foreach($fields as $field){
            $ret->{$field} = '';
        }
        return $ret;
    }
    function filter($filter_column, $terms = '', $select = '*', $limit = 0){
        $this->db->select($select);
        if($limit){
            $this->db->limit($limit);
        }
        $terms = explode("%20", $terms);
        foreach($terms as $term){
            if(!empty($term)){
                $this->db->like($filter_column, $term);
            }
        }
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0){
            foreach($query->result() as $row){
                $ret[] = $row;
            }
        }
        return $ret;
    }
    function search($term, $search_columns = array('name'), $select = '*'){
        $term = explode(" ", $term);
        for($i = 0; $i < sizeof($term); $i++){
            foreach($search_columns as $search_column){
                $this->db->or_like($search_column, $term[$i]);
            }
        }
        $this->db->select($select);
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function insert($insert_data = array()){
        $this->db->insert($this->table_name, $insert_data);
        return $this->db->insert_id();
    }
    function insert_batch($insert_data = array()){
        $this->db->insert_batch($this->table_name, $insert_data);
        return $this->db->insert_id();
    }
    function update($update_data = array(), $where){
        $this->db->where($where);
        $this->db->update($this->table_name, $update_data);
        return true;
    }
    function delete($where = array()){
        $this->db->delete($this->table_name, $where); 
    }

    function get_edit_data($id, $select = "*"){
        if($id == 0){
            $ret = $this->get_fields();
        }else{
            $ret = $this->get_by_id($id, $select);
        }
        return $ret;
    }
    function save($data = array()){
        if(isset($data[$this->primary_key])){
            $primary_key = $data[$this->primary_key];
            unset($data[$this->primary_key]);
            if($primary_key == 0){
                return $this->insert($data);
            }else{
                $this->update($data, array($this->primary_key => $primary_key));
                return $primary_key;
            }
        }else{
            exit();
        }
    }

    function form_select($label_key, $value = 0, $name = '', $where = array(), $select = "*", $limit = 0, $order_by = '', $default_label = 'select'){
        if($name == ''){
            $name = $this->primary_key;
        }
        $ret = '<select name="' . $name . '">';
        $data = $this->get_all($where, $select, $limit, $order_by);
        $ret .= '<option value="0">' . $default_label . '</option>';
        foreach($data as $row){
            $ret .= '<option value="' . $row->{$this->primary_key} . '"';
            if($row->{$this->primary_key} == $value){
                $ret .= ' SELECTED="SELECTED"';
            }
            $ret .='>' . $row->{$label_key} . '</option>';
        }
        $ret .= '</select>';
        return $ret;
    }
    function form_checkbox($label_key, $value){
        $data = $this->get_all();
        $ret = '';
        foreach($data as $row){
            $ret .= '<input type="checkbox" name="' . $this->primary_key . '[]" value="' . $row->{$this->primary_key} . '"';
            if(in_array($row->{$this->primary_key}, $value)){
                $ret .= ' CHECKED="CHEKCED"';
            }
            $ret .='>' . $row->{$label_key};
        }
        return $ret;
    }
    function form_yes_no($label_key, $value){
        $ret = '<input type="radio" name="' . $label_key . '" id="' . $label_key . '_yes" value="1"';
        if($value){
            $ret .= ' CHECKED="CHEKCED"';
        }
        $ret .='> <label for="' . $label_key . '_yes" class="inline">Yes</label> | ';
        $ret .= '<input type="radio" name="' . $label_key . '" id="' . $label_key . '_no" value="0"';
        if(!$value){
            $ret .= ' CHECKED="CHEKCED"';
        }
        $ret .='> <label for="' . $label_key . '_no" class="inline">No</label>';
        return $ret;
    }

    
}