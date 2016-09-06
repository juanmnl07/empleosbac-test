<?php 
    $request_url = base_url().'/rrhh/api/users/user/'. $this->session->userdata('user_id');
    $session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
    $respuesta = aplicarPuestoSinAjax($this->uri->segment(3), $request_url, $session_cookie);
    if($respuesta['success'] != true){
      echo $respuesta['error'];
    } 
?>