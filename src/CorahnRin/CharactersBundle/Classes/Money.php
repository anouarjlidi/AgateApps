<?php
namespace CorahnRin\CharactersBundle\Classes;

/**
 * Classe gérant l'argent des personnages
 *
 * @author Pierstoval
 */
class Money {
	
	private $name = 'Daol';
	private $names = array('Braise','Azur','Givre');
	private $names_literal = array('de Braise','d\'Azur','de Givre');
	private $ratio = array(10,10,0);
	private $values = array();
	
	public function __construct(){
		//Création du tableau de valeurs avec les noms définis dans $this->name
		foreach ($this->names as $v) { $this->values[$v] = 0; }
	}
	
	public function addBraise($number) {
		$this->values['Braise'] += (int) $number;
		return $this;
	}
	
	public function addAzur($number) {
		$this->values['Azur'] += (int) $number;
		return $this;
	}
	
	public function addGivre($number) {
		$this->values['Givre'] += (int) $number;
		return $this;
	}
	
	public function getGivre() {
		return (int) $this->values['Givre'];
	}
}
