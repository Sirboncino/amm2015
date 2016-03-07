<?php
include_once 'base_controller.php';
include_once basename(__DIR__) . '/../model/servizio_factory.php';
include_once basename(__DIR__) . '/../model/segnalazione_factory.php';
include_once basename(__DIR__) . '/../model/user_factory.php';
include_once basename(__DIR__) . '/../model/categoria_factory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa
 * agli Utilizzatori da parte di utenti con ruolo 
 * Utilizzatore o Amministratore 
 *
 * @author *r*t*
 */
class UtilizzatoreController extends BaseController {

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
                    
                    // segnalazioni aperte
                    case 'segnalazioni_aperte':
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerUtilizzatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vd->setSottoPagina('segnalazioni_aperte');
                        break;
                    
                    // creazione di una nuova segnalazione
                    case 'segnalazione_crea':
                        $msg = array();
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerUtilizzatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        if (!isset($request['cmd'])) {
                            $vd->setSottoPagina('segnalazioni_aperte');
                        } else {
                            $vd->setSottoPagina('segnalazione_crea');
                        }
                        break;
                                            
                    // visualizza dettaglio segnalazione
                    case 'segnalazione_vedi':
                        $msg = array();
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerUtilizzatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vedi_segnalazione = $this->getSegnalazione($request, $msg);
                        if (!isset($vedi_segnalazione)) {
                            $vd->setSottoPagina('segnalazioni_aperte');
                        } else {
                            $vd->setSottoPagina('segnalazione_vedi');
                        }
                        break;
                    
                    // visualizzazione elenco segnalazioni
                    case 'segnalazioni_ricerca':
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniPerUtilizzatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();

                        $vd->setSottoPagina('segnalazioni_ricerca');
                        $vd->addScript("../js/jquery-2.1.1.min.js");
                        $vd->addScript("../js/elenco_segnalazioni.js");
                                              
                        break;
                    
                    // gestione della richiesta ajax di filtro segnalazioni
                    case 'filtra_segnalazioni':
                        $vd->toggleJson();
                        $vd->setSottoPagina('segnalazioni_ricerca_json');
                        $errori = array();
                        
                        if (isset($request['categoria_segnalazione']) && ($request['categoria_segnalazione'] != '')) {
                            $categoria_id = filter_var($request['categoria_segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            
                            if($categoria_id == null){
                                $errori['categoria_segnalazione'] = "Specificare un identificatore valido";
                            }
                        } else {
                            $categoria_id = null;
                        }

                        if (isset($request['priorita']) && ($request['priorita'] != '')) {
                            $priorita = $request['priorita'];
                        }else{
                            $priorita = null;
                        }

                        if (isset($request['status']) && ($request['status'] != '')) {
                            $status = $request['status'];
                        }else{
                            $status = null;
                        }

                        if (isset($request['oggetto'])) {
                            $oggetto = $request['oggetto'];
                        }else{
                            $oggetto = null;
                        }
                        
                        if (isset($request['data_inizio'])) {
                            $data_inizio = $request['data_inizio'];
                            $data_inizio->format('Y-m-d H:i:s');
                        }else{
                            $data_inizio = null;
                        }
                        
                        if (isset($request['data_fine'])) {
                            $data_fine = $request['data_fine'];
                        }else{
                            $data_fine = date('Y-m-d H:i:s');
                        }
                        
                        $segnalazioni_trovate = SegnalazioneFactory::instance()->ricercaSegnalazioni(
                                $user, 
                                $categoria_id,
                                $priorita,
                                $status,
                                $oggetto,
                                $data_inizio,
                                $data_fine
                                );
                        
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
                    // per la visualizzazione del dettaglio della segnalazione 
                    case 's_vedi':
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerUtilizzatore($user);
                        if (isset($request['segnalazione'])) {
                            $intVal = filter_var($request['segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $vedi_segnalazione = $this->cercaSegnalazionePerId($intVal, $segnalazioni);
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;
                        
                    // richesta di visualizzazione del form 
                    // per la creazione di una nuova segnalazione 
                    case 's_crea':
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerUtilizzatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vd->setSottoPagina('segnalazione_crea');
                        $this->showHomeUtente($vd);
                        break;
                                      
                    // l'utente non vuole creare (o modificare) modificare 
                    // la segnalazione selezionata
                    case 's_annulla':
                        $vd->setSottoPagina('segnalazioni_aperte');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di una nuova segnalazione
                    case 's_nuova':
                        $msg = array();
                        $nuova_segnalazione = new Segnalazione();
                        $this->nuovaSegnalazione($nuova_segnalazione, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Segnalazione creata");
                        if (count($msg) == 0) {
                            $vd->setSottoPagina('segnalazioni_aperte');
                            if (SegnalazioneFactory::instance()->salvaNuovaSegnalazione($nuova_segnalazione, $user) != 1) {
                                $msg[] = '<li> Impossibile creare la segnalazione </li>';
                            }
                        }
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerUtilizzatore($user);
                        $this->showHomeUtente($vd);
                        break;
                    
                    // ricerca di una segnalazione
                    case 's_cerca':
                        $msg = array();
                        $this->creaFeedbackUtente($msg, $vd, "Lo implementiamo con il db, fai conto che abbia funzionato ;)");
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
     * Ricerca una segnalazione per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $segnalazioni un array di segnalazioni
     * @return Segnalazione - la segnalazione con l'id specificato se presente nella lista,
     * null altrimenti
     */
    private function cercaSegnalazionePerId($id, &$segnalazioni) {
        foreach ($segnalazioni as $segnalazione) {
            if ($segnalazione->getId() == $id) {
                return $segnalazione;
            }
        }
        return null;
    }

    
    /**
     * Restituisce la segnalazione specificata dall'utente tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @return Segnalazione la segnalazione selezionata, null se non e' stata trovata
     */
    private function getSegnalazione(&$request, &$msg) {
        if (isset($request['segnalazione'])) {
            $segnalazione_id = filter_var($request['segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $segnalazione = SegnalazioneFactory::instance()->cercaSegnalazionePerId($segnalazione_id);
            if ($segnalazione == null) {
                $msg[] = "La segnalazione selezionata non &egrave; corretta</li>";
            }
            return $segnalazione;
        } else {
            return null;
        }
    }


    /**
     * Crea una nuova Segnalazione in base ai parametri specificati dall'utente
     * @param segnalazione $nuova_segnalazione
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function nuovaSegnalazione($nuova_segnalazione, &$request, &$msg) {
        if (isset($request['categoria_segnalazione'])) {
            $categoria = CategoriaFactory::instance()->cercaCategoriaPerId($request['categoria_segnalazione']);
            if (isset($categoria)) {
                $nuova_segnalazione->setCategoria($categoria);
            } else {
                $msg[] = "<li>categoria non trovata</li>";
            }
        }
        
        $nuova_segnalazione->setPriorita($request['priorita']);

        $nuova_segnalazione->setStatus('nuova');

        // date/time corrente nel computer.
        $adesso = new DateTime();
        $adesso->format('Y-m-d H:i:s');
        $nuova_segnalazione->setDataCreazione($adesso);
        
        $nuova_segnalazione->setDataStatus($adesso);
        
        
        $nuova_segnalazione->setOggetto($request['oggetto']);
                
        $nuova_segnalazione->setDescrizione($request['testo_segnalazione']);
        $nuova_segnalazione->setNote('');
        
    }

}

?>
