<?php

include_once(dirname(__FILE__).'/Twig-1.13.0/lib/Twig/Autoloader.php');

class TwigTemplateRenderer{

	public $_environment = null;

	// initialisaion de l'objet --> $twigRenderTemplate = new TwigRenderTemplate(dirname(__FILE__));
	function __construct($emplacementFichierAppelant){
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem($emplacementFichierAppelant);
		$this->_environment  = new Twig_Environment($loader, array('cache' => false));
    }

    function __destruct(){
    }
}

?>

