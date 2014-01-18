<?php

namespace CorahnRin\ToolsBundle\Twig;

/**
 * Class HelperExtension
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 08/01/2014
 */
class HelperExtension extends \Twig_Extension {

    public function getName() {
        return 'corahnrin_helper_extension';
    }

    public function getFilters() {
        return array(
            'pr' => new \Twig_Filter_Method($this, 'prFunction'),
            'datetime' => new \Twig_Filter_Method($this, 'datetimeFilter')
        );
    }

    /**
     * Fonctions Twig
     */
    public function getFunctions() {
        return array(
            'pr' => new \Twig_Function_Method($this, 'prFunction'),
            'is_array' => new \Twig_Function_Method($this, 'is_arrayFunction'),
        );
    }

    public function is_arrayFunction($element) {
        return is_array($element);
    }

    public function datetimeFilter($d, $format = null) {
        if (!$format) { $format = '%A %d %B %Y %H:%M'; }
        if ($d instanceof \DateTime) { $d = $d->getTimestamp(); }
        return strftime($format, $d);
    }

    public function prFunction($var, $return = false) {
		return \CorahnRinTools\pr($var, $return);
    }

}
