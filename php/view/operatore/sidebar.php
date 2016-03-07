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
    case 'segnalazioni_nuove': ?>
        <p>
            In questa sezioni puoi:
        </p>
        <ul>
            <li>
                visualizzare le <strong>Segnalazioni</strong> fatte dagli Utenti
                Utilizzatori e non ancora prese in carico per la gestione da 
                nessun Operatore.
            </li>
            <li>
                visualizzare il <strong>dettaglio</strong> di ogni singola Segnalazione 
                e decidere di <strong>prenderla in carico</strong>.    
            </li>
        </ul>
    <?php break; ?>
        
    <?php 
    case 'segnalazione_prendi': ?>
        <p>
            In questa sezione puoi visualizzare il dettaglio della nuova 
            segnalazione:
        </p>
        <ul>
            <li>
                Il <strong>codice</strong> del ticket assegnato dal sistema.
            </li>
            <li>
                Il <strong>cognome</strong> e il <strong>nome</strong> dell'utente che ha fatto la segnalazione 
                e il suo <strong>servizio</strong> di riferimento.
            </li>
            <li>
                La <strong>data</strong> e l'<strong>ora</strong> di inserimento.
            </li>
            <li>
                La <strong>categoria</strong> e la <strong>priorit&agrave;</strong> assegnate dall'utente.
            </li>
            <li>
                L'<strong>oggetto</strong> e la <strong>descrizione</strong> della segnalazione.
            </li>
        </ul>
        <p>
            Puoi decidere di prenderne in carico la gestione di questa 
            segnalazione clicando sul tasto <strong>Prendi in gestione</strong>.
        </p>
    <?php break; ?>
        
    <?php 
    case 'segnalazioni_aperte': ?>
        <p>
            In questa sezioni puoi:
        </p>
        <ul>
            <li>
                visualizzare le <strong>Segnalazioni aperte</strong> che stai gestendo.
            </li>
            <li>
                visualizzare il <strong>dettaglio</strong> di ogni singola Segnalazione, 
                fare le opportune <strong>modifiche</strong> o decidere di <strong>chiuderla</strong>.    
            </li>
        </ul>
        <?php break; ?>

    <?php 
    case 'segnalazione_modifica': ?>
        <p>
            In questa sezione puoi visualizzare il dettaglio delle segnalazioni aperte:
        </p>
        <ul>
            <li>
                Il <strong>codice</strong> del ticket assegnato dal sistema.
            </li>
            <li>
                Il <strong>cognome</strong> e il <strong>nome</strong> dell'utente che ha fatto la segnalazione 
                e il suo <strong>servizio</strong> di riferimento.
            </li>
            <li>
                La <strong>data</strong> e l'<strong>ora</strong> di inserimento e dell'ultima modifica.
            </li>
            <li>
                La <strong>categoria</strong> e la <strong>priorit&agrave;</strong> assegnate dall'utente.
            </li>
            <li>
                Lo <strong>stato attuale</strong>.
            </li>
            <li>
                L'<strong>oggetto</strong> e la <strong>descrizione</strong> della segnalazione.
            </li>
        </ul>
        <p>
            Puoi modificare e gestire la Segnalazione:
        </p>
        <ul>
            <li>
                Modificare la <strong>categoria</strong> assegnata dall'Utente utilizzatore.
            </li>
            <li>
                Modificare la <strong>priorit&agrave;</strong> assegnata dall'Utente utilizzatore.
            </li>
            <li>
                Inserire le <strong>note</strong> di gestione.
            </li>
        </ul>
        <p>
            Puoi decidere di considerare conclusa la gestione di questa 
            segnalazione clicando sul tasto <strong>Chiudi segnalazione</strong>.
        </p>
    <?php break; ?>        
        
    <?php 
    case 'segnalazioni_ricerca':
    case 'segnalazioni_trovate': 
    case 'segnalazione_vedi': ?>
        <p>
            In questa sezione puoi visualizzare lo storico delle segnalazioni da te gestite. 
            &Egrave; possibile filtrarle per <strong>categoria</strong>, per 
            <strong>priorit&agrave;</strong>, per <strong>stato</strong> e per 
            contenuto dell'<strong>oggetto</strong>.
        </p>
        
         <p>
            Puoi anche visualizzare il <strong>dettaglio</strong> di ogni singola Segnalazione.
        </p>
    
    <?php break; ?>        

        
    <?php default: ?>
        <p>
            Seleziona una delle seguenti funzionalit&agrave; disponibili per 
            la gestione delle segnalazioni degli utenti del sistema:
        </p>
        <ul>
            <li>
                <strong>Anagrafica</strong> per modificare i tuoi dati 
                anagrafici e la tua password.
            </li>
            <li>
                <strong>Nuove segnalazioni</strong> per visualizzare e prendere
                in carico le nuove segnalazioni, non ancora gestite, inserite 
                dagli utenti Utilizzatori del sistema.
            </li>
            <li>
                <strong>Segnalazioni aperte</strong> per visualizzare e modificare 
                le segnalazioni prese in carico ancora aperte.
            </li>
            <li>
                <strong>Ricerca segnalazioni</strong> per cercare e filtrare le 
                segnalazioni da te gestite.
            </li>
        </ul>
    <?php break; ?>
<?php } ?>