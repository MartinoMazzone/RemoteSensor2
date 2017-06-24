<?php
function getAmministratori(){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    $dataTemp = '';
    $query = '';
    $num = 0;
    $sql = 'SELECT * FROM amministratori';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['IdAmministratore'],
            'Nome' => $row['Nome'],
            'Cognome' => $row['Cognome'],
            'Email' => $row['Email']
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
            'messaggio' => 'Non esistono amministratori.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function addAmministratore($nome, $cognome, $email, $password1, $password2){
    require 'db.php';
    define('PASSWORDLEN', 15);
    $data = '';
    $info = '';
    $sql = '';
    $dataTemp = '';
    $query = '';
    if ($nome != ''){
        if ($cognome != ''){
            if (chkEmail($email)){
                if (strlen($password1) <= PASSWORDLEN){
                    if ($password2 === $password1){
                        $password1 = md5($password1);
                        //inizializzo la query
                        $sql = $db->prepare('SELECT * FROM amministratori WHERE Email = '.$db->quote($email));
                        // esecuzione della query 
                        $sql->execute(); 
                        $dataTemp = array();
                        if ($sql->rowCount() === 0) { //l' account non esiste
                            $sql = $db->prepare('INSERT INTO amministratori (Email, Password, Nome, Cognome) VALUES ('.$db->quote($email).', '.$db->quote($password1).', '.$db->quote($nome).', '.$db->quote($cognome).')');
                            $query = $sql->execute();
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => $sql->rowCount(),
                                'messaggio' => ''
                            );
                        }else{ //l' account è già registrata
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'error',
                                'numvalori' => '0',
                                'messaggio' => "L' email digitata non è registrata nel database."
                            );
                        }
                    }else{ //password2 non valida
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Le 2 password non combaciano.'
                        );
                    }
                }else{ //password1 non valida
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'La lunghezza della password non è valida. MAX 15 caratteri'
                    );
                }
            }else{ //email non valida
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'E-mail non valida.'
                );
            }
        }else{ //cognome non valido
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Il cognome non è valido.'
            );
        }
    }else{ //nome non valido
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Il nome non è valido.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
function modifyAmministratore($id, $nome, $cognome, $email){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    $dataTemp = '';
    $query = '';
    $id = base64_decode($id);
    if ($id > 0){
        if ($nome != ''){
            if ($cognome != ''){
                if (chkEmail($email)){
                    //inizializzo la query
                    $sql = $db->prepare('SELECT * FROM amministratori WHERE IdAmministratore = '.$db->quote($id));
                    // esecuzione della query 
                    $sql->execute(); 
                    if ($sql->rowCount() === 0) { //l' account non esiste
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Non ho trovato nessun account.'
                        );
                    }else{ //l' account è già registrata
                        $sql = $db->prepare('UPDATE amministratori SET Email = '.$db->quote($email).', Nome = '.$db->quote($nome).', Cognome = '.$db->quote($cognome).' WHERE IdAmministratore = '.$db->quote($id));
                        $query = $sql->execute();
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'success',
                            'numvalori' => '1',
                            'messaggio' => ''
                        );

                    }
                }else{ //email non valida
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'E-mail non valida.'
                    );
                }
            }else{ //cognome non valido
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'Il cognome non è valido.'
                );
            }
        }else{ //nome non valido
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Il nome non è valido.'
            );
        }
    }else{
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Modifica non abilitata.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
