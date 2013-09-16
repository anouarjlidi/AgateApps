<?php

//namespace CorahnRinTools;

class CorahnRinTools {
	function __construct() {
//		if (PHP_SAPI !== 'cli') {
		require __DIR__.DIRECTORY_SEPARATOR.'config.php';
		$this->load_functions();
		$this->load_vendors();
		$this->load_tools();
//		}
//		
//		//Chargement des fonctions de base
//		$dir = __DIR__.DS.'functions'.DS;
//		foreach (scandir($dir) as $v) { if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) { require $dir.$v; } }
//		
//		//Chargement des librairies externes
//		$dir = __DIR__.DS.'vendor'.DS;
//		foreach (scandir($dir) as $v) { if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) { require $dir.$v; } }
//		
//		//Chargement des outils de CorahnRin
//		$dir = __DIR__.DS.'CorahnRinTools'.DS;
//		foreach (scandir($dir) as $v) { if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) { require $dir.$v; } }
//		
//		Translate::init();
//		define('P_LOGGED',	(Users::id() > 0 ? true : false));
//		define('P_DEBUG',	(Users::id() == 1 ? true : false));
	}

	/**
	 * Charge les fonctions du module Corahn-Rin
	 */
	public function load_functions() {
		$dir = CORAHNRIN_TOOLS.DS.'functions'.DS;
		$excludes = array('Translate.php'=>1);
		foreach (scandir($dir) as $v) {
			if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v) && !isset($excludes[$v])) {
				require $dir.$v;
			}
		}
	}

	/**
	 * Charge les librairies externes utilisées par le module Corahn-Rin
	 */
	public function load_vendors() {
		$dir = CORAHNRIN_TOOLS.DS.'vendor'.DS;
		foreach (scandir($dir) as $v) {
			if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) {
				require $dir.$v;
			}
		}
	}

	/**
	 * Charge les librairies externes utilisées par le module Corahn-Rin
	 */
	public function load_tools() {
		$dir = CORAHNRIN_TOOLS.DS.'CorahnRinTools'.DS;
		foreach (scandir($dir) as $v) {
			if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) {
				require $dir.$v;
			}
		}
	}
}

