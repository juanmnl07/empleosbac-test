<?php
class Node extends CI_Model {

    var $table = 'node';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function load($nid){
        $this->db->select('*');
        $this->db->where('nid', $nid);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}