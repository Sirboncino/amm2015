<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;

    case 'gestione_operatori':
        include_once 'gestione_operatori.php';
        break;

    case 'gestione_utilizzatori':
        include_once 'gestione_utilizzatori.php';
        break;
    
    case 'operatore_crea':
        include_once 'gestione_operatori.php';
        include_once 'operatore_crea.php';
        break;
        
    case 'operatore_modifica':
        include_once 'gestione_operatori.php';
        include_once 'operatore_modifica.php';
        break;
    
    case 'utilizzatore_crea':
        include_once 'gestione_utilizzatori.php';
        include_once 'utilizzatore_crea.php';
        break;
        
    case 'utilizzatore_modifica':
        include_once 'gestione_utilizzatori.php';
        include_once 'utilizzatore_modifica.php';
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
                <a id="pnl-anagrafica" href="amministratore/anagrafica<?= $vd->scriviToken('?')?>">Anagrafica</a>
            </li>
            <li>
                <a id="pnl-utenti" href="amministratore/gestione_operatori<?= $vd->scriviToken('?')?>">Gestione Operatori</a>
            </li>
            <li>
                <a id="pnl-utenti" href="amministratore/gestione_utilizzatori<?= $vd->scriviToken('?')?>">Gestione Utilizzatori</a>
            </li>
        </ul>
        <?php
        break;
}
?>


