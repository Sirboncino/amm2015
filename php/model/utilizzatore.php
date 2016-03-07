<?php
include_once 'user.php';
include_once 'servizio.php';

/**
 * Classe che rappresenta un Utilizzatore
 * @author *r*t*
 */
class Utilizzatore extends User {

    /**
     * Servizio a cui appartiene l'utilizzatore
     * @var string
     */
    private $servizio;
    
    
    /**
     * Settore a cui appartiene il Servizio dell'utilizzatore
     * @var string
     */
 /*   private $settore;
*/
    
    /**
     * Costruttore della classe
     */
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Utilizzatore);
        
    }

    
    /**
     * Restituisce il Servizio a cui appartienee l'utilizzatore
     * @return string $servizio
     */
    public function getServizio() {
        return $this->servizio;
    }
    
    /**
     * Imposta un nuovo valore per il Servizio a cui appartienee l'utilizzatore
     * @param Servizio $servizio il nuovo Servizio
     */
    public function setServizio(Servizio $servizio) {
        $this->servizio = $servizio;
        
    }

}

?>
