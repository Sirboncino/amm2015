<?php
include_once 'base_controller.php';
include_once basename(__DIR__) . '/../model/user_factory.php';


/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa
 * agli Operatori e Utilizzatori da parte di utenti con ruolo di Amministratore 
 *
 * @author *r*t*
 */
class AmministratoreController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Metodo per gestire l'input dell'utente. 
     * @param type $request la richiesta da gestire
     */
    public function handleInput(&$request) {

        // creo il descrittore della vista
        $vd = new ViewDescriptor();

        // imposto la pagina
        $vd->setPagina($request['page']);

        // imposto il token per impersonare un utente (nel caso lo stia facendo)
        $this->setImpToken($vd, $request);

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);

            // verifico quale sia la sottopagina della categoria dell'utente
            // da servire ed imposto il descrittore della vista per caricare 
            // i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {

                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoPagina('anagrafica');
                        break;

                    // Utenti Operatori da gestire
                    case 'gestione_operatori':
                        $operatori = UserFactory::instance()->getListaOperatori();
                        $vd->setSottoPagina('gestione_operatori');
                        break;
                                        
                    // Creazione di un nuovo Operatore
                    case 'operatore_crea':
                        $msg = array();
                        $operatori = UserFactory::instance()->getListaOperatori();
                        if (!isset($request['cmd'])) {
                            $vd->setSottoPagina('gestione_operatori');
                        } else {
                            $vd->setSottoPagina('operatore_crea');
                        }
                        break;
                    
                    // Modifica di un Operatore
                    case 'operatore_modifica':
                        $msg = array();
                        $operatori = UserFactory::instance()->getListaOperatori();
                        $mod_operatore = $this->getOperatore($request, $msg);
                        if (!isset($mod_operatore)) {
                            $vd->setSottoPagina('gestione_operatori');
                        } else {
                            $vd->setSottoPagina('operatore_modifica');
                        }
                        break;
                    
                    // Utenti utilizzatori da gestire
                    case 'gestione_utilizzatori':
                        $utilizzatori = UserFactory::instance()->getListaUtilizzatori();
                        $servizi = ServizioFactory::instance()->getListaServizi();
                        $vd->setSottoPagina('gestione_utilizzatori');
                        break;
                    
                    // Creazione di un nuovo Utilizzatore
                    case 'utilizzatore_crea':
                        $msg = array();
                        $utilizzatori = UserFactory::instance()->getListaUtilizzatori();
                        $servizi = ServizioFactory::instance()->getListaServizi();
                        if (!isset($request['cmd'])) {
                            $vd->setSottoPagina('gestione_utilizzatori');
                        } else {
                            $vd->setSottoPagina('utilizzatore_crea');
                        }
                        break;
                    
                    // Modifica di un Utilizzatore
                    case 'utilizzatore_modifica':
                        $msg = array();
                        $utilizzatori = UserFactory::instance()->getListaUtilizzatori();
                        $servizi = ServizioFactory::instance()->getListaServizi();
                        $mod_utilizzatore = $this->getUtilizzatore($request, $msg);
                        if (!isset($mod_utilizzatore)) {
                            $vd->setSottoPagina('gestione_utilizzatori');
                        } else {
                            $vd->setSottoPagina('utilizzatore_modifica');
                        }
                        break;
        
                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }


            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
        
                    // modifica delle informazioni di contatto
                    case 'contatti':
                        $msg = array();
                        $this->aggiornaContatti($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Contatti aggiornati");
                        $this->showHomeUtente($vd);
                        break;
                            
                    // modifica della password
                    case 'password':
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeUtente($vd);
                        break;
                    
                    // richesta di visualizzazione del form 
                    // per la creazione di un nuovo Operatore 
                    case 'o_crea':
                        $operatori = UserFactory::instance()->getListaOperatori();
                        $vd->setSottoPagina('operatore_crea');
                        $this->showHomeUtente($vd);
                        break;
                    
                    // l'utente amministratore non vuole creare (o modificare) 
                    // l'Operatore selezionato
                    case 'o_annulla':
                        $vd->setSottoPagina('gestione_operatori');
                        $this->showHomeUtente($vd);
                        break;
                    
                    // creazione di un nuovo Operatore
                    case 'o_nuovo':
                        $msg = array();
                        $nuovo_operatore = new Operatore();
                        $this->nuovoOperatore($nuovo_operatore, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Nuovo Operatore creato");
                        if (count($msg) == 0) {
                            $vd->setSottoPagina('gestione_operatori');
                            if (UserFactory::instance()->salvaNuovoOperatore($nuovo_operatore) != 1) {
                                $msg[] = '<li>- Operatore NON creato </li>';
                            }
                        }
                        $operatori = UserFactory::instance()->getListaOperatori();
                        $this->showHomeUtente($vd);
                        break;
                    
                    // salvataggio delle modifiche ad un Operatore esistente
                    case 'o_salva':
                        $msg = array();
                        if (isset($request['operatore'])) {
                            $intVal = filter_var($request['operatore'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_operatore = $this->cercaOperatorePerId($intVal, $operatori);
                                $this->updateOperatore($mod_operatore, $request, $msg);
                                if (count($msg) == 0 && UserFactory::instance()->salva($mod_operatore) != 1) {
                                    $msg[] = '<li>- Operatore NON salvato </li>';
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Operatore aggiornato");
                                if (count($msg) == 0) {
                                    $vd->setSottoPagina('gestione_operatori');
                                }
                            }
                        } else {
                            $msg[] = '<li>- Operatore non specificato </li>';
                        }
                        $this->showHomeUtente($vd);
                        break;    
                    
                    // richesta di visualizzazione del form 
                    // per la creazione di un nuovo Utilizzatore 
                    case 'u_crea':
                        $utilizzatori = UserFactory::instance()->getListaUtilizzatori();
                        $servizi = ServizioFactory::instance()->getListaServizi();
                        $vd->setSottoPagina('utilizzatore_crea');
                        $this->showHomeUtente($vd);
                        break;
                    
                    // l'utente amministratore non vuole creare (o modificare) 
                    // l'Utilizzatore selezionato
                    case 'u_annulla':
                        $vd->setSottoPagina('gestione_utilizzatori');
                        $this->showHomeUtente($vd);
                        break;
                        
                    // creazione di un nuovo Utilizzatore
                    case 'u_nuovo':
                        $msg = array();
                        $nuovo_utilizzatore = new Utilizzatore();
                        $this->nuovoUtilizzatore($nuovo_utilizzatore, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Nuovo Utilizzatore creato");
                        if (count($msg) == 0) {
                            $vd->setSottoPagina('gestione_utilizzatori');
                            if (UserFactory::instance()->salvaNuovoUtilizzatore($nuovo_utilizzatore) != 1) {
                                $msg[] = '<li>- Utilizzatore NON creato</li>';
                            }
                        }
                        $utilizzatori = UserFactory::instance()->getListaUtilizzatori();
                        $this->showHomeUtente($vd);
                        break;
                        
                    // salvataggio delle modifiche ad un Utilizzatore esistente
                    case 'u_salva':
                        $msg = array();
                        if (isset($request['utilizzatore'])) {
                            $intVal = filter_var($request['utilizzatore'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_utilizzatore = $this->cercaUtilizzatorePerId($intVal, $utilizzatori);
                                $this->updateUtilizzatore($mod_utilizzatore, $request, $msg);
                                if (count($msg) == 0 && UserFactory::instance()->salva($mod_utilizzatore) != 1) {
                                    $msg[] = '<li>- Utilizzatore NON salvato </li>';
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Utilizzatore aggiornato");
                                if (count($msg) == 0) {
                                    $vd->setSottoPagina('gestione_utilizzatori');
                                }
                            }
                        } else {
                            $msg[] = '<li> Utilizzatore non specificato </li>';
                        }
                        $this->showHomeUtente($vd);
                        break;    

                    // default
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare 
                // la vista
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }

        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }

        
    /**
     * Restituisce l'Operatore specificato dall'utente tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @return Operatore - l'Operatore selezionato, null se non e' stato trovato
     */
    private function getOperatore(&$request, &$msg) {
        if (isset($request['operatore'])) {
            $operatore_id = filter_var($request['operatore'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $operatore = UserFactory::instance()->cercaUtentePerId($operatore_id, User::Operatore);
            if ($operatore == null) {
                $msg[] = "L'Operatore selezionato non &egrave; corretto</li>";
            }
            return $operatore;
        } else {
            return null;
        }
    }

        
    /**
     * Restituisce l'Utilizzatore specificato dall'utente tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @return Utilizzatore - l'Utilizzatore selezionato, null se non e' stato trovato
     */
    private function getUtilizzatore(&$request, &$msg) {
        if (isset($request['utilizzatore'])) {
            $utilizzatore_id = filter_var($request['utilizzatore'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $utilizzatore = UserFactory::instance()->cercaUtentePerId($utilizzatore_id, User::Utilizzatore);
            if ($utilizzatore == null) {
                $msg[] = "L'Utilizzatore selezionato non &egrave; corretto</li>";
            }
            return $utilizzatore;
        } else {
            return null;
        }
    }

    
    /**
     * Crea un nuovo Operatore in base ai parametri specificati
     * dall'utente Amministratore
     * @param $nuovo_operatore - l'Operatore da creare
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function nuovoOperatore($nuovo_operatore, &$request, &$msg) {
        
        if (isset($request['cognome']) && $request['cognome']!= '') {
            $nuovo_operatore->setCognome($request['cognome']);
        } else {
            $msg[] = "<li>Inserire il cognome</li>";
        }
    
        if (isset($request['nome']) && $request['nome']!= '') {
            $nuovo_operatore->setNome($request['nome']);
        } else {
            $msg[] = "<li>Inserire il nome</li>";
        }
    
        if (isset($request['username'])) {
              if (!$nuovo_operatore->setUsername($request['username'])) {
                $msg[] = '<li>Lo "Username" specificato non &egrave; corretto</li>';
            }
        }

        $nuovo_operatore->setAttivo($request['attivo']);
        
        if (isset($request['email']) and $request['email']!= '') {
            if (!$nuovo_operatore->setEmail($request['email'])) {
                $msg[] = '<li>L\'indirizzo email specificato non &egrave; corretto</li>';
            }
        }
        
        $nuovo_operatore->setTelefono($request['telefono']);
        
        $nuovo_operatore->setCellulare($request['cellulare']);
               
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$nuovo_operatore->setPassword($request['pass1'])) {
                    $msg[] = '<li>Il formato della password non &egrave; corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }

    }
    
    
    /**
     * Crea un nuovo Utilizzatore in base ai parametri specificati
     * dall'utente Amministratore
     * @param $nuovo_utilizzatore - l'Utilizzatore da creare
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function nuovoUtilizzatore($nuovo_utilizzatore, &$request, &$msg) {
        
        if (isset($request['servizio'])) {
            $servizio = ServizioFactory::instance()->cercaServizioPerId($request['servizio']);
            //$insegnamento = InsegnamentoFactory::instance()->creaInsegnamentoDaCodice($request['insegnamento']);
            if (isset($servizio)) {
                $nuovo_utilizzatore->setServizio($servizio);
            } else {
                $msg[] = "<li>Servizio di appartenenza non trovato</li>";
            }
        }

        if (isset($request['cognome']) && $request['cognome']!= '') {
            $nuovo_utilizzatore->setCognome($request['cognome']);
        } else {
            $msg[] = "<li>Cognome NON inserito</li>";
        }
    
        if (isset($request['nome']) && $request['nome']!= '') {
            $nuovo_utilizzatore->setNome($request['nome']);
        } else {
            $msg[] = "<li>Nome NON inserito</li>";
        }
    
        if (isset($request['username'])) {
              if (!$nuovo_utilizzatore->setUsername($request['username'])) {
                $msg[] = '<li>Username specificato NON corretto</li>';
            }
        }
        
        $nuovo_utilizzatore->setAttivo($request['attivo']);
        
        if (isset($request['email']) and $request['email']!= '') {
            if (!$nuovo_utilizzatore->setEmail($request['email'])) {
                $msg[] = '<li>Indirizzo email specificato NON corretto</li>';
            }
        }
        
        $nuovo_utilizzatore->setTelefono($request['telefono']);
        
        $nuovo_utilizzatore->setCellulare($request['cellulare']);
               
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$nuovo_utilizzatore->setPassword($request['pass1'])) {
                    $msg[] = '<li>Formato della password NON corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
    }
    

    /**
     * Ricerca un Operatore per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $operatori - un array di Operatori
     * @return operatore con l'id specificato se presente nella lista,
     * null altrimenti
     */
    private function cercaOperatorePerId($id, &$operatori) {
        foreach ($operatori as $operatore) {
            if ($operatore->getId() == $id) {
                return $operatore;
            }
        }
        return null;
    }
 
    
    /**
     * Ricerca un Utilizzatore per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $utilizzatori - un array di Utilizzatori
     * @return utilizzatore con l'id specificato se presente nella lista,
     * null altrimenti
     */
    private function cercaUtilizzatorePerId($id, &$utilizzatori) {
        foreach ($utilizzatori as $utilizzatore) {
            if ($utilizzatore->getId() == $id) {
                return $utilizzatore;
            }
        }
        return null;
    }
    
    
    
    /**
     * Aggiorna i dati relativi ad un Operatore
     * in base ai parametri specificati dall'utente Amministratore
     * @param Operatore $mod_operatore -  l'Operatore da modificare
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function updateOperatore($mod_operatore, &$request, &$msg) {
        $mod_operatore->setRuolo(2);
        
        if (isset($request['cognome']) && $request['cognome']!= '') {
            $mod_operatore->setCognome($request['cognome']);
        } else {
            $msg[] = "<li>Cognome NON inserito</li>";
        }
    
        if (isset($request['nome']) && $request['nome']!= '') {
            $mod_operatore->setNome($request['nome']);
        } else {
            $msg[] = "<li>Nome NON inserito</li>";
        }
    
        if (isset($request['username'])) {
              if (!$mod_operatore->setUsername($request['username'])) {
                $msg[] = '<li>Username specificato NON corretto</li>';
            }
        }
 
        $mod_operatore->setAttivo($request['attivo']);
        
        if (isset($request['email']) && $request['email']!= '') {
            if (!$mod_operatore->setEmail($request['email'])) {
                $msg[] = '<li>Indirizzo email specificato NON corretto</li>';
            }
        }
        
        $mod_operatore->setTelefono($request['telefono']);
        
        $mod_operatore->setCellulare($request['cellulare']);
        
        if ($request['pass1']!= '') {
        
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$mod_operatore->setPassword($request['pass1'])) {
                    $msg[] = '<li>Formato della password NON corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
        }
    }


    /**
     * Aggiorna i dati relativi ad un Utilizzatore
     * in base ai parametri specificati dall'utente Amministratore
     * @param Utilizzatore $mod_utilizzatore -  l'Utilizzatore da modificare
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function updateUtilizzatore($mod_utilizzatore, &$request, &$msg) {
        $mod_utilizzatore->setRuolo(3);
               
        if (isset($request['servizio'])) {
            $servizio = ServizioFactory::instance()->cercaServizioPerId($request['servizio']);
            if (isset($servizio)) {
                $mod_utilizzatore->setServizio($servizio);
            } else {
                $msg[] = "<li>Servizio di appartenenza non trovato</li>";
            }
        }
                
        if (isset($request['cognome']) && $request['cognome']!= '') {
            $mod_utilizzatore->setCognome($request['cognome']);
        } else {
            $msg[] = "<li>Cognome NON inserito</li>";
        }
    
        if (isset($request['nome']) && $request['nome']!= '') {
            $mod_utilizzatore->setNome($request['nome']);
        } else {
            $msg[] = "<li>Nome NON inserito</li>";
        }
    
        if (isset($request['username'])) {
              if (!$mod_utilizzatore->setUsername($request['username'])) {
                $msg[] = '<li>Username specificato NON corretto</li>';
            }
        }
      
        $mod_utilizzatore->setAttivo($request['attivo']);
        
        if (isset($request['email']) && $request['email']!= '') {
            if (!$mod_utilizzatore->setEmail($request['email'])) {
                $msg[] = '<li>Indirizzo email specificato NON corretto</li>';
            }
        }
        
        $mod_utilizzatore->setTelefono($request['telefono']);
        
        $mod_utilizzatore->setCellulare($request['cellulare']);
        
        if ($request['pass1']!= '') {
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$mod_utilizzatore->setPassword($request['pass1'])) {
                    $msg[] = '<li>Formato della password NON corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
        }else{
            
        }
     
    }

}

?>
