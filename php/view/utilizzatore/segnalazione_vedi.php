<div class="output-form">
    <h3>Dettaglio segnalazione</h3>
   
    <form method="post" action="utilizzatore/segnalazione_vedi<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="s_annulla"/>
        
        <ul class="none">
            <li>Codice ticket: <strong><?= $vedi_segnalazione->getNumero() ?></strong></li> 
            <li>Data - ora inserimento: <strong><?= $vedi_segnalazione->getDataCreazione()->format('d/m/Y - H:i') ?></strong></li>         
            <li>Data - ora ultima modifica: <strong><?= $vedi_segnalazione->getDataStatus()->format('d/m/Y - H:i') ?></strong></li>
            <li>Categoria segnalazione: <strong><?=  $vedi_segnalazione->getCategoria()->getNome() ?></strong></li>
            <li>Priorit&agrave;: <strong><?= $vedi_segnalazione->getPriorita() ?></strong></li>
            <li>Stato attuale: <strong><?= $vedi_segnalazione->getStatus() ?></strong></li>
            <li>Operatore: <strong><?= $vedi_segnalazione->getOperatore()->getCognome(). ' '.$vedi_segnalazione->getOperatore()->getNome()  ?></strong></li>
            <li>________________________________</li>
            <li><strong>Oggetto: </strong><br><?= $vedi_segnalazione->getOggetto() ?></li>
            <li><strong>Testo segnalazione: </strong><br><?= $vedi_segnalazione->getDescrizione() ?></li>
            <li><strong>Note operatore: </strong><br><?= $vedi_segnalazione->getNote() ?></li> 
        </ul>
        
        <button type="submit" name="cmd" value="s_annulla">OK</button>
        
    </form>
</div>

