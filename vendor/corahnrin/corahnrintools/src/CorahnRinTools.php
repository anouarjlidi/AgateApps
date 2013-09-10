<?php

//namespace CorahnRinTools;

class CorahnRinTools {
	function __construct() {
		if (PHP_SAPI !== 'cli') {
			require __DIR__.DIRECTORY_SEPARATOR.'config.php';
		}
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
}

