<div class="input-form">
    <h3>Crea nuova segnalazione</h3>

    <form method="post" action="utilizzatore/segnalazione_crea<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="s_nuova"/>
        
        <label for="categoria_segnalazione">Categoria segnalazione:</label>
        <select name="categoria_segnalazione" id="categoria_segnalazione">
            <?php foreach ($categorie as $categoria) { ?>
                <option value="<?= $categoria->getId() ?>" ><?= $categoria->getNome() ?></option>
            <?php } ?>
        </select>
        <br/>
        
        <label for="priorita">Priorit&agrave;:</label>
        <select name="priorita" id="priorita">
            <option value="bassa">Bassa</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
        </select>
        <br/>
        
        <label for="oggetto">Oggetto:</label>
        <textarea placeholder="Inserire l'oggetto della segnalazione" cols="48" rows="2" name="oggetto" id="oggetto"></textarea>
        <br/>
        
        <label for="testo_segnalazione">Segnalazione:</label>
        <textarea placeholder="Inserire la descrizione della segnalazione" cols="48" rows="5" name="testo_segnalazione" id="testo_segnalazione"></textarea>
        <br/>
                
        <div class="btn-group">
            <button type="submit" name="cmd" value="s_annulla">Annulla</button>
            <button type="submit" name="cmd" value="s_nuova">Salva</button> 
        </div>
    </form>
</div>

