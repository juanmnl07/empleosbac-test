<?php
class Field_data_field_fecha_de_cierre_de_oferta extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function get($entity_id)
    {
        //exit(var_dump($entity_id));
        $this->db->select('field_fecha_de_cierre_de_oferta_value');
        $this->db->from('field_data_field_fecha_de_cierre_de_oferta');
        $this->db->where('entity_id', $entity_id); 
        return $this->db->get();
    }
}