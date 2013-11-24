<?php

namespace CorahnRin\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MenusController extends Controller {
	/**
	 * @Template()
	 */
	public function menuAction($route = '') {
		$links = array(
			'corahnrin_characters_generator_index' => 'Générateur de personnage',
			'corahnrin_characters_viewer_list' => 'Liste des personnages',
			'corahnrin_pages_versions_index' => 'Mises à jour',
		);
        $langs = $this->get('corahnrin_translate')->getLangs('array');
        foreach($langs as $k => $lang) {
            $lang = strtolower($lang);
            $langs[$k] = array('locale' => $lang, 'literal' => $lang);
                if ($lang === 'fr') { $langs[$k]['literal'] = 'Français'; }
            elseif ($lang === 'en') { $langs[$k]['literal'] = 'Anglais'; }
            elseif ($lang === 'de') { $langs[$k]['literal'] = 'Allemand'; }
        }
		$username = $this->get('fos_user.user_provider.username');
		return array(
            'links' => $links,
            'route_name' => $route,
            'locale'=>$this->get('session')->get('_locale'),
            'langs' => $langs
        );
	}

	/**
	 * @Template()
	 */
	public function adminAction() {
		return new Response('menu 1');
	}

}
