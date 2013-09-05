<?php

namespace CorahnRin\PagesBundle\Twig;

/**
 * Description of TrExtension
 *
 * @author Pierstoval
 */
class TrExtension extends \Twig_Extension {

	public function getFilters() {
        return array(
            'tr' => new \Twig_Filter_Method($this, 'trFilter'),
        );
    }

    public function trFilter($txt, $return = false, $params = array()) {
		return \CorahnRinTools\Translate::translate($txt, $return, $params);
		return $txt;
    }

    public function getName() {
        return 'tr_extension';
    }
}

?>
