<?php
include_once 'categoria.php';
include_once 'db.php';

/**
 * Classe per creare oggetti di tipo Categoria
 *
 * @author *r*t*
 */
class CategoriaFactory {
    
    private static $singleton;
    
    private function __constructor(){
    }
    
    
    /**
     * Restiuisce un singleton per creare una Categoria
     * @return \CategoriaFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new CategoriaFactory();
        }
        
        return self::$singleton;
    }
    
    
    /**
     * Restituisce la lista di tutte le Categorie
     * @return array|\lista_categorie
     */
    public function &getListaCategorie(){
        
        $lista_categorie = array();
        $query = "SELECT * FROM categorie";
        $mysqli = Db::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaCategorie] impossibile inizializzare il database");
            $mysqli->close();
            return $lista_categorie;
        }
        $result = $mysqli->query($query);
        if($mysqli->errno > 0){
            error_log("[getListaCategorie] impossibile eseguire la query");
            $mysqli->close();
            return $lista_categorie;
        }
        
        while($row = $result->fetch_array()){
            $lista_categorie[] = self::getCategoria($row);
        }
        
        $mysqli->close();
        return $lista_categorie;
    }
    
    
    public function cercaCategoriaPerId($id){
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }

        $categorie = array();
        
        $query = "SELECT 
            categorie.id categorie_id,
            categorie.nome categorie_nome
            
            FROM categorie
                        
            WHERE categorie.id = ?";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaCategoriaPerId] impossibile "
                    . "inizializzare il database");
            $mysqli->close();
            return $categorie;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cercaCategoriaPerId] impossibile "
                    . "inizializzare il prepared statement");
            $mysqli->close();
            return $categorie;
        }

        if (!$stmt->bind_param('i', $intval)) {
            error_log("[cercaCategoriaPerId] impossibile " 
                    . "effettuare il binding in input");
            $mysqli->close();
            return $categorie;
        }
    
        $categorie = self::caricaCategorieDaStmt($stmt);
        
        if(count($categorie > 0)){
            $mysqli->close();
            return $categorie[0];
        }else{
            $mysqli->close();
            return null;
        }       
    } 
    

    /**
     * Carica le segnalazioni eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function &caricaCategorieDaStmt(mysqli_stmt $stmt) {
        
        $categorie = array();
        
            // eseguiamo la query
        if (!$stmt->execute()) {
            error_log("[caricaCategorieDaStmt] impossibile " 
                    ."eseguire lo statement");
            return null;
        }

        $row = array();

        $bind = $stmt->bind_result(
                $row['categorie_id'], 
                $row['categorie_nome']);
         
        if (!$bind) {
            error_log("[caricaCategorieDaStmt] impossibile " 
                    . "effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $categorie[] = self::creaCategoriaDaArray($row);
        }
        
        $stmt->close();
        return $categorie;
    }

   
    /**
     * Crea un oggetto di tipo Categoria a partire da una riga del DB
     * @param type $row
     * @return \Categoria
     */
    public function creaCategoriaDaArray($row) {
        $categoria = new Categoria();
        
        $categoria->setId($row['categorie_id']);
        $categoria->setNome($row['categorie_nome']);

        return $categoria;
    }

    
    /**
     * Crea un oggetto di tipo Categoria a partire da una riga del DB
     * @param type $row
     * @return \Categoria
     */
    private function getCategoria($row){
        $categoria = new Categoria();
        $categoria->setId($row['id']);
        $categoria->setNome($row['nome']);
        return $categoria;
    }
   
}

?>
