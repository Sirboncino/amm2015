<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;
    
    case 'segnalazioni_aperte':
        include_once 'segnalazioni_aperte.php';
        break;
    
    case 'segnalazione_crea':
        include_once 'segnalazioni_aperte.php';
        include_once 'segnalazione_crea.php';
        break;
    
    case 'segnalazione_vedi':
        include_once 'segnalazioni_aperte.php';
        include_once 'segnalazione_vedi.php';
        break;
    
    case 'segnalazioni_ricerca':
        include_once 'segnalazioni_ricerca.php';
        break;
    
    case 'segnalazioni_ricerca_json':
        include_once 'segnalazioni_ricerca_json.php';
        break;
    
    default:
        
        ?>
        <h2 class="icon-title" id="h-home">Pannello di Controllo</h2>
        
        <p>
            Benvenuto, <strong><?= $user->getNome() ?></strong>
        </p>
        <p>
            Scegli una fra le seguenti sezioni:
        </p>
        
       
        <ul class="panel">
            <li>
                <a id="pnl-anagrafica" href="utilizzatore/anagrafica<?= $vd->scriviToken('?')?>">Anagrafica</a>
            </li>
            <li>
                <a id="pnl-segnalazioni" href="utilizzatore/segnalazioni_aperte<?= $vd->scriviToken('?')?>">Segnalazioni aperte</a>
            </li>
            <li>
                <a id="pnl-segnalazioni_ricerca" href="utilizzatore/segnalazioni_ricerca<?= $vd->scriviToken('?')?>">Ricerca segnalazioni</a>
            </li>
            
        </ul>
        <?php
        break;
}
?>

