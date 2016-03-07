
<div class="input-form">
    <h3>Dettaglio Operatore - Modifica</h3>

    <form method="post" action="amministratore/operatore_modifica<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="operatore" value="<?= $mod_operatore->getId() ?>"/>
        
        <ul class="none">
            <li>ID Operatore: <strong><?= $mod_operatore->getId() ?></strong></li> 
        </ul>
        
        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" id="cognome" value="<?= $mod_operatore->getCognome() ?>"/>
        <br/>
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $mod_operatore->getNome() ?>"/>
        <br/>
        
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $mod_operatore->getUsername() ?>"/>
        <br/>
        
        <label for="attivo">Operatore Attivo:</label>
        <select name="attivo" id="attivo">
            <option value=0 <?= $mod_operatore->getAttivo() == 0 ? 'selected' : '' ?> >Si</option>
            <option value=1 <?= $mod_operatore->getAttivo() == 1 ? 'selected' : '' ?> >No</option>
        </select>
        <br/>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"value="<?= $mod_operatore->getEmail() ?>"/>
        <br/>
        
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= $mod_operatore->getTelefono() ?>"/>
        <br/>
        
        <label for="cellulare">Cellulare:</label>
        <input type="text" name="cellulare" id="cellulare" value="<?= $mod_operatore->getCellulare() ?>"/>
        <br/><br/>
        
        <label for="pass1">Nuova Password:</label>
        <input type="password" name="pass1" id="pass1"/>
        <br/>
        <label for="pass2">Conferma Password:</label>
        <input type="password" name="pass2" id="pass2"/>
        <br/>
                
        <div class="btn-group">
            <button type="submit" name="cmd" value="o_annulla">Annulla</button>
            <button type="submit" name="cmd" value="o_salva">Salva modifiche</button> 
        </div>
    </form>
</div>

