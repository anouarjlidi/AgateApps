<?php

namespace Esteren\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Response as Response;

class VersionsController extends Controller
{
    /**
     * @Route("/versions")
     * @Template()
     */
	public function indexAction() {
        $o = shell_exec('git log');
        $o = preg_replace('~(commit [0-9a-f]+)~isUu', '/:/:/$1', $o);
        $o = explode('/:/:/', $o);

        $all_versions = array();
        $total = 0;
        foreach ($o as $k => $v) {
            $v = trim($v);
            $v = str_replace(array("\r", "\t"), array('',''), $v);
            $v = preg_replace('~\n\n+~', "\n", $v);
            $v = preg_replace('~  +~', " ", $v);
            $v = preg_replace('~\n +~sUu', "\n", $v);
            $v = preg_replace('~\n\n+~', "\n", $v);
            if ($v) {
                $v = explode("\n", $v);
                $commit = str_replace('commit ', '', array_shift($v));
                $author = ucfirst(str_replace('Author: ', '', array_shift($v)));
                $date = array_shift($v);
                $title = htmlspecialchars(array_shift($v));
                $description = htmlspecialchars(implode("\n", $v));

                if (!defined('CHARSET')){define("CHARSET", "iso-8859-1");}

                $date = str_replace('Date: ', '', $date);
                $date = strtotime($date);
//                $day = strftime('%A', $date);
//                $month = strftime('%B', $date);
//                $date_compare = strftime(ucfirst($day).' %d '.ucfirst(utf8_encode($month)).' %Y', $date);
//                $date_full = strftime(ucfirst($day).' %d '.ucfirst(utf8_encode($month)).' %Y à %H:%M:%S', $date);

                $dateFinal = new \DateTime();
                $dateFinal->setTimestamp($date);
                $all_versions[$dateFinal->format('l d F Y')]['_date'] = $dateFinal;
                $all_versions[$dateFinal->format('l d F Y')][$title][] = array(
                    'date' => $dateFinal,
                    'commit' => $commit,
                    'author' => $author,
                    'title' => $title,
                    'description' => $description,
                );
                $total++;
            }
        }

//		$versions = new \SimpleXMLElement(file_get_contents(CORAHNRIN_VERSIONS));
//		$em = $this->getDoctrine()->getManager();
//		$stepsrepo = $em->getRepository('CorahnRinCharactersBundle:Steps');
//		$steps = $stepsrepo->findAll();
//		$updates = array();
//		$total_maj = 0;
		return array('versions' => $all_versions, 'total'=>$total);
	}

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
