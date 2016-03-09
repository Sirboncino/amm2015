<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>

<body>
    <h1>Accesso all'applicazione del progetto</h1>
    <p>
        Si può scaricare il codice facendo un git clone 
        al seguente indirizzo 
        <a href="https://github.com/Sirboncino/amm2015">https://github.com/Sirboncino/amm2015</a>
    </p>

    <h2>Descrizione dell'applicazione</h2>
    <p>
        L’applicazione offre supporto al servizio helpdesk (assistenza clienti) 
        di un'Azienda o Ente Pubblico nel gestire, in maniera centralizzata e 
        sul web, le richieste di assistenza (segnalazioni - ticket) da parte 
        dei loro clienti. <br>
        La funzionalità di base prevede che un cliente/utente utilizzatore possa 
        inserire richieste di assistenza e segnalazioni e possa visualizzare il 
        loro stato, le soluzioni e le risposte ricevute. Un operatore 
        dell'helpdesk prende in carico le varie segnalazioni e le gestisce.
    </p>
    <p>
        Le principali funzionalità previste per il cliente/utente utilizzatore sono:
    </p>    
    <ul>
        <li>Gestione della propria anagrafica</li>
        <li>Visualizzazione elenco delle proprie segnalazioni aperte</li>
        <li>Creazione di una nuova segnalazione</li>
        <li>Ricerca delle segnalazioni inserite</li>
    </ul>

    <p>
        Le principali funzionalità previste per l'operatore dell'helpdesk sono:
    </p>    
    <ul>
        <li>Gestione della propria anagrafica</li>
        <li>Visualizzazione delle nuove segnalazioni inserite dai clienti/utenti 
            utilizzatori e non ancora prese in carico per essere gestite</li>
        <li>Presa in carico gestione di nuove segnalazioni</li>
        <li>Visualizzazione delle proprie segnalazioni gestite ancora aperte</li>
        <li>Chiusura segnalazione</li>
        <li>Ricerca delle segnalazioni gestite</li>        
    </ul>

    <p>
        Le principali funzionalità previste per l'operatore amministratore sono:
    </p>    
    <ul>
        <li>Gestione della propria anagrafica</li>
        <li>Gestione degli operatori (creazione e modifica di tutti gli attributi)</li>
        <li>Gestione degli utenti utilizzatori (creazione e modifica di tutti gli attributi)</li>
    </ul>
    
    <p>
        I dati che figurano per ogni Segnalazione/ticket sono i seguenti:
    </p>    
    <ul>
        <li>Numero della segnalazione</li>
        <li>Data di creazione della segnalazione</li>
        <li>Stato della segnalazione</li>
        <li>Data dello stato attuale della segnalazione</li>
        <li>Priorità della segnalazione</li>
        <li>Categoria della segnalazione</li>
        <li>Oggetto della segnalazione</li>
        <li>Descrizione della segnalazione</li>
        <li>Note dell'operatore</li>
    </ul>
    
    <p>
        I dati che figurano per gli utenti utilizzatori, gli operatori e 
        gli amministratori sono i seguenti:
    </p>    
    <ul>
        <li>Nome e Cognome</li>
        <li>Username e password</li>
        <li>Email</li>
        <li>Numero di telefono fisso</li>
        <li>Numero di telefono cellulare</li>
    </ul>
        
    <p>
        Per gli utenti utilizzatori è mantenuto anche il Servizio di appartenenza.
    </p>    
    <p>
        Inoltre, l’applicazione fornisce istruzioni operative contestuali 
        relative alla funzionalità su cui l'utente dell'applicazione sta operando.
    </p>    
    
    <h2>Struttura del database</h2>
    <p>
        La struttura del database, molto simile a quella delle classi 
        utilizzate, è mostrata nella seguente figura. 
    </p>
    
    <img height="768" width="768" src="images/segnaliammo_database.png" title="Struttura database" alt="Struttura database" >
    
    
    
    <h2> Requisiti del progetto </h2>
    <ul>
        <li>Utilizzo di HTML e CSS</li>
        <li>Utilizzo di PHP e MySQL</li>
        <li>Utilizzo del pattern MVC </li>
        <li>Tre ruoli (utente utilizzatore, operatore e amministratore)</li>
        <li>Transazione per la registrazione di una nuova segnalazione 
            (metodo <strong>salvaNuovaSegnalazione</strong> della classe 
            <strong>segnalazione_factory.php)</strong> </li>
        <li>Caricamento ajax dei risultati della ricerca delle segnalazioni 
            (sottopagina <strong>segnalazioni_ricerca</strong> - ruolo 
            utilizzatore - <strong>utilizzatore_controller.php</strong>) </li>
    </ul>
    
    
    <h2>Accesso al progetto</h2>
    <p>
        La pagina iniziale del progetto (Pagina di <strong>Login</strong>) si trova sulla URL 
        <a href="php/login">http://spano.sc.unica.it/amm2015/toluRoberto/php/login</a>
    <p>
    <p>Si pu&ograve; accedere all'applicazione con le seguenti credenziali</p>
    <ul>
        <li>Ruolo utilizzatore:</li>
        <ul>
            <li>username: utilizzatore1<br>
                password: roberto<br>&nbsp;</li>
            
            <li>username: utilizzatore2<br>
            password: roberto<br>&nbsp;</li>
        </ul>
    </ul>
    
    <ul>
        <li>Ruolo operatore:</li>
        <ul>
            <li>username: operatore1<br>
                password: roberto<br>&nbsp;</li>
            
            <li>username: operatore2<br>
            password: roberto<br>&nbsp;</li>
        </ul>
    </ul>
    
    <ul>
        <li>Ruolo amministratore:</li>
        <ul>
            <li>username: admin<br>
            password: admin<br>&nbsp;</li>
        </ul>
    </ul>
    
    
</body>
</html>
