<?php
//controllo la sessione
ini_set('error_reporting', E_ALL);
define('IDNULL', 0);
$id = 0;
$parametri = '';
$responso = '';
$pagina = '';
$url = '';
session_start();
$pagina = $_SESSION['Tipo'];
$id = $_SESSION['ID'];
if ($id <= IDNULL || $pagina != 'clienti'){
    if ($pagina === 'amministratori')
        header('location: ../amministratori/dashboard.php');
    else if($pagina === 'persone')
        header('location: ../persone/dashboard.php');
}
function getHost(){
    return 'localhost/Appy';
}
function getUrl($parametri){
    $url = 'http://'.getHost().'/php/function.php?';
    return $url.$parametri;
}
