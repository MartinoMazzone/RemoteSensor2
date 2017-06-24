<?php 
require 'header.php'; 
if ($id > IDNULL){
    //lo porto nella sua dashboard
    $pagina = $_SESSION['Tipo'];
    if ($pagina === 'clienti')
        header('location: clienti/dashboard.php');
    else if($pagina === 'amministratori')
        header('location: amministratori/dashboard.php');
    else if($pagina === 'persone')
        header('location: persone/dashboard.php');
    //se non è loggato
}else{
    header('location: login.php');
}
?>