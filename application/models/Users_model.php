<?php
class Users_model extends base_model {
    function __construct()
    {
        parent::__construct();
        $this->table_name = 'users';
        $this->primary_key = 'user_id';
    }
}