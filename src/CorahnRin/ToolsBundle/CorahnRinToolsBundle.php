<?php

namespace CorahnRin\ToolsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorahnRinToolsBundle extends Bundle
{
	
	function __construct() {
		if (defined('CORAHNRIN') && CORAHNRIN === true) { return; }
		require __DIR__.DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
		$this->load_functions();
		$this->load_vendors();
		$this->load_tools();
	}

	/**
	 * Charge les fonctions du module Corahn-Rin
	 */
	public function load_functions() {
		$dir = __DIR__.DS.'Resources'.DS.'libs'.DS.'functions'.DS;
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
		$dir = __DIR__.DS.'Resources'.DS.'libs'.DS.'vendor'.DS;
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
		$dir = __DIR__.DS.'Resources'.DS.'libs'.DS.'CorahnRinTools'.DS;
		foreach (scandir($dir) as $v) {
			if ($v !== '.' && $v !== '..' && preg_match('#\.php$#i', $v)) {
				require $dir.$v;
			}
		}
	}
}
