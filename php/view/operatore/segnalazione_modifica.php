<div class="output-form">
    <h3>Dettaglio segnalazione</h3>
   
    <form method="post" action="operatore/segnalazione_modifica<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="s_modifica"/>
        
        <ul class="none">
            <li>Codice ticket: <strong><?= $mod_segnalazione->getNumero() ?></strong></li> 
            <li>Utente: <strong><?= $mod_segnalazione->getUtilizzatore()->getCognome(). ' '.$mod_segnalazione->getUtilizzatore()->getNome()  ?></strong></li>
            <li>Servizio: <strong><?= $mod_segnalazione->getUtilizzatore()->getServizio()->getNome() ?></strong></li>            
            
            
            <li>Data - ora inserimento: <strong><?= $mod_segnalazione->getDataCreazione()->format('d/m/Y - H:i') ?></strong></li>         
            <li>Data - ora ultima modifica: <strong><?= $mod_segnalazione->getDataStatus()->format('d/m/Y - H:i') ?></strong></li>
            <li>Categoria segnalazione: <strong><?=  $mod_segnalazione->getCategoria()->getNome() ?></strong></li>
            <li>Priorit&agrave;: <strong><?= $mod_segnalazione->getPriorita() ?></strong></li>
            <li>Stato attuale: <strong><?= $mod_segnalazione->getStatus() ?></strong></li>

            <li>________________________________</li>
            <li><strong>Oggetto: </strong><br><?= $mod_segnalazione->getOggetto() ?></li>
            <li><strong>Testo segnalazione: </strong><br><?= $mod_segnalazione->getDescrizione() ?></li>
            
        </ul>
        
    </form>
</div>

<div class="input-form">
    <h3>Modifica o gestisci segnalazione</h3>

    <form method="post" action="operatore/segnalazione_modifica<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="segnalazione" value="<?= $mod_segnalazione->getId() ?>"/>
        
        <label for="categoria_segnalazione">Categoria segnalazione:</label>
        <select name="categoria_segnalazione" id="categoria_segnalazione">
            <?php foreach ($categorie as $categoria) { ?>
                <option value="<?= $categoria->getId() ?>" <?= $mod_segnalazione->getCategoria()->equals($categoria) ? 'selected' : '' ?> ><?= $categoria->getNome() ?></option>
            <?php } ?>
        </select>
        <br/>
        
        <label for="priorita">Priorit&agrave;:</label>
        <select name="priorita" id="priorita">
            <option value="bassa" <?= $mod_segnalazione->getPriorita() == 'bassa' ? 'selected' : '' ?> >Bassa</option>
            <option value="media" <?= $mod_segnalazione->getPriorita()== 'media' ? 'selected' : '' ?> >Media</option>
            <option value="alta" <?= $mod_segnalazione->getPriorita() == 'alta' ? 'selected' : '' ?> >Alta</option>
        </select>
        <br/>
        
        <label for="testo_note">Note operatore:</label>
        <textarea cols="48 " rows="5" name="testo_note" id="testo_note" ><?= $mod_segnalazione->getNote() ?></textarea>
        <br/>
                
        <div class="btn-group">
            <button type="submit" name="cmd" value="modifica_annulla">Annulla</button>
            <button type="submit" name="cmd" value="s_salva">Salva modifiche</button> 
            <button type="submit" name="cmd" value="s_chiudi">Chiudi segnalazione</button>
        </div>
    </form>
</div>

