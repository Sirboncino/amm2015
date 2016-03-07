<h2 class="icon-title" id="h-utenti">Gestione Operatori</h2>

<div class="output-form">
    
    <ul class="none">
        <li>Cognome: <strong><?= $user->getCognome() ?></strong></li>
        <li>Nome: <strong><?= $user->getNome() ?></strong></li>
        <li>Username: <strong><?= $user->getUsername() ?></strong></li>
    </ul>
</div>


<?php if (count($operatori) > 0) { ?>
    <div class="input-form">
        <h3>Elenco Operatori presenti nel sistema</h3>
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
            foreach ($operatori as $operatore) {
                ?>
                <tr <?= $i % 2 == 0 ? '' : 'class="alt-row"' ?>>
                    <td><?= $operatore->getCognome() ?></td>
                    <td><?= $operatore->getNome() ?></td>
                    <td><?= $operatore->getUsername() ?></td>
                    <td><?= $operatore->getAttivo() == 0 ? 'Si': 'No' ?></td>
                                                            
                    <td>
                        <a href="amministratore/operatore_modifica?operatore=<?= $operatore->getId() ?><?= $vd->scriviToken('&') ?>" title="Dettaglio Operatore">
                            <img  src="../images/16_binoculars.png" alt="Visualizza Operatore">
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
        <h3>Nessun Operatore presente nel sistema</h3>
    </div>
<?php } ?>
    
<div class="input-form">

    <form method="post" action="amministratore/operatore_crea<?= $vd->scriviToken('?') ?>">
        <button type="submit" name="cmd" value="o_crea">Crea nuovo Operatore</button>
    </form>

</div>

