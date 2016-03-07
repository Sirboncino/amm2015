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
    case 'segnalazioni_aperte': ?>
        <p>
            In questa sezione puoi visualizzare le tue segnalazioni che hanno 
            lo stato: <strong>Aperta</strong>.<br>
            Per ogni segnalazione aperta nella tabella sono riportati:
        </p>
        <ul>
            <li>
                la data di inserimento.
            </li>
            <li>
                il nummero assegnato.
            </li>
            <li>
                lo stato.
            </li>
            <li>
                la tipologia.
            </li>
            <li>
                l'oggetto.
            </li>
            <li>
                l'icona che, se cliccata, fa visualizzare 
                altri <strong>dettagli</strong>.
            </li>
        </ul>
        
        <p>
            &Egrave; possibile creare una <strong>nuova segnalazione</strong> 
            cliccando sull'apposito bottone.
        </p>
    <?php break; ?>
        
    <?php 
    case 'segnalazione_vedi': ?>
        <p>
            In questa sezione puoi visualizzare il dettaglio delle segnalazioni aperte:
        </p>
        <ul>
            <li>
                Il <strong>codice</strong> del ticket assegnato dal sistema.
            </li>
            <li>
                La <strong>data</strong> e l'<strong>ora</strong> di inserimento e dell'ultima modifica.
            </li>
            <li>
                La <strong>categoria</strong> e la <strong>priorit&agrave;</strong>.
            </li>
            <li>
                Lo <strong>stato attuale</strong>.
            </li>
            <li>
                L'<strong>operatore</strong> che ha in gestione la Segnalazione.
            </li>
            <li>
                L'<strong>oggetto</strong> e la <strong>descrizione</strong> della segnalazione.
            </li>
            <li>
                Le <strong>note</strong> dell'Operatore che ha in gestione la Segnalazione.
            </li>
        </ul>
    <?php break; ?>        
         
    <?php 
    case 'segnalazione_crea': ?>
        <p>
            In questa sezione puoi creare una nuova Segnalazione inserendo:
        </p>
        <ul>
            <li>
                La <strong>categoria</strong>.
            </li>
            <li>
                La <strong>priorit&agrave;</strong>.
            </li>
            <li>
                L'<strong>oggetto</strong>.
            </li>
            <li>
                La <strong>descrizione</strong> sintetica.
            </li>
        </ul>
    <?php break; ?>        
               
    <?php 
    case 'segnalazioni_ricerca': ?>
        <p>
            In questa sezione puoi visualizzare lo storico delle segnalazioni da te inserite. 
            &Egrave; possibile filtrarle per <strong>categoria</strong>, per 
            <strong>priorit&agrave;</strong>, per <strong>stato</strong> e per 
            contenuto dell'<strong>oggetto</strong>.
        </p>
    <?php break; ?>        

        
    <?php default: ?>
        <p>
            Seleziona una delle seguenti funzionalit&agrave; disponibili per 
            la gestione delle tue segnalazioni:
        </p>
        <ul>
            <li>
                <strong>Anagrafica</strong> per modificare i tuoi dati 
                anagrafici e la tua password.
            </li>
            <li>
                <strong>Segnalazioni aperte</strong> per visualizzare lo stato 
                delle tue segnalazioni aperte gi&agrave; inserite e inserire 
                nuove segnalazioni.
            </li>
            <li>
                <strong>Ricerca segnalazioni</strong> per cercare e filtrare le 
                tue segnalazioni inserite.
            </li>
        </ul>
    <?php break; ?>
<?php } ?>