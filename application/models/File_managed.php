<?php
class File_managed extends CI_Model {

    var $uri   = '';
    var $filename = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function modificar($fid, $filename)
    {
        $this->filename = $filename;
        $this->uri = 'public://uploads/'.$filename;
        return $this->db->update('file_managed', $this, array('fid' => $fid));
    }
}