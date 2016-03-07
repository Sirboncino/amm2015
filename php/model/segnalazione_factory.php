<?php
include_once 'segnalazione.php';
include_once 'categoria_factory.php';
include_once 'user_factory.php';
include_once 'operatore.php';
include_once 'utilizzatore.php';

/**
 * Classe per creare oggetti di tipo Segnalazione
 *
 * @author *r*t*
 */
class SegnalazioneFactory {
    
    private static $singleton;
    
    private function __constructor(){
    }
    
    
    /**
     * Restiuisce un singleton per creare CdL
     * @return \SegnalazioneFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new SegnalazioneFactory();
        }
        
        return self::$singleton;
    }
    
    
       
    /**
     * Restituisce tutte le Segnalazioni gestite da un Operatore
     * @return array $segnalazioni
     */
    public function &getSegnalazioniPerOperatore(Operatore $user){
        $segnalazioni = array();

        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id

            WHERE operatori.id = ?
            
            ORDER BY segnalazioni.data_creazione DESC";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getSegnalazioniPerOperatore] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getSegnalazioniPerOperatore] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni;
        }

        if (!$stmt->bind_param('i', $user->getId())) {
            error_log("[getSegnalazioniPerOperatore] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $segnalazioni;
        }
    
        $segnalazioni = self::caricaSegnalazioniDaStmt($stmt);
        $mysqli->close();
        return $segnalazioni;          
    } 
   

    /**
     * Restituisce tutte le Segnalazioni effettuate da un Utilizzatore
     * @return array $segnalazioni
     */
    public function &getSegnalazioniPerUtilizzatore(Utilizzatore $user){
        $segnalazioni = array();

        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id

            WHERE utilizzatori.id = ?
            
            ORDER BY segnalazioni.data_creazione DESC";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getSegnalazioniPerUtilizzatore] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getSegnalazioniPerUtilizzatore] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni;
        }

        if (!$stmt->bind_param('i', $user->getId())) {
            error_log("[getSegnalazioniPerUtilizzatore] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $segnalazioni;
        }
    
        $segnalazioni = self::caricaSegnalazioniDaStmt($stmt);
        $mysqli->close();
        return $segnalazioni;          
    } 
    
    
    /**
     * Restituisce tutte le Segnalazioni aperte per Operatore
     * @return array $segnalazioni
     */
    public function &getSegnalazioniApertePerOperatore(Operatore $user){
        $segnalazioni = array();

        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id


            WHERE  segnalazioni.status = 'aperta' AND operatori.id = ?
            
            ORDER BY segnalazioni.data_creazione DESC";

        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getSegnalazioniApertePerOperatore] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getSegnalazioniApertePerOperatore] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni;
        }

                
        if (!$stmt->bind_param('i', $user->getId())) {
            error_log("[getSegnalazioniApertePerOperatore] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $segnalazioni = self::caricaSegnalazioniDaStmt($stmt);
        $mysqli->close();
        return $segnalazioni;          
    } 
    

    /**
     * Restituisce tutte le Segnalazioni aperte e nuove per Utilizzatore
     * @return array $segnalazioni
     */
    public function &getSegnalazioniApertePerUtilizzatore(Utilizzatore $user){
        $segnalazioni = array();

        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id


            WHERE  segnalazioni.status = 'aperta' OR segnalazioni.status = 'nuova' AND utilizzatori.id = ?
            
            ORDER BY segnalazioni.data_creazione DESC";

        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getSegnalazioniApertePerUtilizzatore] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getSegnalazioniApertePerUtilizzatore] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni;
        }

                
        if (!$stmt->bind_param('i', $user->getId())) {
            error_log("[getSegnalazioniApertePerUtilizzatore] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $segnalazioni;
        }
    
        
        $segnalazioni = self::caricaSegnalazioniDaStmt($stmt);
        $mysqli->close();
        return $segnalazioni;          
    } 
    
    
    
    /**
     * Restituisce tutte le Segnalazioni nuove
     * @return array $segnalazioni
     */
    public function &getSegnalazioniNuove(){
        $segnalazioni = array();

        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id
            
            WHERE segnalazioni.status = 'nuova'
            
            ORDER BY segnalazioni.data_creazione DESC";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getSegnalazioniNuove] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getSegnalazioniNuove] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni;
        }

           
        $segnalazioni = self::caricaSegnalazioniDaStmt($stmt);
        $mysqli->close();
        return $segnalazioni;          
    } 
    
    

    
    /**
     * Restituisce la segnalazione con uno specifico Id
     * @return array $segnalazioni
     */
    public function cercaSegnalazionePerId($id){
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }

        $segnalazioni = array();
        
        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id

            WHERE segnalazioni.id = ?";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaSegnalazionePerId] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $segnalazioni;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cercaSegnalazionePerId] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni;
        }

        if (!$stmt->bind_param('i', $intval)) {
            error_log("[cercaSegnalazionePerId] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $segnalazioni;
        }
    
        $segnalazioni = self::caricaSegnalazioniDaStmt($stmt);
        
        if(count($segnalazioni > 0)){
            $mysqli->close();
            return $segnalazioni[0];
        }else{
            $mysqli->close();
            return null;
        }       
    } 
    
    
    
    
    /**
     * Cerca le segnalazioni corrispondente ai parametri passati
     * @param User $user
     * @param int $categori_id
     * @param string $priorita
     * @param string $status
     * @param string $oggetto
     * @param string $data_inizio
     * @param string $data_fine
     * @param int $datafine
     * @return array di segnalazioni
     */
    public function &ricercaSegnalazioni(Utilizzatore $user, $categoria_id, 
            $priorita, $status, $oggetto//, $data_inizio//, $data_fine
            ) {
                
        $segnalazioni_trovate = array();
                
        // costruisco la WHERE "a pezzi" a seconda di quante 
        // variabili sono definite
        //$bind = "i";
        $where = " WHERE utilizzatori.id = ? ";
        $bind = "i";
        $par = array();
        
        $par[] = $user->getId();
        
        if(isset($categoria_id)){
            $where .= " AND categorie.id = ? ";
            $bind .="i";
            $par[] = $categoria_id;
        }
        
        if(isset($priorita)){
            $where .= " AND segnalazioni.priorita = ? ";
            $bind .="s";
            $par[] = $priorita;
        }
        
        if(isset($status)){
            $where .= " AND segnalazioni.status = ? ";
            $bind .="s";
            $par[] = $status;
        }
        
        if(isset($oggetto)){
            $where .= " AND LOWER(segnalazioni.oggetto) LIKE LOWER(?) ";
            $bind .="s";
            $par[] = "%".$oggetto."%";
        }
        
        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id
            
            ".$where." 
            
            ORDER BY segnalazioni.data_creazione DESC";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[ricercaSegnalazioni] impossibile inizializzare il database");
            $mysqli->close();
            return $segnalazioni_trovate;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[ricercaSegnalazioni] impossibile " .
                    "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni_trovate;
        }

        
        switch (count($par)) {
            case 1:
                if (!$stmt->bind_param($bind, $par[0])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 1");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;
            
            case 2:
                if (!$stmt->bind_param($bind, $par[0], $par[1])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 2");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

            case 3:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 3");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

            case 4:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2], $par[3])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 4");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

            case 5:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2], $par[3], $par[4])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 5");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;
            
        }

        $segnalazioni_trovate = self::caricaSegnalazioniDaStmt($stmt);

        $mysqli->close();
        
        return $segnalazioni_trovate;
    }

    
        
    /**
     * Cerca le segnalazioni corrispondente ai parametri passati
     * @param User $user
     * @param int $categori_id
     * @param string $priorita
     * @param string $status
     * @param string $oggetto
     * @param string $data_inizio
     * @param string $data_fine
     * @param int $datafine
     * @return array di segnalazioni
     */
    public function &ricercaSegnalazioniOperatore(Operatore $user, $categoria_id, 
            $priorita, $status, $oggetto 
            ) {
                
        $segnalazioni_trovate = array();
                
        // costruisco la WHERE "a pezzi" a seconda di quante 
        // variabili sono definite
        //$bind = "i";
        $where = " WHERE operatori.id = ? ";
        $bind = "i";
        $par = array();
        
        $par[] = $user->getId();
        
        
        if(isset($categoria_id)){
            $where .= " AND categorie.id = ? ";
            $bind .="i";
            $par[] = $categoria_id;
        }
        
        if(isset($priorita)){
            $where .= " AND segnalazioni.priorita = ? ";
            $bind .="s";
            $par[] = $priorita;
        }
        
        if(isset($status)){
            $where .= " AND segnalazioni.status = ? ";
            $bind .="s";
            $par[] = $status;
        }
        
        if(isset($oggetto)){
            $where .= " AND LOWER(segnalazioni.oggetto) LIKE LOWER(?) ";
            $bind .="s";
            $par[] = "%".$oggetto."%";
        }
 
        
        $query = "SELECT 
            segnalazioni.id segnalazioni_id,
            segnalazioni.numero segnalazioni_numero,
            segnalazioni.priorita segnalazioni_priorita,
            segnalazioni.status segnalazioni_status,
            segnalazioni.data_creazione segnalazioni_data_creazione,
            segnalazioni.data_status segnalazioni_data_status,
            segnalazioni.oggetto segnalazioni_oggetto,
            segnalazioni.descrizione segnalazioni_descrizione,
            segnalazioni.note segnalazioni_note,
            
            categorie.id categorie_id,
            categorie.nome categorie_nome,
            
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.scadenza_password operatori_scadenza_password,
            operatori.ultimo_login operatori_ultimo_login,          
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare,

            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.scadenza_password utilizzatori_scadenza_password,
            utilizzatori.ultimo_login utilizzatori_ultimo_login,          
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM segnalazioni
            JOIN categorie on segnalazioni.categorie_id = categorie.id
            JOIN operatori on segnalazioni.operatori_id = operatori.id
            JOIN utilizzatori on segnalazioni.utilizzatori_id = utilizzatori.id
            JOIN servizi on utilizzatori.servizi_id = servizi.id
            
            ".$where." 
            
            ORDER BY segnalazioni.data_creazione DESC";
        
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[ricercaSegnalazioni] impossibile inizializzare il database");
            $mysqli->close();
            return $segnalazioni_trovate;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[ricercaSegnalazioni] impossibile " .
                    "inizializzare il prepared statement");
            $mysqli->close();
            return $segnalazioni_trovate;
        }

        
        switch (count($par)) {
            case 1:
                if (!$stmt->bind_param($bind, $par[0])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 1");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;
            
            case 2:
                if (!$stmt->bind_param($bind, $par[0], $par[1])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 2");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

            case 3:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 3");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

            case 4:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2], $par[3])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 4");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

            case 5:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2], $par[3], $par[4])) {
                    error_log("[ricercaSegnalazioni] impossibile " .
                            "effettuare il binding in input 5");
                    $mysqli->close();
                    return $segnalazioni_trovate;
                }
                break;

                
        }

        $segnalazioni_trovate = self::caricaSegnalazioniDaStmt($stmt);

        $mysqli->close();
        return $segnalazioni_trovate;
    }

    
    
    /**
     * Carica le segnalazioni eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function &caricaSegnalazioniDaStmt(mysqli_stmt $stmt) {
        
        $segnalazioni = array();
        
            // eseguiamo la query
        if (!$stmt->execute()) {
            error_log("[caricaSegnalazioniDaStmt] impossibile " 
                    ."eseguire lo statement");
            return $segnalazioni;
        }

        $row = array();

        $bind = $stmt->bind_result(
                $row['segnalazioni_id'], 
                $row['segnalazioni_numero'], 
                $row['segnalazioni_priorita'], 
                $row['segnalazioni_status'], 
                $row['segnalazioni_data_creazione'],
                $row['segnalazioni_data_status'],
                $row['segnalazioni_oggetto'],
                $row['segnalazioni_descrizione'], 
                $row['segnalazioni_note'],
                $row['categorie_id'],
                $row['categorie_nome'],
                $row['operatori_id'],
                $row['operatori_email'],
                $row['operatori_username'],
                $row['operatori_password'],
                $row['operatori_scadenza_password'],
                $row['operatori_ultimo_login'],
                $row['operatori_attivo'],
                $row['operatori_cognome'],
                $row['operatori_nome'],
                $row['operatori_telefono'],
                $row['operatori_cellulare'],
                $row['utilizzatori_id'],
                $row['utilizzatori_email'],
                $row['utilizzatori_username'],
                $row['utilizzatori_password'],
                $row['utilizzatori_scadenza_password'],
                $row['utilizzatori_ultimo_login'],
                $row['utilizzatori_attivo'],
                $row['utilizzatori_cognome'],
                $row['utilizzatori_nome'],
                $row['utilizzatori_telefono'],
                $row['utilizzatori_cellulare'],
                $row['servizi_id'],
                $row['servizi_nome']);
         
        if (!$bind) {
            error_log("[caricaSegnalazioniDaStmt] impossibile " 
                    . "effettuare il binding in output");
            return $segnalazioni;
        }

        while ($stmt->fetch()) {
            $segnalazioni[] = self::creaSegnalazioneDaArray($row);
        }
        
        $stmt->close();

        return $segnalazioni;
    }

    
    /**
     * Crea una segnalazione da una riga del db
     * @param type $row
     * @return \Segnalazione
     */
    public function creaSegnalazioneDaArray($row) {
        $segnalazione = new Segnalazione();
        
        $segnalazione->setId($row['segnalazioni_id']);
        $segnalazione->setNumero($row['segnalazioni_numero']);
        $segnalazione->setPriorita($row['segnalazioni_priorita']);
        $segnalazione->setStatus($row['segnalazioni_status']);
        $segnalazione->setDataCreazione(new DateTime($row['segnalazioni_data_creazione']));
        $segnalazione->setDataStatus(new DateTime($row['segnalazioni_data_status']));
        $segnalazione->setOggetto($row['segnalazioni_oggetto']);
        $segnalazione->setDescrizione($row['segnalazioni_descrizione']);
        $segnalazione->setNote($row['segnalazioni_note']);
              
        if(isset($row['categorie_id'])){
            $segnalazione->setCategoria(CategoriaFactory::instance()->creaCategoriaDaArray($row));
        }
        
        if(isset($row['operatori_id'])){
            $segnalazione->setOperatore(UserFactory::instance()->creaOperatoreDaArray($row));
        }
        
        if(isset($row['utilizzatori_id'])){
            $segnalazione->setUtilizzatore(UserFactory::instance()->creaUtilizzatoreDaArray($row));
        }
        
        return $segnalazione;
    }

    
    
    public function salva(Segnalazione $mod_segnalazione){
        $query = "UPDATE segnalazioni SET 
            categorie_id = ?,
            priorita = ?,
            note = ?,
            status = ?,
            data_status = ?,
            operatori_id = ?
            
            WHERE segnalazioni.id = ?";
                    
        return $this->modificaDB($mod_segnalazione, $query);
    }
    
    
    private function modificaDB(Segnalazione $mod_segnalazione, $query){
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[modificaDB] impossibile " .
                    "inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();
       
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[modificaDB] impossibile " .
                    "inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('issssii',
                $mod_segnalazione->getCategoria()->getId(),
                $mod_segnalazione->getPriorita(),
                $mod_segnalazione->getNote(),
                $mod_segnalazione->getStatus(),
                $mod_segnalazione->getDataStatus()->format('Y-m-d H:i:s'),
                $mod_segnalazione->getOperatore()->getId(),
                $mod_segnalazione->getId())) {
            error_log("[modificaDB] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return 0;
        }

        
        if (!$stmt->execute()) {
            error_log("[modificaDB] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }

    
    /**
     * Salva una nuova segnalazione sul DB
     * @param Segnalazione $segnalazione la segnalazione da salvare
     * @return boolean true se il salvataggio va a buon fine, false altrimenti
     */
    public function salvaNuovaSegnalazione(Segnalazione $nuova_segnalazione, User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaNuovaSegnalazione] impossibile " .
                    "inizializzare il database");
            $mysqli->close();
            return 0;
        }
        
        $stmt1 = $mysqli->stmt_init();
        $stmt2 = $mysqli->stmt_init();
        //$stmt3 = $mysqli->stmt_init();
              
        $query_insert_segnalazioni = "INSERT INTO segnalazioni (
            id,
            numero,
            priorita,
            status,
            data_creazione,
            data_status,
            oggetto,
            descrizione,
            note,
            categorie_id,
            operatori_id,
            utilizzatori_id)
            values (default, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $query_update_numero_segnalazione = "UPDATE segnalazioni SET 
            numero = ?
            WHERE id = ?";
 
        
        $stmt1->prepare($query_insert_segnalazioni);
        if (!$stmt1) {
            error_log("[salvaNuovaSegnalazione] impossibile " .
                    "inizializzare il prepared statement n 1");
            $mysqli->close();
            return 0;
        }

        $stmt2->prepare($query_update_numero_segnalazione);
        if (!$stmt2) {
            error_log("[salvaNuovaSegnalazione] impossibile " .
                    "inizializzare il prepared statement n 2");
            $mysqli->close();
            return 0;
        }

       
        // variabili da collegare agli statements
        $numero = date("ymd");
        $segnalazioni_id = 0;
        $operatori_id = 1;
        

       
        if (!$stmt1->bind_param('ssssssssiii', 
 
            $numero,
            $nuova_segnalazione->getPriorita(),
            $nuova_segnalazione->getStatus(),
            $nuova_segnalazione->getDataCreazione()->format('Y-m-d H:i:s'),
            $nuova_segnalazione->getDataStatus()->format('Y-m-d H:i:s'),
            $nuova_segnalazione->getOggetto(),
            $nuova_segnalazione->getDescrizione(),
            $nuova_segnalazione->getNote(),
            $nuova_segnalazione->getCategoria()->getId(),

            $operatori_id,
            $user->getId()            
            
                )) {
            error_log("[salvaNuovaSegnalazione] impossibile " .
                    "effettuare il binding in input stmt1");
            $mysqli->close();
            return 0;
        }
        
        
        if (!$stmt2->bind_param('si',
                $numero,
                $segnalazioni_id)) 
            {
            error_log("[salvaNuovaSegnalazione] impossibile " .
                    "effettuare il binding in input stmt2");
            $mysqli->close();
            return 0;
        }
        

        
        // inizio la transazione
        $mysqli->autocommit(false);

        if (!$stmt1->execute()) {
                error_log("[salvaNuovaSegnalazione] impossibile " .
                        "eseguire lo statement 1");
                $mysqli->rollback();
                $mysqli->close();
                return 0;
            }

        
        $segnalazioni_id = $stmt1->insert_id;
        $numero = date("ymd").$stmt1->insert_id;   
       
        
        if (!$stmt2->execute()) {
                error_log("[salvaNuovaSegnalazione] impossibile " .
                        "eseguire lo statement 2");
                $mysqli->rollback();
                $mysqli->close();
                return 0;
            }    
        

        // tutto ok, posso rendere persistente il salvataggio
        $mysqli->commit();
        $mysqli->autocommit(true);
        $mysqli->close();

        //return true;
        return $stmt1->affected_rows;
             
    }
   
}

?>
