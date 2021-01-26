<?php

function debug ($element) {
	echo '<pre>'; 
	print_r($element); 
	echo '</pre>';
	exit;
}

function GeraSelect($CampoNome, $OpcaoCod, $OpcaoNome, $OpcaoSelecionada, $Query) {
    $GeraSelect = '<select class="form-control" name="' . $CampoNome . '" id="' . $CampoNome . '">';
    
    if ($OpcaoSelecionada == 0) {
        $GeraSelect .= '<option value="" selected="selected">Selecione uma opção</option>';
    } else {
        $GeraSelect .= '<option value="">Selecione uma opção</option>';
    }
    
    $ci=& get_instance();
    $ci->load->database(); 
     
    $query = $ci->db->query($Query);
    $row = $query->result();
    foreach($row as $linha => $linhaForm) {
        if ($linhaForm->{$OpcaoCod} == $OpcaoSelecionada) {
            $GeraSelect .= '<option selected="selected" value="' . $linhaForm->{$OpcaoCod} . '">' . $linhaForm->{$OpcaoNome} . '</option>';
        } else {
            $GeraSelect .= '<option value="' . $linhaForm->{$OpcaoCod} . '">' . $linhaForm->{$OpcaoNome} . '</option>';
        }
    }
    
    $GeraSelect .= '</select>';
    
    return $GeraSelect;
}

/* Conversão de Datas */
function converteData($data){
    if (strstr($data, "/")){
        $d = explode ("/", $data);
        $rstData = "$d[2]-$d[1]-$d[0]";
        return $rstData;
    } else if(strstr($data, "-")) {
        $data = substr($data, 0, 10);
        $d = explode ("-", $data);
        $rstData = "$d[2]/$d[1]/$d[0]";
        return $rstData;
    }
    else{
        return null;
    }
}

function forceSsl() {
$whitelist = array('127.0.0.1', "::1");
if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) { 
    if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        redirect($url);
        exit;
    }
}
}

function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++) {
        if($mask[$i] == '#') {
            if(isset($val[$k]))
            $maskared .= $val[$k++];
        } else {
            if(isset($mask[$i]))
            $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function check_diff($array1, $array2){
    $result = array();
    foreach($array1 as $key => $val) {
         if(isset($array2[$key])){
           if(is_array($val) && $array2[$key]){
               $result[$key] = check_diff($val, $array2[$key]);
           }
       } else {
           $result[$key] = $val;
       }
    }

    return $result;
}