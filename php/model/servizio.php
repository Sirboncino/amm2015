<?php

/**
 * Classe che rappresenta un Servizio
 * @author *r*t*
 */
class Servizio {

    /**
     * I'identificatore del Dipartimento
     * @var int
     */
    private $id;
    
    /**
     * Il nome del Servizio
     * @var string 
     */
    private $nome;
    
    /**
     * Settore a cui appartiene il Servizio
     * @var Settore $settore
     */
   // private $settore;


    
    /**
     * Costruttore di un Servizio
     */
    public function __construct() {
        
    }

    
    /**
     * Restituisce l'identificatore del Servizio
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Imposta un nuovo identificatore per il Servizio
     * @param int $id
     */
    public function setId($id){
        $this->id = $id;
    }
    
    
    /**
     * Restituisce il nome del Servizio
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome del Servizio
     * @param string $nome il nuovo nome per il Servizio
     */
    public function setNome($nome){
        $this->nome = $nome;
    }
    
    
    /**
     * Verifica se due oggetti Servizio sono logicamente uguali
     * @param Servizio $other l'oggetto con cui confrontare $this
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(Servizio $other) {
        return $other->id == $this->id;
    }

}

?>
