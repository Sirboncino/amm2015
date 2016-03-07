
<?php if (count($segnalazioni_trovate) > 0) { ?>
    <div class="input-form">
        <h3>Elenco segnalazioni trovateeeeee</h3>
    </div>    

    <table>
        <thead>
            <tr>
                <th class="segnalazione_col-small">Data</th>
                <th class="segnalazione_col-small">Numero</th>
                <th class="segnalazione_col-large">Utilizzatore</th>
                <th class="segnalazione_col-small">Stato</th>
                <th class="segnalazione_col-small">Tipo</th>
                <th class="segnalazione_col-large">Oggetto</th>
                <th class="segnalazione_col-small">Dettagli</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($segnalazioni_trovate as $segnalazione) {
                ?>
                <tr <?= $i % 2 == 0 ? '' : 'class="alt-row"' ?>>
                    <td><?= $segnalazione->getDataCreazione()->format('d/m/Y') ?></td>
                    <td><?= $segnalazione->getNumero() ?></td>
                    <td><?= $segnalazione->getUtilizzatore()->getCognome(). ' '.$segnalazione->getUtilizzatore()->getNome() ?></td>
                    <td><?= $segnalazione->getStatus() ?></td>
                    <td><?= $segnalazione->getCategoria()->getNome() ?></td>
                    <td><?= $segnalazione->getOggetto() ?></td>
                                        
                    <td>
                        <a href="operatore/segnalazione_vedi?segnalazione=<?= $segnalazione->getId() ?><?= $vd->scriviToken('&') ?>" title="Dettaglio della segnalazione">
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
        <h3>Nessuna segnalazione trovata</h3>
    </div>
<?php } ?>

