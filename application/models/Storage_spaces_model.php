<?php
class Storage_spaces_model extends base_model {
    function __construct()
    {
        parent::__construct();
        $this->table_name = 'storage_spaces';
        $this->primary_key = 'storage_id';
    }
}