<?php
include_once 'db.php';
include_once 'user.php';
include_once 'amministratore.php';
include_once 'operatore.php';
include_once 'utilizzatore.php';
include_once 'servizio_factory.php';

/**
 * Classe per la creazione degli utenti del sistema
 *
 * @author *r*t*
 */
class UserFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare utenti
     * @return \UserFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UserFactory();
        }

        return self::$singleton;
    }

    
    /**
     * Carica un utente tramite username e password
     * @param string $username
     * @param string $password
     * @return \User|\Amministratore|\Operatore|\Utilizzatore
     */
    public function caricaUtente($username, $password) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[loadUser] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        
        // prima cerco un amministratore
        $query = "SELECT 
            amministratori.id amministratori_id,
            amministratori.email amministratori_email,
            amministratori.username amministratori_username,
            amministratori.password amministratori_password,
            amministratori.attivo amministratori_attivo,
            amministratori.cognome amministratori_cognome,
            amministratori.nome amministratori_nome,
            amministratori.telefono amministratori_telefono,
            amministratori.cellulare amministratori_cellulare

            FROM amministratori 
            
            WHERE amministratori.username = ? AND amministratori.password = ?";
        
        // inizializzo il prepared statement
        $stmt = $mysqli->stmt_init();
        
        // preparo lo statement per l'esecuzione
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[loadUser] impossibile " .
                    "inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
            // collego i parametri della query con il loro tipo
        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile " .
                    "effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $amministratore = self::caricaAmministratoreDaStmt($stmt);
        if (isset($amministratore)) {
            // ho trovato un amministratore
            $mysqli->close();
            return $amministratore;
        }

        
        // ora cerco un operatore
        $query = "SELECT 
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare

            FROM operatori 
            
            WHERE operatori.username = ? AND operatori.password = ?";

        // inizializzo il prepared statement
        $stmt = $mysqli->stmt_init();
        
        // preparo lo statement per l'esecuzione
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[loadUser] impossibile " .
                    "inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile " .
                    "effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $operatore = self::caricaOperatoreDaStmt($stmt);
        if (isset($operatore)) {
            // ho trovato un operatore
            $mysqli->close();
            return $operatore;
        }
        
        
        // ora cerco un utilizzatore
        $query = "SELECT 
            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome

            FROM utilizzatori
            JOIN servizi ON utilizzatori.servizi_id = servizi.id
                        
            WHERE utilizzatori.username = ? AND utilizzatori.password = ?";
      
        // inizializzo il prepared statement
        $stmt = $mysqli->stmt_init();
        
        // preparo lo statement per l'esecuzione
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    "inizializzare il prepared statement ");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile " .
                    "effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $utilizzatore = self::caricaUtilizzatoreDaStmt($stmt);
        if (isset($utilizzatore)) {
            // ho trovato un utilizzatore
            $mysqli->close();
            return $utilizzatore;
        }
        
    }

    
    
    /**
     * Carica un amministratore eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaAmministratoreDaStmt(mysqli_stmt $stmt) {
            // eseguiamo la query
        if (!$stmt->execute()) {
            error_log("[caricaAmministratoreDaStmt] impossibile " .
                    "eseguire lo statement");
            return null;
        }

        $row = array();
        
        $bind = $stmt->bind_result(
                $row['amministratori_id'], 
                $row['amministratori_email'], 
                $row['amministratori_username'], 
                $row['amministratori_password'], 
                //$row['amministratori_scadenza_password'],
                //$row['amministratori_ultimo_login'],
                $row['amministratori_attivo'],
                $row['amministratori_cognome'], 
                $row['amministratori_nome'],
                $row['amministratori_telefono'],
                $row['amministratori_cellulare']);
        
        if (!$bind) {
            error_log("[caricaAmministratoreDaStmt] impossibile " .
                    "effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaAmministratoreDaArray($row);
    }

    
    /**
     * Crea un amministratore da una riga del db
     * @param type $row
     * @return \Amministratore
     */
    public function creaAmministratoreDaArray($row) {
        $amministratore = new Amministratore();
        $amministratore->setId($row['amministratori_id']);
        $amministratore->setEmail($row['amministratori_email']);
        $amministratore->setUsername($row['amministratori_username']);
        $amministratore->setPassword($row['amministratori_password']);
        //$amministratore->setScadenzaPassword($row['amministratori_scadenza_password']);
        //$amministratore->setUltimoLogin($row['amministratori_ultimo_login']);
        $amministratore->setAttivo($row['amministratori_attivo']);
        $amministratore->setCognome($row['amministratori_cognome']);
        $amministratore->setNome($row['amministratori_nome']);
        $amministratore->setTelefono($row['amministratori_telefono']);
        $amministratore->setCellulare($row['amministratori_cellulare']);
                
        $amministratore->setRuolo(User::Amministratore);
        
        return $amministratore;
    }

    
    /**
     * Carica un operatore eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaOperatoreDaStmt(mysqli_stmt $stmt) {
            // eseguiamo la query
        if (!$stmt->execute()) {
            error_log("[caricaOperatoreDaStmt] impossibile " .
                    "eseguire lo statement");
            return null;
        }

        $row = array();
        
        $bind = $stmt->bind_result(
                $row['operatori_id'], 
                $row['operatori_email'], 
                $row['operatori_username'], 
                $row['operatori_password'], 
                //$row['operatori_scadenza_password'],
                //$row['operatori_ultimo_login'],
                $row['operatori_attivo'],
                $row['operatori_cognome'], 
                $row['operatori_nome'],
                $row['operatori_telefono'],
                $row['operatori_cellulare']);
        
        if (!$bind) {
            error_log("[caricaOperatoreDaStmt] impossibile " .
                    "effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaOperatoreDaArray($row);
    }

    
    /**
     * Crea un operatore da una riga del db
     * @param type $row
     * @return \Operatore
     */
    public function creaOperatoreDaArray($row) {
        $operatore = new Operatore();
        $operatore->setId($row['operatori_id']);
        $operatore->setEmail($row['operatori_email']);
        $operatore->setUsername($row['operatori_username']);
        $operatore->setPassword($row['operatori_password']);
        //$operatore->setScadenzaPassword($row['operatori_scadenza_password']);
        //$operatore->setUltimoLogin($row['operatori_ultimo_login']);
        $operatore->setAttivo($row['operatori_attivo']);
        $operatore->setCognome($row['operatori_cognome']);
        $operatore->setNome($row['operatori_nome']);
        $operatore->setTelefono($row['operatori_telefono']);
        $operatore->setCellulare($row['operatori_cellulare']);
                
        $operatore->setRuolo(User::Operatore);
        
        return $operatore;
    }

       
    /**
     * Carica un utilizzatore eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaUtilizzatoreDaStmt(mysqli_stmt $stmt) {
            // eseguiamo la query
        if (!$stmt->execute()) {
            error_log("[caricaUtilizzatoreDaStmt] impossibile " .
                    "eseguire lo statement");
            return null;
        }

        $row = array();
        
        $bind = $stmt->bind_result(
                $row['utilizzatori_id'], 
                $row['utilizzatori_email'], 
                $row['utilizzatori_username'], 
                $row['utilizzatori_password'], 
                //$row['utilizzatori_scadenza_password'],
                //$row['utilizzatori_ultimo_login'],
                $row['utilizzatori_attivo'],
                $row['utilizzatori_cognome'], 
                $row['utilizzatori_nome'],
                $row['utilizzatori_telefono'],
                $row['utilizzatori_cellulare'],
                
                $row['servizi_id'],
                $row['servizi_nome']);
       
        if (!$bind) {
            error_log("[caricaUtilizzatoreDaStmt] impossibile " .
                    "effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaUtilizzatoreDaArray($row);
    }

    
    /**
     * Crea un utilizzatore da una riga del db
     * @param type $row
     * @return \Utilizzatore
     */
    public function creaUtilizzatoreDaArray($row) {
        $utilizzatore = new Utilizzatore();
        $utilizzatore->setId($row['utilizzatori_id']);
        $utilizzatore->setEmail($row['utilizzatori_email']);
        $utilizzatore->setUsername($row['utilizzatori_username']);
        $utilizzatore->setPassword($row['utilizzatori_password']);
        //$utilizzatore->setScadenzaPassword($row['utilizzatori_scadenza_password']);
        //$utilizzatore->setUltimoLogin($row['utilizzatori_ultimo_login']);
        $utilizzatore->setAttivo($row['utilizzatori_attivo']);
        $utilizzatore->setCognome($row['utilizzatori_cognome']);
        $utilizzatore->setNome($row['utilizzatori_nome']);
        $utilizzatore->setTelefono($row['utilizzatori_telefono']);
        $utilizzatore->setCellulare($row['utilizzatori_cellulare']);
                
        $utilizzatore->setRuolo(User::Utilizzatore);
        
        if (isset($row['servizi_id'])) {
            $utilizzatore->setServizio(ServizioFactory::instance()->creaServizioDaArray($row));
        }
        
        return $utilizzatore;
    }

    
    
    /**
     * Salva i dati relativi ad un utente sul db
     * @param User $user
     * @return il numero di righe modificate
     */
    public function salva(User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($user->getRuolo()) {
            case User::Amministratore:
                $count = $this->salvaAmministratore($user, $stmt);
                break;
            
            case User::Operatore:
                $count = $this->salvaOperatore($user, $stmt);
                break;
            
            case User::Utilizzatore:
                $count = $this->salvaUtilizzatore($user, $stmt);
        }

        $stmt->close();
        $mysqli->close();
        return $count;
    } 

    
    /**
     * Rende persistenti le modifiche all'anagrafica di un amministratore sul db
     * @param Amministratore $a l'utilizzatore considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaAmministratore(Amministratore $a, mysqli_stmt $stmt) {
        $query = "UPDATE amministratori SET
            email = ?,
            username = ?,
            password = ?,
            attivo = ?,
            cognome = ?,
            nome = ?,
            telefono = ?,
            cellulare = ?
                        
            WHERE amministratori.id = ?
            ";
            
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaAmministratore] impossibile " .
                    "inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('sssissssi',
                $a->getEmail(),
                $a->getUsername(),
                $a->getPassword(),
                //$a->getScadenzaPassword(),
                //$a->getUltimoLogin(),
                $a->getAttivo(),
                $a->getCognome(), 
                $a->getNome(),
                $a->getTelefono(), 
                $a->getCellulare(), 
                                
                $a->getId())) {
            error_log("[salvaAmministratore] impossibile " .
                    "effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[salvaAmministratore] impossibile " .
                    "eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    
    /**
     * Rende persistenti le modifiche all'anagrafica di un operatore sul db
     * @param Operatore $o l'utilizzatore considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaOperatore(Operatore $o, mysqli_stmt $stmt) {
        $query = "UPDATE operatori SET
            email = ?,
            username = ?,
            password = ?,
            attivo = ?,
            cognome = ?,
            nome = ?,
            telefono = ?,
            cellulare = ?
                        
            WHERE operatori.id = ?
            ";
            
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaOperatore] impossibile " .
                    "inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('sssissssi',
                $o->getEmail(),
                $o->getUsername(),
                $o->getPassword(),
                //$o->getScadenzaPassword(),//->format('Y-m-d H:i:s'),
                //$o->getUltimoLogin(),//->format('Y-m-d H:i:s'),
                $o->getAttivo(),
                $o->getCognome(), 
                $o->getNome(),
                $o->getTelefono(), 
                $o->getCellulare(), 
                                
                $o->getId())) {
            error_log("[salvaOperatore] impossibile " .
                    "effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[salvaOperatore] impossibile " .
                    "eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    
    /**
     * Rende persistenti le modifiche all'anagrafica di un utilizzatore sul db
     * @param Utilizzatore $u l'utilizzatore considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaUtilizzatore(Utilizzatore $u, mysqli_stmt $stmt) {
        $query = "UPDATE utilizzatori SET
            email = ?,
            username = ?,
            password = ?,
            attivo = ?,
            cognome = ?,
            nome = ?,
            telefono = ?,
            cellulare = ?,
            servizi_id = ?
            
            WHERE utilizzatori.id = ?
            ";
            
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaUtilizzatore] impossibile " .
                    "inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('sssissssii',
                $u->getEmail(),
                $u->getUsername(),
                $u->getPassword(),
                //$u->getScadenzaPassword(),
                //$u->getUltimoLogin(),
                $u->getAttivo(),
                $u->getCognome(), 
                $u->getNome(),
                $u->getTelefono(), 
                $u->getCellulare(), 
                $u->getServizio()->getId(), 
                
                $u->getId())) {
            error_log("[salvaUtilizzatore] impossibile " .
                    "effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[salvaUtilizzatore] impossibile " .
                    "eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    
    
    /**
     * Salva i dati relativi ad un utente sul db
     * @param User $user
     * @return il numero di righe modificate
     */
    public function cancella(User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cancella] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($user->getRuolo()) {
            //case User::Amministratore:
            //    $count = $this->cancellaAmministratore($user, $stmt);
            //    break;
            
            case User::Operatore:
                $count = $this->cancellaOperatore($user, $stmt);
                break;
            
            case User::Utilizzatore:
                $count = $this->cancellaUtilizzatore($user, $stmt);
        }

        $stmt->close();
        $mysqli->close();
        return $count;
    } 

    
    /**
     * Rende persistenti le modifiche all'anagrafica di un operatore sul db
     * @param Operatore $o l'utilizzatore considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function cancellaOperatore(Operatore $o, mysqli_stmt $stmt) {
        $query = "DELETE FROM operatori
                                    
            WHERE operatori.id = ?
            ";
            
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cancellaOperatore] impossibile " .
                    "inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('i',
                $o->getId())) {
            error_log("[cancellaOperatore] impossibile " .
                    "effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[cancellaOperatore] impossibile " .
                    "eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    
    
    /**        
     * Cerca un utente  per id
     * @param int $id
     * @return Amministartore o Operatore o Utilizzatore
     * un oggetto Amministartore o Operatore o Utilizzatore nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function cercaUtentePerId($id, $role) {
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        switch ($role) {
            case User::Amministratore:
                $query = "SELECT                    
                    amministratori.id amministratori_id,
                    amministratori.email amministratori_email,
                    amministratori.username amministratori_username,
                    amministratori.password amministratori_password,
                    amministratori.attivo amministratori_attivo,
                    amministratori.cognome amministratori_cognome,
                    amministratori.nome amministratori_nome,
                    amministratori.telefono amministratori_telefono,
                    amministratori.cellulare amministratori_cellulare

                    FROM amministratori 
            
                    WHERE amministratori.id = ?";
                
                 // inizializzo il prepared statement
                $stmt = $mysqli->stmt_init();
        
                // preparo lo statement per l'esecuzione
                $stmt->prepare($query);
                
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile " .
                            "inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile " .
                            "effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet =  self::caricaAmministratoreDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;

                
            case User::Operatore:
                $query = "SELECT  
                    operatori.id operatori_id,
                    operatori.email operatori_email,
                    operatori.username operatori_username,
                    operatori.password operatori_password,
                    operatori.attivo operatori_attivo,
                    operatori.cognome operatori_cognome,
                    operatori.nome operatori_nome,
                    operatori.telefono operatori_telefono,
                    operatori.cellulare operatori_cellulare

                    FROM operatori 
            
                    WHERE operatori.id = ?";
                
                // inizializzo il prepared statement
                $stmt = $mysqli->stmt_init();
        
                // preparo lo statement per l'esecuzione
                $stmt->prepare($query);
                
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile " .
                            "inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile " .
                            "effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet =  self::caricaOperatoreDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;
  
               
            case User::Utilizzatore:
                $query = "SELECT 
                    utilizzatori.id utilizzatori_id,
                    utilizzatori.email utilizzatori_email,
                    utilizzatori.username utilizzatori_username,
                    utilizzatori.password utilizzatori_password,
                    utilizzatori.attivo utilizzatori_attivo,
                    utilizzatori.cognome utilizzatori_cognome,
                    utilizzatori.nome utilizzatori_nome,
                    utilizzatori.telefono utilizzatori_telefono,
                    utilizzatori.cellulare utilizzatori_cellulare,

                    servizi.id servizi_id,
                    servizi.nome servizi_nome
            
                    FROM utilizzatori
                    JOIN servizi ON utilizzatori.servizi_id = servizi.id
 
                    WHERE utilizzatori.id = ?";    
               
                // inizializzo il prepared statement
                $stmt = $mysqli->stmt_init();
        
                // preparo lo statement per l'esecuzione
                $stmt->prepare($query);
                
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile " .
                            "inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile " .
                            "effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet =  self::caricaUtilizzatoreDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;
                
                
            default: return null;
        }
    }

    
    
    /**
     * Restituisce un array con gli Operatori presenti nel sistema
     * @return array
     */
    public function &getListaOperatori() {
        $operatori = array();
        
        $query = "SELECT  
            operatori.id operatori_id,
            operatori.email operatori_email,
            operatori.username operatori_username,
            operatori.password operatori_password,
            operatori.attivo operatori_attivo,
            operatori.cognome operatori_cognome,
            operatori.nome operatori_nome,
            operatori.telefono operatori_telefono,
            operatori.cellulare operatori_cellulare

            FROM operatori
            
            ORDER BY operatori.cognome, operatori.nome"; 
            
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaOperatori] impossibile inizializzare il database");
            $mysqli->close();
            return $operatori;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaOperatori] impossibile eseguire la query");
            $mysqli->close();
            return $operatori;
        }

        while ($row = $result->fetch_array()) {
            $operatori[] = self::creaOperatoreDaArray($row);
        }

        $mysqli->close();
        return $operatori;
    }

    
    
    /**
     * Salva un nuovo Operatore sul DB
     * @param $nuovo_operatore - Operatore da salvare
     * @return boolean true se il salvataggio va a buon fine, false altrimenti
     */
    public function salvaNuovoOperatore(Operatore $nuovo_operatore) {
        $query = "INSERT INTO operatori (
            id,
            email,
            username,
            password,
            attivo,
            cognome,
            nome,
            telefono,
            cellulare)
                        
            VALUES (default, ?, ?, ?, ?, ?, ?, ?, ?)";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaNuovoOperatore] impossibile " .
                    "inizializzare il database");
            $mysqli->close();
            return 0;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaNuovoOperatore] impossibile " .
                    "inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('sssissss',
                $nuovo_operatore->getEmail(),
                $nuovo_operatore->getUsername(),
                $nuovo_operatore->getPassword(),
                //$nuovo_operatore->getScadenzaPassword()->format('Y-m-d H:i:s'),
                //$nuovo_operatore->getUltimoLogin(),//->format('Y-m-d H:i:s'),
                $nuovo_operatore->getAttivo(),
                $nuovo_operatore->getCognome(), 
                $nuovo_operatore->getNome(),
                $nuovo_operatore->getTelefono(), 
                $nuovo_operatore->getCellulare())) {
            error_log("[salvaOperatore] impossibile " .
                    "effettuare il binding in input");
            return 0;
        }

                       
        // inizio la transazione
        $mysqli->autocommit(false);

        if (!$stmt->execute()) {
                error_log("[salvaNuovoOperatore] impossibile " .
                        "eseguire lo statement");
                $mysqli->rollback();
                $mysqli->close();
                return 0;
            }

        // tutto ok, posso rendere persistente il salvataggio
        $mysqli->commit();
        $mysqli->autocommit(true);
        $mysqli->close();

        //return true;
        return $stmt->affected_rows;
    
    }

     
    

    /**
     * Restituisce un array con gli Utilizzatori presenti nel sistema
     * @return array
     */
    public function &getListaUtilizzatori() {
        $utilizzatori = array();
        
        $query = "SELECT 
            utilizzatori.id utilizzatori_id,
            utilizzatori.email utilizzatori_email,
            utilizzatori.username utilizzatori_username,
            utilizzatori.password utilizzatori_password,
            utilizzatori.attivo utilizzatori_attivo,
            utilizzatori.cognome utilizzatori_cognome,
            utilizzatori.nome utilizzatori_nome,
            utilizzatori.telefono utilizzatori_telefono,
            utilizzatori.cellulare utilizzatori_cellulare,

            servizi.id servizi_id,
            servizi.nome servizi_nome
            
            FROM utilizzatori
            JOIN servizi ON utilizzatori.servizi_id = servizi.id
 
            ORDER BY utilizzatori.cognome, utilizzatori.nome";
            
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaUtilizzatori] impossibile inizializzare il database");
            $mysqli->close();
            return $utilizzatori;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaUtilizzatori] impossibile eseguire la query");
            $mysqli->close();
            return $utilizzatori;
        }

        while ($row = $result->fetch_array()) {
            $utilizzatori[] = self::creaUtilizzatoreDaArray($row);
        }

        $mysqli->close();
        return $utilizzatori;
    }

    
        
    
    /**
     * Salva un nuovo Utilizzatore sul DB
     * @param $nuovo_utilizzatore - Utilizzatore da salvare
     * @return boolean true se il salvataggio va a buon fine, false altrimenti
     */
    public function salvaNuovoUtilizzatore(Utilizzatore $nuovo_utilizzatore) {
        $query = "INSERT INTO utilizzatori (
            id,
            email,
            username,
            password,
            attivo,
            cognome,
            nome,
            telefono,
            cellulare,
            servizi_id)
                        
            VALUES (default, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaNuovoUtilizzatore] impossibile " .
                    "inizializzare il database");
            $mysqli->close();
            return 0;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaNuovoUtilizzatore] impossibile " .
                    "inizializzare il prepared statement");
            return 0;
        }

        
        if (!$stmt->bind_param('sssissssi',
                $nuovo_utilizzatore->getEmail(),
                $nuovo_utilizzatore->getUsername(),
                $nuovo_utilizzatore->getPassword(),
                $nuovo_utilizzatore->getAttivo(),
                $nuovo_utilizzatore->getCognome(), 
                $nuovo_utilizzatore->getNome(),
                $nuovo_utilizzatore->getTelefono(), 
                $nuovo_utilizzatore->getCellulare(), 
                $nuovo_utilizzatore->getServizio()->getId())) {
            error_log("[salvaNuovoUtilizzatore] impossibile " .
                    "effettuare il binding in input");
            return 0;
        }
 
        //var_dump($stmt);
        
        // inizio la transazione
        $mysqli->autocommit(false);

        if (!$stmt->execute()) {
                error_log("[salvaNuovoUtilizzatore] impossibile " .
                        "eseguire lo statement");
                $mysqli->rollback();
                $mysqli->close();
                return 0;
            }

        // tutto ok, posso rendere persistente il salvataggio
        $mysqli->commit();
        $mysqli->autocommit(true);
        $mysqli->close();

        //return true;
        return $stmt->affected_rows;
    
    }
    
}

?>
