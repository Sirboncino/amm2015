<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;

    case 'segnalazioni_nuove':
        include_once 'segnalazioni_nuove.php';
        break;
    
    case 'segnalazione_prendi':
        include_once 'segnalazioni_nuove.php';
        include_once 'segnalazione_prendi.php';
        break;
    
    case 'segnalazioni_aperte':
        include_once 'segnalazioni_aperte.php';
        break;
    
    case 'segnalazione_modifica':
        include_once 'segnalazioni_aperte.php';
        include_once 'segnalazione_modifica.php';
        break;
    
    case 'segnalazioni_ricerca':
        include_once 'segnalazioni_ricerca.php';
        break;
    
    case 'segnalazioni_trovate':
        include_once 'segnalazioni_ricerca.php';
        include_once 'segnalazioni_trovate.php';
        break;
    
    case 'segnalazione_vedi':
        include_once 'segnalazioni_ricerca.php';
        include_once 'segnalazione_vedi.php';
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
                <a id="pnl-anagrafica" href="operatore/anagrafica<?= $vd->scriviToken('?')?>">Anagrafica</a>
            </li>
            <li>
                <a id="pnl-segnalazioni" href="operatore/segnalazioni_nuove<?= $vd->scriviToken('?')?>">Nuove segnalazioni</a>
            </li>
            <li>
                <a id="pnl-segnalazioni" href="operatore/segnalazioni_aperte<?= $vd->scriviToken('?')?>">Segnalazioni aperte</a>
            </li>
            <li>
                <a id="pnl-segnalazioni_ricerca" href="operatore/segnalazioni_ricerca<?= $vd->scriviToken('?')?>">Ricerca segnalazioni</a>
            </li>
            
        </ul>
        <?php
        break;
}
?>


