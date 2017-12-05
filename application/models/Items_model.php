<?php
class Items_model extends base_model {
    function __construct()
    {
        parent::__construct();
        $this->table_name = 'items';
        $this->primary_key = 'item_id';
    }
    function get_all($where = array(), $select = "*", $limit = 0, $order_by = '', $group_by = ''){
      $this->db->select($select . ", items.item_id as item_id");
      $this->db->join('storage_spaces', 'storage_spaces.storage_id = items.storage_id', 'left');
      if(empty($order_by)){
        $this->db->order_by('storage_prefix ASC, storage_number ASC, items.item_id ASC');
      }
      $query = $this->db->get_where($this->table_name, $where);
      $items = $query->result_array();
      for($i = 0; $i < sizeof($items); $i++){
        $photos = $this->photos_model->get_all(array('item_id' => $items[$i]['item_id']));
        $items[$i]['photos'] = $photos;
      }
      return $items;
    }
}