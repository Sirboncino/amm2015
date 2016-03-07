<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' 
                || $vd->getSottoPagina() == null 
                ? 'current_page_item' : ''?>">
        <a href="utilizzatore<?= $vd->scriviToken('?')?>">Home</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' 
                ? 'current_page_item' : '' ?>">
        <a href="utilizzatore/anagrafica<?= $vd->scriviToken('?')?>">Anagrafica</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'segnalazioni_aperte' 
                || $vd->getSottoPagina() == 'segnalazione_crea'
                || $vd->getSottoPagina() == 'segnalazione_vedi'   
                ? 'current_page_item' : '' ?>">
        <a href="utilizzatore/segnalazioni_aperte<?= $vd->scriviToken('?')?>">Segnalazioni aperte</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'segnalazioni_ricerca' 
                ? 'current_page_item' : '' ?>">
        <a href="utilizzatore/segnalazioni_ricerca<?= $vd->scriviToken('?')?>">Ricerca segnalazioni</a>
    </li>
</ul>