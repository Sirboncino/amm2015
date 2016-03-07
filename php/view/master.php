<?php
include_once 'view_descriptor.php';
include_once basename(__DIR__) . '/../settings.php';

if (!$vd->isJson()) {
    ?>
    <!DOCTYPE html>
    <!-- 
        pagina master, contiene tutto il layout della applicazione 
        le varie pagine vengono caricate a "pezzi" a seconda della zona
        del layout:
        - above (header)
        - menu (i tab)
        - sideBar (sidebar a destra)
        - content (la parte sinistra con il contenuto)
        - footer (footer)

        Queste informazioni sono manentute in una struttura dati, chiamata ViewDescriptor
        la classe contiene anche le stringhe per i messaggi di feedback per 
        l'utente (errori e conferme delle operazioni)
    -->

    <html>

        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            <title><?= $vd->getTitolo() ?></title>
            <base href="<?= Settings::getApplicationPath() ?>php/"/>
            <meta name="keywords" content="Esame AMM" />
            <meta name="description" content="Sito per gestire le segnalazioni" />
            <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
            <link rel="stylesheet" type="text/css" media="screen" href="../css/style_responsivo.css" />
        
            <!-- serve per dire ai browser di interpretare la pagina tale e quale -->    
            <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                       
            <?php
            foreach ($vd->getScripts() as $script) {
                ?>
                <script type="text/javascript" src="<?= $script ?>"></script>
                <?php
            }
            ?>
        </head>

        <body>
            <div id="page">
		<header>
                    <div id="header"><!--  inizio header -->
                            
                        <div class="above">
                            <?php
                            $above = $vd->getAboveFile();
                            require "$above";
                            ?>
                        </div>
                        
                        <div id="logo">
                            <h1>segnali<span>AMM</span>o!</h1>
                        </div>
                        
                        <div class="menu"><!-- inizio menu -->
                            <?php
                            $menu = $vd->getMenuFile();
                            require "$menu";
                            ?>
                        </div><!-- fine menu -->
                        
                    </div><!--  fine header -->
		</header>
		
		             
                			
		<div id="content"><!-- inizio contenuto -->
		    
                    <!-- Riquadro con messaggio di conferma su operazione effetuata -->
                    <?php
                    if ($vd->getMessaggioConferma() != null) {
                        ?>
                        <div class="confirm">
                            <div>
                                <?=
                                $vd->getMessaggioConferma();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- Riquadro con messaggio di errore su operazione effetuata -->    
                    <?php
                    if ($vd->getMessaggioErrore() != null) {
                        ?>
                        <div class="error">
                            <div>
                                <?=
                                $vd->getMessaggioErrore();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                    <!-- Contenuto della pagina -->
                    <?php
                    $content = $vd->getContentFile();
                    require "$content";
                    ?>

                </div><!-- fine contenuto -->
                
                
                
                <div id="sidebar"><!-- inizio sidebar -->
                    <?php
                    $sidebar = $vd->getSideBarFile();
                    require "$sidebar";
                    ?>
                </div><!-- fine sidebar -->
                                
                
                
                <div class="clear"></div>
		
		<footer>
                    <div id="footer"><!--  inizio footer -->
                        <p>Applicazione per l'esame di Amministrazione di Sistema - &copy; 2015 - *r*t*</p>
                    </div>
			
                    <div class="validator">
                        <p>
                            <a href="http://validator.w3.org/check/referer" class="xhtml" title="Questa pagina contiene HTML valido">
                            <abbr title="eXtensible HyperText Markup Language">HTML</abbr> Valido</a>
                            <a href="http://jigsaw.w3.org/css-validator/check/referer" class="css" title="Questa pagina ha CSS validi">
                            <abbr title="Cascading Style Sheets">CSS</abbr> Valido</a>
			</p>
                    </div>
		</footer>
	    </div>
        </body>
    </html>

    <?php
} else {

    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    
    $content = $vd->getContentFile();
    require "$content";
}
?>





