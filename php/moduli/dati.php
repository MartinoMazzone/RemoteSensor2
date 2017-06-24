<?php
function getDati($idcliente){
    require 'db.php';
    $sql = '';
    $num = 0;
    $data = '';
    $info = '';
    $sql = 'SELECT * FROM siti, apparecchiature, dati WHERE dati.COD_Apparecchiatura = apparecchiature.Matricola AND apparecchiature.COD_Sito = siti.IdSito AND siti.COD_Cliente = '.$db->quote($idcliente).' AND siti.Stato = "0" ORDER BY dati.IdDato DESC';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['IdDato'],
            'DatiRilevati' => $row['DatiRilevati'],
            'Data' => $row['DataRilevazione'],
            'Ora' => $row['OraRilevazione'],
            'Errore' => $row['Errore'],
            'Apparecchiatura' => $row['COD_Apparecchiatura'],
            'Sito' => $row['IdSito'],
            'Marca' => $row['Marca'],
            'Posizione' => $row['Posizione'],
            'Tipologia' => $row['Tipologia']
        );
        $num++;
    }
    //creo l' array con i dati se num > 0
    if ($num > 0){
        $data[] = array(
            'status' => 'success',
            'numvalori' => $num,
            'messaggio' => ''
        );
    }else{
        $data[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Non esistono dati relativi a questo ambiente.'
        );
    }
    // visualizzazione dei risultati 
    return base64_encode('{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}'); 
}
