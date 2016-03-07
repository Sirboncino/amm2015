<?php
include_once 'servizio.php';
include_once 'db.php';

/**
 * Classe per creare oggetti di tipo Servizio
 *
 * @author *r*t*
 */
class ServizioFactory {
    
    private static $singleton;
    
    private function __constructor(){
    }
    
    
    /**
     * Restiuisce un singleton per creare Settore
     * @return \ServizioFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new ServizioFactory();
        }
        
        return self::$singleton;
    }
    
    /**
     * Restituisce la lista di tutti i Servizi
     * @return array|\Servizi
     */
    public function &getListaServizi(){
        
        $lista_servizi = array();
        $query = "SELECT * FROM servizi";
        $mysqli = Db::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaServizi] impossibile inizializzare il database");
            $mysqli->close();
            return $ser;
        }
        $result = $mysqli->query($query);
        if($mysqli->errno > 0){
            error_log("[getListaServizi] impossibile eseguire la query");
            $mysqli->close();
            return $ser;
        }
        
        while($row = $result->fetch_array()){
            $lista_servizi[] = self::getServizio($row);
        }
        
        $mysqli->close();
        return $lista_servizi;
    }
    
    
    
    public function cercaServizioPerId($id){
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }

        $servizi = array();
        
        $query = "SELECT 
            servizi.id servizi_id,
            servizi.nome servizi_nome
            
            FROM servizi
                        
            WHERE servizi.id = ?";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaServizioPerId] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $servizi;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cercaServizioPerId] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $servizi;
        }

        if (!$stmt->bind_param('i', $intval)) {
            error_log("[cercaServizioPerId] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $servizi;
        }
    
        $servizi = self::caricaServiziDaStmt($stmt);
        
        if(count($servizi > 0)){
            $mysqli->close();
            return $servizi[0];
        }else{
            $mysqli->close();
            return null;
        }       
    } 
    
        
    /**
     * Carica i servizi eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function &caricaServiziDaStmt(mysqli_stmt $stmt) {
        
        $servizi = array();
        
            // eseguiamo la query
        if (!$stmt->execute()) {
            error_log("[caricaServiziDaStmt] impossibile " 
                    ."eseguire lo statement");
            return null;
        }

        $row = array();

        $bind = $stmt->bind_result(
                $row['servizi_id'], 
                $row['servizi_nome']);
         
        if (!$bind) {
            error_log("[caricaServiziDaStmt] impossibile " 
                    . "effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $servizi[] = self::creaServizioDaArray($row);
        }
              
        $stmt->close();
       
        return $servizi;
    }

    
    /**
     * Crea un Servizio da una riga di DB
     * @param type $row
     */
    public function creaServizioDaArray($row){
        $ser = new Servizio();
        $ser->setId($row['servizi_id']);
        $ser->setNome($row['servizi_nome']);
        return $ser;
    }
    
    /**
     * Crea un oggetto di tipo Servizio a partire da una riga del DB
     * @param type $row
     * @return \Servizio
     */
    private function getServizio($row){
        $servizio = new Servizio();
        $servizio->setId($row['id']);
        $servizio->setNome($row['nome']);
        return $servizio;
    }
   
}

?>
