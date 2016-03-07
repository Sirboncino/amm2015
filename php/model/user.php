<?php

/**
 * Classe che rappresenta un generico utente del sistema
 */
class User {

    /**
     * Costante che definisce il ruolo amministratore
     */
    const Amministratore = 1;
    
    /**
     * Costante che definisce il ruolo operatore
     */
    const Operatore = 2;
    
     /**
     * Costante che definisce il ruolo utilizzatore
     */
    const Utilizzatore = 3;
    

    /**
     * Identificatore dell'utente
     * @var int
     */
    private $id;
    
    
    /**
     * Il ruolo dell'utente nell'applicazione.
     * Lo utilizzo per implementare il controllo degli accessi
     * @var int 
     */
    private $ruolo;
    
    
    /** 
     * email dell'utente
     * @var string
     */
    private $email;
    
    
    /**
     * Username per l'autenticazione
     * @var string
     */
    private $username;
        
    
    /**
     * Password per l'autenticazione
     * @var string
     */
    private $password;
    
    
    /**
     * Data scadenza password
     * @var datetime
     */
    private $scadenza_password;
    
    
    /**
     * Data ultimo login
     * @var datetime
     */
    private $ultimo_login;
    
    
    /**
     * Utente attivo o bloccato
     * @var tinyint
     */
    private $attivo;
    
    
    /**
     * Cognome dell'utente
     * @var string 
     */
    private $cognome;
    
    
    /**
     * Nome dell'utente
     * @var string
     */
    private $nome;
    
    
    /**
     * Numero di telefono fisso dell'utente
     * @var string
     */
    private $telefono;
    
 
    /**
     * Numero di telefono cellulare dell'utentee
     * @var string
     */
    private $cellulare;
    

    
    /**
     * Costruttore
     */
    public function __construct() {
        
    }

    
    /**
     * Verifica se l'utente esista per il sistema
     * @return boolean true se l'utente esiste, false altrimenti
     */
    public function esiste() {
        // implementazione di comodo, va fatto con il db
        return isset($this->ruolo);
    }

       
    /**
     * Restituisce un identificatore unico per l'utente
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Imposta un identificatore unico per l'utente
     * @param int $id
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setId($id){
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(!isset($intVal)){
            return false;
        }
        $this->id = $intVal;
    }
    
    
    /**
     * Restituisce un intero 
     * @return int
     */
    public function getRuolo() {
        return $this->ruolo;
    }

    /**
     * Imposta un ruolo per un dato utente
     * @param int $ruolo
     * @return boolean true se il valore e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setRuolo($ruolo) {
        switch ($ruolo) {
            case self::Amministratore:
            case self::Operatore:
            case self::Utilizzatore:
                $this->ruolo = $ruolo;
                return true;
                
            default:
                return false;
                
        }
    }


    /**
     * Restituisce l'email dell'utente
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Imposta una nuova email per l'utente
     * @param string $email la nuova email dell'utente
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $this->email = $email;
        return true;
    }

        
    /**
     * Restituisce lo username dell'utente
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Imposta lo username per l'autenticazione dell'utente. 
     * I nomi che si ritengono validi contengono solo lettere maiuscole e minuscole.
     * La lunghezza del nome deve essere superiore a 5
     * @param string $username
     * @return boolean true se lo username e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setUsername($username) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z]{5,}/')))) {
            return false;
        }
        $this->username = $username;
        return true;
    }

    
    /**
     * Restituisce la password per l'utente corrente
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Imposta la password per l'utente corrente
     * @param string $password
     * @return boolean true se la password e' stata impostata correttamente,
     * false altrimenti
     */
    public function setPassword($password) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        //  -> in questo caso almeno tre caratteri 
        if (!filter_var($password, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z0-9]{3,}/')))) {
            return false;
        }
        $this->password = $password;
        return true;
    }

        
    /**
     * Restituisce la scadenza della password per l'utente corrente
     * @return datetime
     */
    public function getScadenzaPassword() {
        return $this->scadenza_password;
    }

    /**
     * Imposta la scadenza della password per l'utente corrente
     * @param datetime $scadenza_password
     * @return boolean true se la data e' stata impostata correttamente,
     * false altrimenti
     */
    public function setScadenzaPassword($scadenza_password) {
        $this->scadenza_password = $scadenza_password;
        return true;
    }

    
    /**
     * Restituisce la data-ora dell'ultimo login per l'utente corrente
     * @return datetime
     */
    public function getUltimoLogin() {
        return $this->ultimo_login;
    }

    /**
     * Imposta la data-ora dell'ultimo login per l'utente corrente
     * @param datetime $ultimo_login
     * @return boolean true se la password e' stata impostata correttamente,
     * false altrimenti
     */
    public function setUltimoLogin($ultimo_login) {
        $this->ultimo_login = $ultimo_login;
        return true;
    }
    
        
    /**
     * Restituisce il xxx se l'utente e' attivo
     * @return tinyint
     */
    public function getAttivo() {
        return $this->attivo;
    }

    /**
     * Imposta il valore ATTIVO all'utente
     * @param string $attivo
     * @return boolean true se il nome e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setAttivo($attivo) {
        $this->attivo = $attivo;
        return true;
    }

    
    /**
     * Restituisce il cognome dell'utente
     * @return string
     */
    public function getCognome() {
        return $this->cognome;
    }

    /**
     * Imposta il cognome dell'utente
     * @param string $cognome
     * @return boolean true se il cognome e' stato impostato correttamente,
     * false altrimenti
     */
    public function setCognome($cognome) {
        $this->cognome = $cognome;
        return true;
    }

      
    /**
     * Restituisce il nome dell'utente
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome dell'utente
     * @param string $nome
     * @return boolean true se il nome e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }

    
    /**
     * Restituisce il numero di telefono fisso dell'utente
     * @return string
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Imposta il numero di telefono dell'utente.
     * I valori che si ritengono validi contengono solo numeri.
     * La lunghezza del numero deve essere superiore a 6
     * @param string $telefono
     * @return boolean true se il numero di telefono e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setTelefono($telefono) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        if (!filter_var($telefono, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9]{6,}/')))) {
            return false;
        }
       
        $this->telefono = $telefono;
        return true;
    }

    
    /**
     * Restituisce il numero di telefono cellulare dell'utente
     * @return string
     */
    public function getCellulare() {
        return $this->cellulare;
    }

    /**
     * Imposta il numero di telefono cellulare dell'utente.
     * I valori che si ritengono validi contengono solo numeri.
     * La lunghezza del numero deve essere superiore a 6
     * @param string $cellulare
     * @return boolean true se il numero di telefono e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setCellulare($cellulare) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        if (!filter_var($cellulare, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9]{6,}/')))) {
            return false;
        }
      
        $this->cellulare = $cellulare;
        return true;
    }
    
 
    /**
     * Compara due utenti, verificandone l'uguaglianza logica
     * @param User $user l'utente con cui comparare $this
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(User $user) {

        return  $this->id == $user->id &&
                $this->nome == $user->nome &&
                $this->cognome == $user->cognome &&
                $this->ruolo == $user->ruolo;
    }

}

?>
