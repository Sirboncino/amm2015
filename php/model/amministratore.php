<?php
include_once 'user.php';

/**
 * Classe che rappresenta un Amministratore
 *
 * @author *r*t*
 */
class Amministratore extends User {
    
    /**
     * Costruttore
     */
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Amministratore);
    }

}

?>
