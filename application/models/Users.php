<?php
class Users extends CI_Model {

    var $table = 'users';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function load($uid){
        $this->db->select('*');
        $this->db->where('uid', $uid);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}