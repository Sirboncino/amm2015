<h2 class="icon-title" id="h-help">Istruzioni</h2>
<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica': ?>
        <p>
            In questa sezione puoi modificare i tuoi dati personali.
        </p>
        <ul>
            <li>
                I tuoi <strong>contatti</strong>: <br>
                - Indirizzo <strong>email</strong>.<br> 
                - Numero di <strong>telefono </strong>fisso. <br> 
                - Numero di <strong>cellulare</strong>.
            </li>
            <li>
                La tua <strong>password</strong>.
            </li>
        </ul>
    <?php break; ?>       

    <?php 
    case 'gestione_operatori':
    case 'operatore_modifica':
    case 'operatore_crea': ?>
        <p>
            In questa sezioni puoi:
        </p>
        <ul>
            <li>
                visualizzare gli <strong>Operatori</strong> che rispondono alle segnalazioni 
                che gli Utenti Utilizzatori inviano al sistema.
            </li>
            <li>
                visualizzare il <strong>dettaglio</strong> di ogni singolo Operatore
                e <strong>modificarne</strong> gli attributi.  
            </li>
            <li>
                creare un <strong>nuovo Operatore</strong>.
            </li>
        </ul>
    <?php break; ?>

    
    <?php
    case 'gestione_utilizzatori': 
    case 'utilizzatore_modifica':
    case 'utilizzatore_crea': ?>
        <p>
            In questa sezioni puoi:
        </p>
        <ul>
            <li>
                visualizzare gli <strong>Utilizzatori</strong> che inviano le segnalazioni al sistema.
            </li>
            <li>
                visualizzare il <strong>dettaglio</strong> di ogni singolo Utilizzatore
                e <strong>modificarne</strong> gli attributi.  
            </li>
            <li>
                creare un <strong>nuovo Utilizzatore</strong>.
            </li>
        </ul>
    <?php break; ?>
    
        
    <?php default: ?>
        <p>
            Seleziona una delle seguenti funzionalit&agrave; disponibili per 
            la gestione degli utenti del sistema:
        </p>
        <ul>
            <li>
                <strong>Anagrafica</strong> per modificare i tuoi dati 
                anagrafici e la tua password.
            </li>
            <li>
                <strong>Gestione Operatori</strong> per visualizzare, modificare 
                e inserire nuovi Operatori che rispondono alle segnalazioni che  
                gli Utenti Utilizzatori inviano al sistema.
            </li>
            <li>
                <strong>Gestione Utilizzatori</strong> per visualizzare, modificare 
                e inserire nuovi Utenti Utilizzatori abilitati ad inviare 
                segnalazioni al sistema.
            </li>
        </ul>
    <?php break; ?>
<?php } ?>