
<div class="input-form">
    <h3>Dettaglio Utilizzatore - Modifica</h3>

    <form method="post" action="amministratore/utilizzatore_modifica<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="utilizzatore" value="<?= $mod_utilizzatore->getId() ?>"/>
        
        <ul class="none">
            <li>ID Utilizzatore: <strong><?= $mod_utilizzatore->getId() ?></strong></li> 
        </ul>
        
        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" id="cognome" value="<?= $mod_utilizzatore->getCognome() ?>"/>
        <br/>
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $mod_utilizzatore->getNome() ?>"/>
        <br/>
        
        <label for="servizio">Servizio:</label>
        <select name="servizio" id="servizio">
            <?php foreach ($servizi as $servizio) { ?>
                <option value="<?= $servizio->getId() ?>" <?= $mod_utilizzatore->getServizio()->equals($servizio) ? 'selected' : '' ?> ><?= $servizio->getNome() ?></option>
            <?php } ?>
        </select>
        <br/>
 
        
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $mod_utilizzatore->getUsername() ?>"/>
        <br/>
 
        <label for="attivo">Utilizzatore Attivo:</label>
        <select name="attivo" id="attivo">
            <option value=0 <?= $mod_utilizzatore->getAttivo() == 0 ? 'selected' : '' ?> >Si</option>
            <option value=1 <?= $mod_utilizzatore->getAttivo() == 1 ? 'selected' : '' ?> >No</option>
        </select>
        <br/>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"value="<?= $mod_utilizzatore->getEmail() ?>"/>
        <br/>
        
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= $mod_utilizzatore->getTelefono() ?>"/>
        <br/>
        
        <label for="cellulare">Cellulare:</label>
        <input type="text" name="cellulare" id="cellulare" value="<?= $mod_utilizzatore->getCellulare() ?>"/>
        <br/><br/>
        
        <label for="pass1">Nuova Password:</label>
        <input type="password" name="pass1" id="pass1" />
        <br/>
        <label for="pass2">Conferma Password:</label>
        <input type="password" name="pass2" id="pass2" />
        <br/>
                
        <div class="btn-group">
            <button type="submit" name="cmd" value="u_annulla">Annulla</button>
            <button type="submit" name="cmd" value="u_salva">Salva modifiche</button> 
            
        </div>
    </form>
</div>

