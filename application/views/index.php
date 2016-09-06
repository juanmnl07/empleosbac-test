<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$isAdminSide = false;
if($this->session->userdata('isAdmin') == true){
	$isAdminSide = true;
	$info_admin = array('name'=>$this->session->userdata('nombre'));
	$user_role = $this->session->userdata('user_role');
	$user_principal = $this->session->userdata('user_principal');
}

if(!isset($vista))
	$vista = 'inicio';

require_once 'header.php';



$file = dirname(__FILE__) . '/' . $vista . '.php';

if(file_exists($file))
	require_once $vista . '.php';
else
	echo '<p>La vista <b>(' . $file . ')</b> no fue encontrada</p>';

require_once 'footer.php';