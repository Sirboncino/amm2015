<h2 class="icon-title" id="h-utenti">Gestione Utenti Utilizzatori</h2>

<div class="output-form">
    
    <ul class="none">
        <li>Cognome: <strong><?= $user->getCognome() ?></strong></li>
        <li>Nome: <strong><?= $user->getNome() ?></strong></li>
        <li>Username: <strong><?= $user->getUsername() ?></strong></li>
    </ul>
</div>


<?php if (count($utilizzatori) > 0) { ?>
    <div class="input-form">
        <h3>Elenco Utenti Utilizzatori presenti nel sistema</h3>
    </div>    

    <table>
        <thead>
            <tr>
                <th class="segnalazione_col-large">Cognome</th>
                <th class="segnalazione_col-large">Nome</th>
                <th class="segnalazione_col-large">Username</th>
                <th class="segnalazione_col-small">Attivo</th>
                <th class="segnalazione_col-small">Dettagli</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($utilizzatori as $utilizzatore) {
                ?>
                <tr <?= $i % 2 == 0 ? '' : 'class="alt-row"' ?>>
                    <td><?= $utilizzatore->getCognome() ?></td>
                    <td><?= $utilizzatore->getNome() ?></td>
                    <td><?= $utilizzatore->getUsername() ?></td>
                    <td><?= $utilizzatore->getAttivo() == 0 ? 'Si': 'No' ?></td>
                                                            
                    <td>
                        <a href="amministratore/utilizzatore_modifica?utilizzatore=<?= $utilizzatore->getId() ?><?= $vd->scriviToken('&') ?>" title="Dettaglio Utente Utilizzatore">
                            <img  src="../images/16_binoculars.png" alt="Visualizza Utente Utilizzatore">
                        </a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="input-form">
        <h3>Nessun Utente Utilizzatore presente nel sistema</h3>
    </div>
<?php } ?>
    
<div class="input-form">

    <form method="post" action="amministratore/utilizzatore_crea<?= $vd->scriviToken('?') ?>">
        <button type="submit" name="cmd" value="u_crea">Crea nuovo Utente Utilizzatore</button>
    </form>

</div>
