<?php
class Photos_model extends base_model {
    function __construct()
    {
        parent::__construct();
        $this->table_name = 'photos';
        $this->primary_key = 'photo_id';
    }
}