<?php

include_once 'controller/base_controller.php';
include_once 'controller/amministratore_controller.php';
include_once 'controller/operatore_controller.php';
include_once 'controller/utilizzatore_controller.php';

date_default_timezone_set("Europe/Rome");
// punto unico di accesso all'applicazione
FrontController::dispatch($_REQUEST);

/**
 * Classe che controlla il punto unico di accesso all'applicazione
 * @author *r*t*
 */
class FrontController {

    /**
     * Gestore delle richieste al punto unico di accesso all'applicazione
     * @param array $request i parametri della richiesta
     */
    public static function dispatch(&$request) {
        // inizializziamo la sessione 
        session_start();
        if (isset($request["page"])) {

            switch ($request["page"]) {
                case "login":
                    // la pagina di login e' accessibile a tutti,
                    // la facciamo gestire al BaseController
                    $controller = new BaseController();
                    $controller->handleInput($request);
                    break;

                // amministratore
                case 'amministratore':
                    // la pagina degli amministratori e' accessibile solo
                    // agli amminstratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new AmministratoreController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Amministratore) {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;
                
                // operatore
                case 'operatore':
                    // la pagina degli operatori e' accessibile solo
                    // agli operatori e agli amminstratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new OperatoreController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Operatore) {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;

                // cliente
                case 'utilizzatore':
                    // la pagina dei clienti e' accessibile solo
                    // agli utilizzatori clienti e agli amminstratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new UtilizzatoreController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Utilizzatore) {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;                    
                
                default:
                    self::write404();
                    break;
            }
        } else {
            self::write404();
        }
    }

    /**
     * Crea una pagina di errore quando il path specificato non esiste
     */
    public static function write404() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('error.php');
        exit();
    }

    /**
     * Crea una pagina di errore quando l'utente non ha i privilegi 
     * per accedere alla pagina
     */
    public static function write403() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('error.php');
        exit();
    }

}

?>
