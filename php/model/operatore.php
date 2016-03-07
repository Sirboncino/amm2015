<?php
include_once 'user.php';

/**
 * Classe che rappresenta un Operatore
 *
 * @author *r*t*
 */
class Operatore extends User {
    
    /**
     * Costruttore
     */
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Operatore);
    }

}

?>
