<?php
include_once 'categoria.php';

/**
 * Classe che rappresenta una Segnalazione
 * @author *r*t*
 */
class Segnalazione {

    /**
     * Un identificatore per la Segnalazione
     * @var int
     */
    private $id;
    
    /**
     * Il numero della Segnalazione
     * @var string
     */
    private $numero;
    
    /**
     * La priorità della Segnalazione
     * @var string
     */
    private $priorita;
    
    /**
     * Lo status della Segnalazione
     * @var string
     */
    private $status;
    
    /**
     * La data di creazione della Segnalazione
     * @var datetime
     */
    private $data_creazione;
    
    /**
     * La data di chiusura della Segnalazione
     * @var datetime
     */
    private $data_status;
    
    
     /**
     * L'oggetto della Segnalazione
     * @var string
     */
    private $oggetto;
    
    /**
     * La descrizione della Segnalazione
     * @var string
     */
    private $descrizione;
    
    /**
     * Le note sulla Segnalazione
     * @var string
     */
    private $note;
    
 
    /**
     * La categoria della Segnalazione (id)
     * @var Categoria $categoria 
     */
    private $categoria;

    
    /**
     * L'operatore che gestisce la Segnalazione (id)
     * @var Operatore $operatore 
     */
    private $operatore;
    
    
    /**
     * L'utilizzatore che ha fatto la Segnalazione (id)
     * @var Utilizzatore $utilizzatore 
     */
    private $utilizzatore;
    
    
    
    /**
     * Costruttore
     */
    public function __construct() {
        
    }

    
    /**
     * Restiusce l'identificatore della Segnalazione
     * @return int l'identificatore della Segnalazione
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Imposta l'identificatore della Segnalazione
     * @param int $id il nuovo identificatore
     * @return boolean true se l'identificatore e' stato impostato, false altrimenti
     */
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            $this->id = $intVal;
            return true;
        }
        return false;
    }

        
    /**
     * Restituisce il numero della Segnalazione
     * @return string
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Imposta il numero della Segnalazione
     * @param string $numero il nuovo numero della Segnalazione
     */
    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
           
    /**
     * Restituisce la priorità della Segnalazione
     * @return string
     */
    public function getPriorita() {
        return $this->priorita;
    }

    /**
     * Imposta la priorità della Segnalazione
     * @param string $priorita la nuova priorità della Segnalazione
     */
    public function setPriorita($priorita) {
        $this->priorita = $priorita;
    }
     
           
    /**
     * Restituisce lo status della Segnalazione
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Imposta lo status della Segnalazione
     * @param string $status il nuovo status  della Segnalazione
     */
    public function setStatus($status) {
        $this->status = $status;
    }
         
    
    /**
     * Restituisce la data di creazione della Segnalazione
     * @return datetime
     */
    public function getDataCreazione() {
        return $this->data_creazione;
    }

    /**
     * Imposta la data di creazione della Segnalazione
     * @param datetime $data_creazione la nuova data di creazione della Segnalazione
     */
    public function setDataCreazione(DateTime $data_creazione) {
        $this->data_creazione = $data_creazione;
    }


    /**
     * Restituisce la data dello status attuale della Segnalazione
     * @return datetime
     */
    public function getDataStatus() {
        return $this->data_status;
    }

    /**
     * Imposta la data dello status attuale  della Segnalazione
     * @param datetime $data_status la nuova data dello status attuale della Segnalazione
     */
    public function setDataStatus(DateTime $data_status) {
        $this->data_status = $data_status;
    }

    
    /**
     * Restituisce l'oggetto della Segnalazione
     * @return string
     */
    public function getOggetto() {
        return $this->oggetto;
    }

    /**
     * Imposta l'oggetto della Segnalazione
     * @param string $oggetto
     */
    public function setOggetto($oggetto) {
        $this->oggetto = $oggetto;
    }

          
    /**
     * Restituisce la descrizione della Segnalazione
     * @return string
     */
    public function getDescrizione() {
        return $this->descrizione;
    }

    /**
     * Imposta la descrizione della Segnalazione
     * @param string $descrizione
     */
    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    
    /**
     * Restituisce le note sulla Segnalazione
     * @return string
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Imposta le note sulla Segnalazione
     * @param string $note
     */
    public function setNote($note) {
        $this->note = $note;
    }

    
    /**
     * Restituisce la Categoria della Segnalazione (id)
     * @return Categoria
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * Imposta la Categoria della Segnalazione (id)
     * @param Categoria $cat la nuova Categoria della Segnalazione
     */
    public function setCategoria(Categoria $cat) {
        $this->categoria = $cat;
    }

            
    /**
     * Restituisce l'Operatore che gestisce la Segnalazione (id)
     * @return Operatore
     */
    public function getOperatore() {
        return $this->operatore;
    }

    /**
     * Imposta l'Operatore che gestisce la Segnalazione (id)
     * @param Operatore $op il nuovo Operatore che gestisce la Segnalazione
     */
    public function setOperatore(Operatore $op) {
        $this->operatore = $op;
    }
    
            
    /**
     * Restituisce l'Utilizzatore che ha fatto la Segnalazione (id)
     * @return Operatore
     */
    public function getUtilizzatore() {
        return $this->utilizzatore;
    }

    /**
     * Imposta l'Utilizzatore che ha fatto la Segnalazione (id)
     * @param Utilizzatore $ut il nuovo Utilizzatore che ha fatto la Segnalazione
     */
    public function setUtilizzatore(Utilizzatore $ut) {
        $this->utilizzatore = $ut;
    }

    
    /**
     * Restituisce la relazione di uguaglianza logica fra due Segnalazioni
     * @param Segnalazione $other la Segnalazione con cui confrontare $this
     * @return boolean true se sono logicamente uguali, false altrimenti
     */
    public function equals(Segnalazione $other) {
        return $other->id == $this->id;
    }

}

?>
