<?php

/**
 * Classe che rappresenta una Categoria
 * @author *r*t*
 */
class Categoria {

    /**
     * I'identificatore della Categoria
     * @var int
     */
    private $id;
    
    /**
     * Il nome della Categoria
     * @var string 
     */
    private $nome;
    
   
    /**
     * Costrutture di un Servizio
     */
    public function __construct() {
        
    }

    
    /**
     * Restituisce l'identificatore della Categoria
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Imposta un nuovo identificatore per la Categoria
     * @param int $id
     */
    public function setId($id){
        $this->id = $id;
    }
    
    
    /**
     * Restituisce il nome della Categoria
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome della Categoria
     * @param string $nome il nuovo nome per la Categoria
     */
    public function setNome($nome){
        $this->nome = $nome;
    }
    
     
    /**
     * Verifica se due oggetti Categoria sono logicamente uguali
     * @param Servizio $other l'oggetto con cui confrontare $this
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(Categoria $other) {
        return $other->id == $this->id;
    }

}

?>
