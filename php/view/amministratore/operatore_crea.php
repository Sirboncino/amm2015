<div class="input-form">
    <h3>Crea nuovo Operatore</h3>

    <form method="post" action="amministratore/operatore_crea<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="o_nuovo"/>
        
        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" id="cognome" value="<?= (isset($request['cognome'])) ? $request['cognome'] : '' ?>"/>
        <br/>
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= (isset($request['nome'])) ? $request['nome'] : '' ?>"/>
        <br/>
        
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= (isset($request['username'])) ? $request['username'] : '' ?>"/>
        <br/>
        
        <label for="attivo">Operatore Attivo:</label>
        <select name="attivo" id="attivo">
            <option value=0>Si</option>
            <option value=1">No</option>   
        </select>
        <br/>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= (isset($request['email'])) ? $request['email'] : '' ?>"/>
        <br/>
        
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= (isset($request['telefono'])) ? $request['telefono'] : '' ?>"/>
        <br/>
        
        <label for="cellulare">Cellulare:</label>
        <input type="text" name="cellulare" id="cellulare" value="<?= (isset($request['cellulare'])) ? $request['cellulare'] : '' ?>"/>
        <br/><br/>
        
        <label for="pass1">Password:</label>
        <input type="password" name="pass1" id="pass1"/>
        <br/>
        <label for="pass2">Conferma Password:</label>
        <input type="password" name="pass2" id="pass2"/>
        <br/>
        
        <div class="btn-group">
            <button type="submit" name="cmd" value="o_annulla">Annulla</button>
            <button type="submit" name="cmd" value="o_nuovo">Salva</button> 
        </div>
    </form>
</div>

