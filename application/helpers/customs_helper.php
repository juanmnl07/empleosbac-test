<?php
function  country_dropdown($name, $id, $class, $selected_country,$top_countries=array(), $all, $selection=NULL, $show_all=TRUE ){
    // You may want to pull this from an array within the helper
    $countries = config_item('country_list');

    $html = "<select name='{$name}' id='{$id}' class='{$class}'>";
    $selected = NULL;
    if(in_array($selection,$top_countries)){
        $top_selection = $selection;
        $all_selection = NULL;
    }else{
        $top_selection = NULL;
        $all_selection = $selection;
    }
    if(!empty($selected_country)&&$selected_country!='all'&&$selected_country!='select'){
        $html .= "<optgroup label='País Seleccionado'>";
        if($selected_country === $top_selection){
            $selected = "SELECTED";
        }
        $html .= "<option value='{$selected_country}'{$selected}>{$countries[$selected_country]}</option>";
        $selected = NULL;
        $html .= "</optgroup>";
    }else if($selected_country=='all'){
        $html .= "<optgroup label='País Seleccionado'>";
        if($selected_country === $top_selection){
            $selected = "SELECTED";
        }
        $html .= "<option value='all'>Todos</option>";
        $selected = NULL;
        $html .= "</optgroup>";
    }else if($selected_country=='select'){
        $html .= "<optgroup label='País Seleccionado'>";
        if($selected_country === $top_selection){
            $selected = "SELECTED";
        }
        $html .= "<option value='select'>Seleccionar</option>";
        $selected = NULL;
        $html .= "</optgroup>";
    }
    if(!empty($all)&&$all=='all'&&$selected_country!='all'){
        $html .= "<option value='all'>Todos</option>";
        $selected = NULL;
    }
    if(!empty($all)&&$all=='select'&&$selected_country!='select'){
        $html .= "<option value='select'>Seleccionar</option>";
        $selected = NULL;
    }

    if(!empty($top_countries)){
        $html .= "<optgroup label='Top Countries'>";
        foreach($top_countries as $value){
            if(array_key_exists($value, $countries)){
                if($value === $top_selection){
                    $selected = "SELECTED";
                }
            $html .= "<option value='{$value}'{$selected}>{$countries[$value]}</option>";
            $selected = NULL;
            }
        }
        $html .= "</optgroup>";
    }

    if($show_all){
        $html .= "<optgroup label='Todos los paises'>";
        foreach($countries as $key => $country){
            if($key === $all_selection){
                $selected = "SELECTED";
            }
            $html .= "<option value='{$key}'{$selected}>{$country}</option>";
            $selected = NULL;
        }
        $html .= "</optgroup>";
    }

    $html .= "</select>";
    return $html;
    }

//get token
function islogin($session_cookie){
    $url = base_url('/rrhh/api/users/obtener-user-id');
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_POST, true);             // do a POST
    $response = curl_exec($curl);
    curl_close($curl);
    var_export($response);
    $xml = new SimpleXMLElement($response);
    return (string)$xml->token;
}


//get token
function ServicioObtenerToken($session_cookie){
    $url = base_url().'rrhh/api/users/user/token.xml';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_POST, true);             // do a POST
    $response = curl_exec($curl);
    curl_close($curl);
    $xml = new SimpleXMLElement($response);
    return (string)$xml->token;
}

//funcion para consultar servicio
function consumirServicio($url, $session_cookie, $csrf_token = ''){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
   
    curl_close($curl);
    //return $response;
    $xml = new SimpleXMLElement($response);
    return $xml;
}

function consumirServicioSinToken($url, $session_cookie = ''){
    $curl = curl_init($url);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    curl_close($curl);
    $xml = new SimpleXMLElement($response);
    return $xml;
}

function ServicioInsertar($url, $session_cookie, $post_data, $csrf_token = ''){
    $post_data = http_build_query($post_data, '', '&'); // Format post data as application/x-www-form-urlencoded
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    curl_setopt($curl, CURLOPT_POST, true);             // do a POST
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // POST this data
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    // make the request
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    curl_close($curl);
    $xml = new SimpleXMLElement($response); 
    return $xml;
}

function ServicioInsertarConPermisos($url, $session_cookie, $post_data, $csrf_token = ''){
    $post_data = http_build_query($post_data, '', '&'); // Format post data as application/x-www-form-urlencoded
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, true);             // do a POST
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // POST this data
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    // make the request
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $xml = new SimpleXMLElement($response); 
    return array($xml, $httpcode);
}

function ServicioInicioSesion($url, $post_data){
    $post_data = http_build_query($post_data, '', '&'); // Format post data as application/x-www-form-urlencoded
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    curl_setopt($curl, CURLOPT_POST, true);             // do a POST
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // POST this data
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    // make the request
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    $xml = new SimpleXMLElement(trim($response));
    return $xml;
}

function ServicioCerrarSesion($url, $session_cookie, $csrf_token = ''){
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, 1); // Do a regular HTTP POST
    curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);

    $response = curl_exec($curl);
    curl_close($curl);
    
    
    $xml = '';
    if($response == false){
        $xml = new SimpleXMLElement("<result>0</result>");
        Header('Content-type: text/xml');
    }else{
        $xml = new SimpleXMLElement($response);  
    }
    return $xml;
}

//aplicar a puesto 
function aplicarPuestoSinAjax($id_puesto, $request_url, $session_cookie){
        // REST Server URL
    $user_data = array("field_puesto" => array(
                                "und" => array(
                                    $id_puesto => $id_puesto
                                )
                            ),
                       );
    $csrf_token = ServicioObtenerToken($session_cookie);
    $result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);
    $httpcode = $result['httpcode'];
    $mensaje = $result['mensaje'];
    if($httpcode == 200){
        $data['success'] = true;
    } else {
        $data['success'] = false;
        $data['error'] = $mensaje;
        $data['code'] = $httpcode;
    }
    return $data;
}

function ServiciouploadFile($url, $session_cookie, $file, $csrf_token){
    $header = array('Content-Type: multipart/form-data', 'X-CSRF-Token: ' .$csrf_token);
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, 1); // Do a regular HTTP POST
    curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_POSTFIELDS, $file); // POST this data
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    // make the request
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    curl_close($curl);
    $xml = new SimpleXMLElement($response);
    return $xml;
}

function ServicioActualizar($url, $user_data, $session_cookie, $csrf_token){
    $csrf_header = 'X-CSRF-Token: ' . $csrf_token;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json',
        'Content-type: application/json',$csrf_header)); // Accept JSON response
    curl_setopt($curl, CURLOPT_PUT, TRUE);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user_data)); // Set POST data
    curl_setopt($curl, CURLOPT_HEADER, TRUE); // FALSE);  // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    // Emulate file.
    $serialize_args = json_encode($user_data);
        $putData = fopen('php://temp', 'rw+');
        fwrite($putData, $serialize_args);
        fseek($putData, 0);
    curl_setopt($curl, CURLOPT_INFILE, $putData);
    curl_setopt($curl, CURLOPT_INFILESIZE, strlen($serialize_args));
    $response = curl_exec($curl);    
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return array('mensaje' => $response, 'httpcode' => $httpcode);
}

function traducirMes($fecha){
    $nmeng = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
    $nmesp = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre', 'octubre', 'noviembre', 'diciembre',);
    $dt = str_ireplace($nmeng, $nmesp, $fecha);
    return $dt;
}

function consultarEstadoAplicante($uid_aplicante, $nid_puesto, $session_cookie){
    $estados_bitacora_listado = base_url().'rrhh/api/users/puestos_aplicados_bitacora/retrieve?uid_aplicante=' . $uid_aplicante . '&nid_puesto=' . $nid_puesto . '.xml';
    $listado = consumirServicioSinToken($estados_bitacora_listado, $session_cookie);
    return $listado;
}

function reiniciarEstadoAplicante($uid_aplicante, $nid_puesto, $session_cookie){
    $estados_bitacora_listado = base_url().'rrhh/api/users/reiniciar_estado/retrieve?idAplicante=' . $uid_aplicante . '&idPuesto=' . $nid_puesto . '.xml';
    $listado = consumirServicioSinToken($estados_bitacora_listado, $session_cookie);
    return $listado;
}

function obtenerPaginacion($paginas_totales, $pagina_actual, $valor_inicial, $url_pagina, $parametros = "" , $class_ul_paginacion = ""){
    $html_paginas = "";

    if ($paginas_totales>0){
        if($pagina_actual>0){
            if($parametros!=""){
                $html_paginas .= '<li><a href="'.$url_pagina.'?'.$parametros.'">&laquo;</a></li>';  
            }else{
                $html_paginas .= '<li><a href="'.$url_pagina.'">&laquo;</a></li>'; 
            }
               
        }
        
        $paginas_por_mostrar=5;

        if($paginas_totales<=$paginas_por_mostrar){
            $paginas_por_mostrar=$paginas_totales+1;
            $valor_inicial=0;
        }

        if($pagina_actual==0){
            $valor_inicial=$pagina_actual;
        }

        if($pagina_actual==1){
            $valor_inicial=($pagina_actual-1);
        }

        for($i=$valor_inicial;$i<($paginas_por_mostrar+$valor_inicial);$i++){
            $clase_current_page = '';
            if($i==$pagina_actual)
                $clase_current_page = 'class="current-page"';
            if($i <= $paginas_totales){

                if($i==0){
                    if($parametros!=""){
                        $html_paginas .= '<li '.$clase_current_page.'><a href="'.$url_pagina."?".$parametros.'">'.($i+1).'</a></li>';
                    }else{
                        $html_paginas .= '<li '.$clase_current_page.'><a href="'.$url_pagina.'">'.($i+1).'</a></li>';
                    }
                    
                }else{
                    if($parametros!=""){
                        $html_paginas .= '<li '.$clase_current_page.'><a href="'.$url_pagina.'?'.$parametros.'&pagina='.($i+1).'">'.($i+1).'</a></li>';
                    }else{
                        $html_paginas .= '<li '.$clase_current_page.'><a href="'.$url_pagina.'?pagina='.($i+1).'">'.($i+1).'</a></li>';
                    }
                    
                }                                           
            }
        }

        if($pagina_actual<$paginas_totales){
            if($parametros!=""){
                $html_paginas .= '<li><a href="'.$url_pagina.'?'.$parametros.'&pagina='.($paginas_totales+1).'">&raquo;</a></li>';
            }else{
                $html_paginas .= '<li><a href="'.$url_pagina.'?pagina='.($paginas_totales+1).'">&raquo;</a></li>';
            }
            
        }
        
        
      $html_paginas = '<ul class="paginacion '.$class_ul_paginacion.'">'.$html_paginas.'</ul>';

    }


    return $html_paginas;
            
}


//get token
function CerrarSessionDrupal(){
    $url = base_url().'rrhh/user/logout';
    $curl = curl_init($url);    
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function ServicioCrearPuesto($url, $session_cookie, $post_data, $csrf_token = ''){
    $post_data = http_build_query($post_data, '', '&'); // Format post data as application/x-www-form-urlencoded
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, true);             // do a POST
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // POST this data
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    // make the request
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    //$xml = new SimpleXMLElement($response);
    return array($response, $httpcode);
}

function ServicioGuardarArchivo($url, $session_cookie, $file, $csrf_token){
    $header = array('Content-Type: multipart/form-data', 'X-CSRF-Token: ' .$csrf_token);
    // set up the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // have curl_exec return a string
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, 1); // Do a regular HTTP POST
    curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_POSTFIELDS, $file); // POST this data
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    // make the request
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    //$xml = new SimpleXMLElement($response);
    return array($response, $httpcode);
}

function ObtenerListado($entidad, $url, $session_cookie, $csrf_token, $taxnonomy=true){
    $service_url = base_url('/rrhh/api/'.$entidad.'/'.$url.'.xml'); // .xml asks for xml data 

    // set up the request
    $curl = curl_init($service_url);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
    //curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
    $response = curl_exec($curl);

    curl_close($curl);
    $xml = new SimpleXMLElement($response);
    if($taxnonomy){
        return ProcesarListadoTaxonomia($xml);
    } else {
        return ProcesarListadoEntidades($xml);
    }
}

function ProcesarListadoTaxonomia($xml){
    $data = array();
    //$data['response'] = $xml->results->item[0]->name;
    foreach ($xml->results->item as $key) {
        $data[(string)$key[0]->tid] = (string)$key[0]->name;
    }
    return $data; 
}

function ProcesarListadoEntidades($xml){
    $data = array();
    //$data['response'] = $xml->results->item[0]->name;
    foreach ($xml->results->item as $key) {
        $data[(string)$key->nid] = (string)$key->title;
    }
    //exit(var_dump($data));
    return $data; 
}