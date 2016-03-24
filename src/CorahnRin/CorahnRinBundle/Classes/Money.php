<?php

namespace CorahnRin\CorahnRinBundle\Classes;

/**
 * Classe gérant l'argent des personnages.
 *
 * @author Pierstoval
 */
class Money
{
    protected $name = 'Daol';
    protected $names = array('Braise', 'Azur', 'Givre');
    protected $names_literal = array('Daol%s% de Braise', 'Daol%s% d\'Azur', 'Daol%s% de Givre');
    protected $ratio = array(10, 10, 10);
    protected $values = array('Braise' => 0, 'Azur' => 0, 'Givre' => 0);

    public function __construct()
    {
        //Création du tableau de valeurs avec les noms définis dans $this->name
        foreach ($this->names as $v) {
            $this->values[$v] = 0;
        }
    }

    /**
     * Retourne le tableau avec toutes les valeurs d'argent.
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Retourne le nom de la monnaie utilisée.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Retourne la liste des noms de monnaies, ou un nom litéral si un index
     * est fourni.
     *
     * @param int $index Un index éventuel pour récupérer un nom litéral
     *
     * @return int|null
     */
    public function nameLiteral($index = null)
    {
        if ($index === null) {
            return $this->names_literal;
        } elseif (isset($this->names_literal[(int) $index])) {
            return $this->names_literal[(int) $index];
        } else {
            return null;
        }
    }

    /**
     * Génère des getters et setters dynamiques sans avoir à les créer
     * directement dans l'objet.
     *
     * @param string $name      Nom de la méthode dynamique
     * @param array  $arguments Arguments envoyés à la méthode dynamique
     *
     * @return Money|null|number
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'add') === 0) {
            //Exemple : $this->addBraise(1);
            $name = str_replace('add', '', $name);
            if (in_array($name, $this->names) && isset($arguments[0])) {
                $this->values[$name] += (int) $arguments[0];

                return $this;
            }
        } elseif (strpos($name, 'get') === 0) {
            //Exemple : $this->getBraise();
            $name = str_replace('get', '', $name);
            if (in_array($name, $this->names)) {
                return (int) $this->values[$name];
            }
        }

        return null;
    }

    /**
     * Reformate la monnaie selon les divers ratios.
     */
    public function convert()
    {
        foreach ($this->names as $k => $v) {
            while ($this->values[$v] >= $this->ratio[$k] && isset($this->names[$k + 1])) {
                $this->values[$v] = isset($this->values[$v]) ? $this->values[$v] - $this->ratio[$k] : 0;
                ++$this->values[$this->names[$k + 1]];
            }
        }
    }
}
