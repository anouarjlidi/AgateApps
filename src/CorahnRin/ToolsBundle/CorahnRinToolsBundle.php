<?php

namespace CorahnRin\ToolsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorahnRinToolsBundle extends Bundle {

	function __construct() {
		//Si la constante est déjà présente, on ne la recrée pas
		if (defined('CORAHNRIN') && CORAHNRIN === true) { return; }

		//Chargement du fichier de config de CorahnRin dans config.php
		require __DIR__.DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

		//Chargement des fonctions, vendors et outils.
		$this->load_functions();
		$this->load_vendors();
		$this->load_tools();
	}

	/**
	 * Charge les fonctions du module Corahn-Rin
	 */
	public function load_functions() {
		//Dossier des fonctions
		$dir = __DIR__.DS.'Resources'.DS.'libs'.DS.'functions'.DS;

		//Exclusion de certains fichiers
		$excludes = array('Translate.php'=>1);

		//On boucle sur les fichiers et on les charge
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
		//Dossier des vendors
		$dir = __DIR__.DS.'Resources'.DS.'libs'.DS.'vendor'.DS;

		//On boucle sur les fichiers et on les charge
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
		//Dossier des outils
		$dir = __DIR__.DS.'Resources'.DS.'libs'.DS.'CorahnRinTools'.DS;

		//On boucle sur les fichiers et on les charge
		foreach (scandir($dir) as $v) {
			if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) {
				require $dir.$v;
			}
		}
	}
}
