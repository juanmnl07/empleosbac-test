<?php
class Aplicante_estado extends CI_Model {

    var $table = 'aplicante_estado';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function agregar($data){
        return $this->db->insert($this->table, $data);
    }
}