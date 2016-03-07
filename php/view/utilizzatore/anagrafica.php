<h2 class="icon-title" id="h-anagrafica">Dati personali</h2>

<div class="output-form">
    
    <ul class="none">
        <li>Cognome: <strong><?= $user->getCognome() ?></strong></li>
        <li>Nome: <strong><?= $user->getNome() ?></strong></li>
        <li>Username: <strong><?= $user->getUsername() ?></strong></li>
        <li>Servizio di appartenenza: <strong><?= $user->getServizio()->getNome() ?></strong></li>
    </ul>
</div>


<div class="input-form">
    <h3>Contatti</h3>

    <form method="post" action="utilizzatore/anagrafica<?= $vd->scriviToken('&')?>">
        <input type="hidden" name="cmd" value="contatti"/>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"value="<?= $user->getEmail() ?>"/>
        <br/>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= $user->getTelefono() ?>"/>
        <br/>
        <label for="cellulare">Cellulare:</label>
        <input type="text" name="cellulare" id="cellulare" value="<?= $user->getCellulare() ?>"/>
        <br/>
    
        <input type="submit" value="Salva"/>
    </form>
</div>

<div class="input-form">
    <h3>Password</h3>
    <form method="post" action="utilizzatore/anagrafica<?= $vd->scriviToken('&')?>">
        <input type="hidden" name="cmd" value="password"/>
        <label for="pass1">Nuova Password:</label>
        <input type="password" name="pass1" id="pass1"/>
        <br/>
        <label for="pass2">Conferma Password:</label>
        <input type="password" name="pass2" id="pass2"/>
        <br/>
        <input type="submit" value="Cambia"/>
    </form>
</div>