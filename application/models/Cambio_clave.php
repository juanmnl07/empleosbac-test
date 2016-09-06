<?php
class Cambio_clave extends CI_Model {

    var $u_email = '';
    var $fecha    = '';
    var $token    = '';
    var $table = 'cambio_clave';

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

    function buscarUsuario($token){
        $this->db->select('*');
        $this->db->where('token', $token);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function insert_entry($postdata)
    {   

        $data = array(
                'u_email' => $postdata['u_email'],
                'fecha' => time(),
                'token' => $postdata['token'],
        );
        return $this->db->insert($this->table, $data);
    }

    function delete($token)
    {
        $this->db->delete($this->table, array('token' => $token));
    }

}
