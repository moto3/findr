<?php
class Items_model extends base_model {
    function __construct()
    {
        parent::__construct();
        $this->table_name = 'items';
        $this->primary_key = 'user_id';
    }
    function get_all($where = array(), $select = "*", $limit = 0, $order_by = '', $group_by = ''){
    	$ret = array();
        $this->db->select($select . ", items.item_id as item_id");
        $this->db->join('storage_spaces', 'storage_spaces.storage_id = items.storage_id');
        $this->db->join('photos', 'items.item_id = photos.item_id', 'left');
        $this->db->order_by('items.item_id ASC');
        $query = $this->db->get_where($this->table_name, $where);

        $item_ids = array();
        if ($query->num_rows() > 0){
            foreach($query->result_array() as $row){
                if(!in_array($row['item_id'], $item_ids)){
                    $ret[] = $row;
                }
                $item_ids[] = $row['item_id'];
            }
        }
        return $ret;
    }
}