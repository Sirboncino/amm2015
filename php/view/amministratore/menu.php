<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>">
        <a href="amministratore<?= $vd->scriviToken('?')?>">Home</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>">
        <a href="amministratore/anagrafica<?= $vd->scriviToken('?')?>">Anagrafica</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'gestione_operatori' ? 'current_page_item' : '' ?>">
        <a href="amministratore/gestione_operatori<?= $vd->scriviToken('?')?>">Gestione Operatori</a>
    </li>
    <li class="<?= $vd->getSottoPagina() == 'gestione_utilizzatori' ? 'current_page_item' : '' ?>">
        <a href="amministratore/gestione_utilizzatori<?= $vd->scriviToken('?')?>">Gestione Utilizzatori</a>
    </li>
</ul>