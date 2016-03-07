<?php

$json = array();
$json['errori'] = $errori;
$json['segnalazioni_trovate'] = array();
 

foreach($segnalazioni_trovate as $segnalazione_trovata){
     // @var $segnalazione Segnalazione 
    $element = array();
    $element['data_creazione'] = $segnalazione_trovata->getDataCreazione()->format('d/m/Y');
    $element['numero'] = $segnalazione_trovata->getNumero();
    $element['status'] = $segnalazione_trovata->getStatus();
    $element['data_status'] = $segnalazione_trovata->getDataStatus()->format('d/m/Y');
    $element['categoria'] = $segnalazione_trovata->getCategoria()->getNome();
    $element['oggetto'] = $segnalazione_trovata->getOggetto();
  
    $json['segnalazioni_trovate'][] = $element;
    
}

echo json_encode($json);
?>
