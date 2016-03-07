<h2 class="icon-title" id="h-segnalazioni">Segnalazioni aperte</h2>

<div class="output-form">
    
    <ul class="none">
        <li>Cognome: <strong><?= $user->getCognome() ?></strong></li>
        <li>Nome: <strong><?= $user->getNome() ?></strong></li>
        <li>Username: <strong><?= $user->getUsername() ?></strong></li>
        <li>Servizio di appartenenza: <strong><?= $user->getServizio()->getNome() ?></strong></li>
    </ul>
</div>


<?php if (count($segnalazioni) > 0) { ?>
    <div class="input-form">
        <h3>Elenco segnalazioni aperte (o nuove non ancora prese in carico)</h3>
    </div>    

    <table>
        <thead>
            <tr>
                <th class="segnalazione_col-small">Data</th>
                <th class="segnalazione_col-small">Numero</th>
                <th class="segnalazione_col-small">Stato</th>
                <th class="segnalazione_col-small">Tipo</th>
                <th class="segnalazione_col-large">Oggetto</th>
                <th class="segnalazione_col-small">Dettagli</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($segnalazioni as $segnalazione) {
                ?>
                <tr <?= $i % 2 == 0 ? '' : 'class="alt-row"' ?>>
                    <td><?= $segnalazione->getDataCreazione()->format('d/m/Y') ?></td>
                    <td><?= $segnalazione->getNumero() ?></td>
                    <td><?= $segnalazione->getStatus() ?></td>
                    <td><?= $segnalazione->getCategoria()->getNome() ?></td>
                    <td><?= $segnalazione->getOggetto() ?></td>
                                        
                    <td>
                        <a href="utilizzatore/segnalazione_vedi?segnalazione=<?= $segnalazione->getId() ?><?= $vd->scriviToken('&') ?>" title="Dettaglio della segnalazione">
                            <img  src="../images/16_binoculars.png" alt="Visualizza segnalazione">
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
        <h3>Nessuna segnalazione aperta in corso</h3>
    </div>
<?php } ?>
    
<div class="input-form">

    <form method="post" action="utilizzatore/segnalazione_crea<?= $vd->scriviToken('?') ?>">
        <button type="submit" name="cmd" value="s_crea">Crea nuova segnalazione</button>
    </form>

</div>

