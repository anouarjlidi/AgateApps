<?php

namespace CorahnRin\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Response as Response;

class VersionsController extends Controller
{
    /**
     * @Route("/get_version/{filter}", requirements={"filter" = "code|date"})
     */
    public function getAction($filter = '')
    {
//		$version = array(
//			'code' => '2.000',
//			'date' => (new \DateTime())->format(\Datetime::RFC2822)
//		);
//		if ($filter && isset($version[$filter])) {
//			$version = $version[$filter];
//		}
//		$version = is_array($version) ? json_encode($version) : $version;
//		return new Response($version);
		return array();
    }

}
