<h2 class="icon-title" id="h-cerca">Elenco storico segnalazioni</h2>

<div class="error">
    <div>
        <ul><li>Testo</li></ul>
    </div>
</div>


<div class="output-form">
    
    <ul class="none">
        <li>Cognome: <strong><?= $user->getCognome() ?></strong></li>
        <li>Nome: <strong><?= $user->getNome() ?></strong></li>
        <li>Username: <strong><?= $user->getUsername() ?></strong></li>
        <li>Servizio di appartenenza: <strong><?= $user->getServizio()->getNome() ?></strong></li>
    </ul>
</div>


<div class="input-form">
    <h3>Filtro</h3>

    <form method="post" action="utilizzatore/segnalazioni_ricerca<?= $vd->scriviToken('?')?>">
                
        <label for="categoria_segnalazione">Categoria segnalazione:</label>
        <select name="categoria_segnalazione" id="categoria_segnalazione">
            <option value="qualsiasi">-- Qualsiasi --</option>
            <?php foreach ($categorie as $categoria) { ?>
                <option value="<?= $categoria->getId() ?>" ><?= $categoria->getNome() ?></option>
            <?php } ?>
        </select>
        <br/>
        
        <label for="priorita">Priorit&agrave;:</label>
        <select name="priorita" id="priorita">
            <option value="qualsiasi">-- Qualsiasi --</option>
            <option value="bassa">Bassa</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
        </select>
        <br/>
        
        <label for="status">Stato:</label>
        <select name="status" id="status">
            <option value="qualsiasi">-- Qualsiasi --</option>
            <option value="nuova">Nuova</option>
            <option value="aperta">Aperta</option>
            <option value="chiusa">Chiusa</option>
        </select>
        <br/>
        
        <label for="oggetto">Oggetto:</label>
        <input type="text" name="oggetto" id="oggetto">
        <br/>
               
        <button id="filtra" type="submit" name="cmd" value="s_cerca">Cerca</button>
        
    </form>
</div>


<div class="input-form">
    <h3>Elenco segnalazioni</h3>
</div>    
    
<p id="nessuno">Nessuna segnalazione trovata</p>    
    
    
    <table id="tabella_segnalazioni">
        <thead>
            <tr>
                <th class="segnalazione_col-small">Data creazione</th>
                <th class="segnalazione_col-small">Numero</th>
                <th class="segnalazione_col-small">Stato</th>
                <th class="segnalazione_col-small">Data stato</th>
                <th class="segnalazione_col-small">Tipo</th>
                <th class="segnalazione_col-large">Oggetto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data</td>
                <td>Numero</td>
                <td>Stato</td>
                    
                <td>Tipo</td>
                <td>Oggetto</td>
                    
                <td>Dettagli</td>

            </tr>
        </tbody>
    </table>

