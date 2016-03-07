<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' 
                || $vd->getSottoPagina() == null 
                ? 'current_page_item' : ''?>">
        <a href="operatore<?= $vd->scriviToken('?')?>">Home</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' 
                ? 'current_page_item' : '' ?>">
        <a href="operatore/anagrafica<?= $vd->scriviToken('?')?>">Anagrafica</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'segnalazioni_nuove' 
                || $vd->getSottoPagina() == 'segnalazione_prendi'
                //|| $vd->getSottoPagina() == 'segnalazione_vedi'   
                ? 'current_page_item' : '' ?>">
        <a href="operatore/segnalazioni_nuove<?= $vd->scriviToken('?')?>">Nuove segnalazioni</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'segnalazioni_aperte' 
                || $vd->getSottoPagina() == 'segnalazione_modifica'
                //|| $vd->getSottoPagina() == 'segnalazione_vedi'   
                ? 'current_page_item' : '' ?>">
        <a href="operatore/segnalazioni_aperte<?= $vd->scriviToken('?')?>">Segnalazioni aperte</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'segnalazioni_ricerca' 
                || $vd->getSottoPagina() == 'segnalazioni_trovate'
                || $vd->getSottoPagina() == 'segnalazione_vedi'
                ? 'current_page_item' : '' ?>">
        <a href="operatore/segnalazioni_ricerca<?= $vd->scriviToken('?')?>">Ricerca segnalazioni</a>
    </li>
</ul>