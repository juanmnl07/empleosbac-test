<?php
class field_data_field_puesto extends CI_Model {

    var $u_email = '';
    var $fecha    = '';
    var $token    = '';
    var $table = 'field_data_field_puesto';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function getInfo()
    {
        return null;
    }

    function obtenerAplicaciones($uid_aplicante){
        $this->db->select('*');
        $this->db->join('bitacora_aplicante', 'bitacora_aplicante.nid_puesto = field_data_field_puesto.field_puesto_target_id');
        $this->db->where('entity_id', $uid_aplicante);
        $this->db->order_by('field_data_field_puesto.field_puesto_target_id', 'asc');
        $this->db->order_by('bitacora_aplicante.fecha', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function insert_entry($postdata)
    {   

        /*$data = array(
                'u_email' => $postdata['u_email'],
                'fecha' => time(),
                'token' => $postdata['token'],
        );
        return $this->db->insert($this->table, $data);*/
    }

    function delete($token)
    {
        //$this->db->delete($this->table, array('token' => $token));
    }

}
