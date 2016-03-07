<div class="output-form">
    <h3>Dettaglio segnalazione</h3>
   
    <form method="post" action="operatore/segnalazione_prendi<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="segnalazione" value="<?= $vedi_segnalazione->getId() ?>"/>
        
        <ul class="none">
            <li>Codice ticket: <strong><?= $vedi_segnalazione->getNumero() ?></strong></li> 
            <li>Utente: <strong><?= $vedi_segnalazione->getUtilizzatore()->getCognome(). ' '.$vedi_segnalazione->getUtilizzatore()->getNome()  ?></strong></li>
            <li>Servizio: <strong><?= $vedi_segnalazione->getUtilizzatore()->getServizio()->getNome() ?></strong></li>            
            
            <li>Data - ora inserimento: <strong><?= $vedi_segnalazione->getDataCreazione()->format('d/m/Y - H:i') ?></strong></li>         
            <li>Data - ora stato attuale: <strong><?= $vedi_segnalazione->getDataStatus()->format('d/m/Y - H:i') ?></strong></li>
            <li>Categoria segnalazione: <strong><?=  $vedi_segnalazione->getCategoria()->getNome() ?></strong></li>
            <li>Priorit&agrave;: <strong><?= $vedi_segnalazione->getPriorita() ?></strong></li>
            <li>Stato attuale: <strong><?= $vedi_segnalazione->getStatus() ?></strong></li>
            <li>Operatore: <strong><?= $vedi_segnalazione->getOperatore()->getCognome(). ' '.$vedi_segnalazione->getOperatore()->getNome()  ?></strong></li>
            <li>________________________________</li>
            <li><strong>Oggetto: </strong><br><?= $vedi_segnalazione->getOggetto() ?></li>
            <li><strong>Testo segnalazione: </strong><br><?= $vedi_segnalazione->getDescrizione() ?></li>
             
        </ul>
        
        <div class="btn-group">
            <button type="submit" name="cmd" value="prendi_annulla">Annulla</button>
            <button type="submit" name="cmd" value="prendi_nuova">Prendi in gestione</button> 
        </div>
        
               
    </form>
</div>

