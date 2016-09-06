<?php
class Bitacora_aplicante extends CI_Model {

    var $u_email = '';
    var $fecha    = '';
    var $token    = '';
    var $table = 'bitacora_aplicante';

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
        //$this->db->join('field_data_field_puesto', 'field_data_field_puesto.field_puesto_target_id = '. $table .'.nid_puesto');
        $this->db->join('field_data_field_puesto', 'field_data_field_puesto.field_puesto_target_id = bitacora_aplicante.nid_puesto', 'left');
        $this->db->where('uid_aplicante', $uid_aplicante);
        $this->db->order_by('nid_puesto', 'asc');
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
