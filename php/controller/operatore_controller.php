<?php
include_once 'base_controller.php';
include_once basename(__DIR__) . '/../model/user_factory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa
 * agli Operatore da parte di utenti con ruolo 
 * Utilizzatore o Amministratore 
 *
 * @author *r*t*
 */
class OperatoreController extends BaseController {

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

                    // segnalazioni nuove da prendere in carico
                    case 'segnalazioni_nuove':
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniNuove();
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vd->setSottoPagina('segnalazioni_nuove');
                        break;
                                       
                    // segnalazioni aperte in carico all'operatore
                    case 'segnalazioni_aperte':
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerOperatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vd->setSottoPagina('segnalazioni_aperte');
                        break;
                    
                    // visualizza dettaglio nuova segnalazione e permette 
                    // di prenderla in gestione
                    case 'segnalazione_prendi':
                        $msg = array();
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniNuove();
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vedi_segnalazione = $this->getSegnalazione($request, $msg);
                        if (!isset($vedi_segnalazione)) {
                            $vd->setSottoPagina('segnalazioni_nuove');
                        } else {
                            $vd->setSottoPagina('segnalazione_prendi');
                        }
                        break;
                                           
                    // modifica di una segnalazione
                    case 'segnalazione_modifica':
                        $msg = array();
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerOperatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $mod_segnalazione = $this->getSegnalazione($request, $msg);
                        if (!isset($mod_segnalazione)) {
                            $vd->setSottoPagina('segnalazioni_aperte');
                        } else {
                            $vd->setSottoPagina('segnalazione_modifica');
                        }
                        break;
                     
                    // visualizzazione elenco segnalazioni
                    case 'segnalazioni_ricerca':
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vd->setSottoPagina('segnalazioni_ricerca');
                        break;                        
                    
                     // visualizza dettaglio segnalazione
                    case 'segnalazione_vedi':
                        $msg = array();
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vedi_segnalazione = $this->getSegnalazione($request, $msg);
                        if (!isset($vedi_segnalazione)) {
                            $vd->setSottoPagina('segnalazioni_ricerca');
                        } else {
                            $vd->setSottoPagina('segnalazione_vedi');
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
                                
                    // prende in gestione una nuova segnalazione
                    case 'prendi_nuova':
                        $msg = array();
                        if (isset($request['segnalazione'])) {
                            $intVal = filter_var($request['segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_segnalazione = $this->cercaSegnalazionePerId($intVal, $segnalazioni);
                                $this->prendiSegnalazione($mod_segnalazione, $request, $user, $msg);
                                if (count($msg) == 0 && SegnalazioneFactory::instance()->salva($mod_segnalazione) != 1) {
                                    $msg[] = '<li> Impossibile salvare la segnalazione </li>';
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Segnalazione presa in gestione");
                                if (count($msg) == 0) {
                                    $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniNuove();
                                    $categorie = CategoriaFactory::instance()->getListaCategorie();
                                    $vd->setSottoPagina('segnalazioni_nuove');
                                }
                            }
                        } else {
                            $msg[] = '<li> Segnalazione non specificata </li>';
                        }
                        $this->showHomeUtente($vd);
                        break;    
                    
                    // l'utente operatore non vuole prendere in gestione
                    // la segnalazione selezionata
                    case 'prendi_annulla':
                        $vd->setSottoPagina('segnalazioni_nuove');
                        $this->showHomeUtente($vd);
                        break;

                    // l'utente operatore non vuole modificare
                    // la segnalazione selezionata
                    case 'modifica_annulla':
                        $vd->setSottoPagina('segnalazioni_aperte');
                        $this->showHomeUtente($vd);
                        break;
                    
                    // salvataggio delle modifiche ad una segnalazione esistente
                    case 's_salva':
                        $msg = array();
                        if (isset($request['segnalazione'])) {
                            $intVal = filter_var($request['segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_segnalazione = $this->cercaSegnalazionePerId($intVal, $segnalazioni);
                                $this->updateSegnalazione($mod_segnalazione, $request, $msg);
                                if (count($msg) == 0 && SegnalazioneFactory::instance()->salva($mod_segnalazione) != 1) {
                                    $msg[] = '<li> Impossibile salvare la segnalazione </li>';
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Segnalazione aggiornata");
                                if (count($msg) == 0) {
                                    $vd->setSottoPagina('segnalazioni_aperte');
                                }
                            }
                        } else {
                            $msg[] = '<li> Segnalazione non specificata </li>';
                        }
                        $this->showHomeUtente($vd);
                        break;    
                        
                    // Chiude una segnalazione esistente
                    case 's_chiudi':
                        $msg = array();
                        if (isset($request['segnalazione'])) {
                            $intVal = filter_var($request['segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_segnalazione = $this->cercaSegnalazionePerId($intVal, $segnalazioni);
                                $this->chiudiSegnalazione($mod_segnalazione, $request, $msg);
                                if (count($msg) == 0 && SegnalazioneFactory::instance()->salva($mod_segnalazione) != 1) {
                                    $msg[] = '<li> Impossibile salvare la segnalazione </li>';
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Segnalazione chiusa");
                                if (count($msg) == 0) {
                                    $vd->setSottoPagina('segnalazioni_aperte');
                                }
                            }
                        } else {
                            $msg[] = '<li> Segnalazione non specificata </li>';
                        }
                        $segnalazioni = SegnalazioneFactory::instance()->getSegnalazioniApertePerOperatore($user);
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $this->showHomeUtente($vd);
                        break;    
                        
                    // ricerca segnalazioni da filtro
                    case 's_cerca':
                        if (isset($request['categoria_segnalazione']) && ($request['categoria_segnalazione'] != '')) {
                            $categoria_id = filter_var($request['categoria_segnalazione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                        } else {
                            $categoria_id = null;
                        }

                        if (isset($request['priorita']) && ($request['priorita'] != 'qualsiasi')) {
                            $priorita = $request['priorita'];
                        }else{
                            $priorita = null;
                        }
                        
                        if (isset($request['status']) && ($request['status'] != 'qualsiasi')) {
                            $status = $request['status'];
                        }else{
                            $status = null;
                        }

                        if (isset($request['oggetto'])) {
                            $oggetto = $request['oggetto'];
                        }else{
                            $oggetto = null;
                        }
                        
                        $segnalazioni_trovate = SegnalazioneFactory::instance()->ricercaSegnalazioniOperatore(
                                $user, 
                                $categoria_id,
                                $priorita,
                                $status,
                                $oggetto
                                );

                        $vd->setSottoPagina('segnalazioni_trovate');
                        $this->showHomeUtente($vd);
                        break;
                        
                    // l'operatore vuole chiudere il dettaglio della 
                    // segnalazione selezionata
                    case 's_annulla':
                        $vd->setSottoPagina('segnalazioni_ricerca');
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
    * L'operatore prende in gestione una segnalazione nuova
    * @param Segnalazione $mod_segnalazione la segnalazione da prendere in gestione
    * @param array $request la richiesta da gestire 
    * @param array $msg array dove inserire eventuali messaggi d'errore
    */
    private function prendiSegnalazione($mod_segnalazione, &$request, &$user, &$msg) {
        if (isset($request['categoria_segnalazione'])) {
            $categoria = CategoriaFactory::instance()->cercaCategoriaPerId($request['categoria_segnalazione']);
            if (isset($categoria)) {
                $mod_segnalazione->setCategoria($categoria);
            } else {
                $msg[] = "<li>categoria non trovata</li>";
            }
        }
          
        $mod_segnalazione->setStatus('aperta');
        $mod_segnalazione->setOperatore($user);
        
        $adesso = new DateTime();
        $adesso->format('Y-m-d H:i:s');
        $mod_segnalazione->setDataStatus($adesso);
        
    }

    
    /**
    * Aggiorna i dati relativi ad una segnalazione 
    * in base ai parametri specificati dall'operatore
    * @param Segnalazione $mod_segnalazione la segnalazione da modificare
    * @param array $request la richiesta da gestire 
    * @param array $msg array dove inserire eventuali messaggi d'errore
    */
    private function updateSegnalazione($mod_segnalazione, &$request, &$msg) {
        if (isset($request['categoria_segnalazione'])) {
            $categoria = CategoriaFactory::instance()->cercaCategoriaPerId($request['categoria_segnalazione']);
            if (isset($categoria)) {
                $mod_segnalazione->setCategoria($categoria);
            } else {
                $msg[] = "<li>categoria non trovata</li>";
            }
        }
        
        $mod_segnalazione->setPriorita($request['priorita']);
        $mod_segnalazione->setNote($request['testo_note']);
 
        $adesso = new DateTime();
        $adesso->format('Y-m-d H:i:s');
        $mod_segnalazione->setDataStatus($adesso);
        
    }

    
    /**
    * Chiude una segnalazione su indicazione dell'operatore
    * @param Segnalazione $mod_segnalazione la segnalazione da modificare
    * @param array $request la richiesta da gestire 
    * @param array $msg array dove inserire eventuali messaggi d'errore
    */
    private function chiudiSegnalazione($mod_segnalazione, &$request, &$msg) {
        if (isset($request['categoria_segnalazione'])) {
            $categoria = CategoriaFactory::instance()->cercaCategoriaPerId($request['categoria_segnalazione']);
            if (isset($categoria)) {
                $mod_segnalazione->setCategoria($categoria);
            } else {
                $msg[] = "<li>categoria non trovata</li>";
            }
        }
                        
        $mod_segnalazione->setStatus('chiusa');
               
        $adesso = new DateTime();
        $adesso->format('Y-m-d H:i:s');
        $mod_segnalazione->setDataStatus($adesso);
        
    }

    
    /**
     * Ricerca una segnalazione per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $segnalazioni un array di segnalazioni
     * @return Segnalazioine con l'id specificato se presente nella lista,
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
  
}

?>
