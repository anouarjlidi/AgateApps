<?php

namespace CorahnRin\PagesBundle\Twig;

/**
 * Description of PrExtension
 *
 * @author Pierstoval
 */
class PrExtension extends \Twig_Extension {

	public function getFilters() {
        return array(
            'pr' => new \Twig_Filter_Method($this, 'prFilter'),
        );
    }

    public function prFilter($var, $return = false) {
		return \CorahnRinTools\pr($var, $return);
    }

    public function getName() {
        return 'pr_extension';
    }
}

?>
