<?php

namespace CorahnRin\CharactersBundle\Controller;

use CorahnRin\CharactersBundle\Entity\Characters;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ViewerController extends Controller
{
    /**
     * @Route("/characters/{id}-{nameSlug}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction(Characters $character)
    {
		return array('character'=>$character);
    }

    /**
     * @Route("/characters/")
     * @Template()
     */
    public function listAction(Request $request) {

        // Variables GET
        $page = (int) $request->query->get('page') ?: 1;
        $limitPost = $request->request->get('limit');
        $limit = $limitPost ?: ((int) $request->query->get('limit') ?: 20);
		$searchField = $request->query->get('searchField') ?: 'name';
		$order = $request->query->get('order') ?: 'asc';

        if ($page < 1) { $page = 1; }
        if ($limit < 5) { $limit = 5; }
        elseif ($limit > 100) { $limit = 100; }
		$order = strtolower($order) === 'desc' ? 'desc' : 'asc';

		$repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Characters');

        $number_of_chars = $repo->getNumberOfElementsSearch($searchField, $order, $limit, ($page-1)*$limit);
        $pages = ceil($number_of_chars / $limit);

        if ($limitPost) {
            if ($page > $pages) { $page = $pages; }
            return $this->redirect($this->generateUrl('corahnrin_characters_viewer_list', array(
                'searchField' => $searchField,
                'order' => $order,
                'page' => $page,
                'limit' => $limitPost,
            )));
        }

    	$characters_list = $repo->findSearch($searchField, $order, $limit, ($page-1)*$limit);

        $orderSwaped = $order === 'desc' ? 'asc' : 'desc';
		return array(
            'characters_list' => $characters_list,
            'number_of_chars' => $number_of_chars,
            'pages' => $pages,
            'linkDatas' => array(
                'searchField' => $searchField,
                'order' => $order,
                'page' => $page,
                'limit' => $limit,
            ),
            'orderSwaped' => $orderSwaped,
            'page' => $page,
        );
    }

    /**
     * @Route("/characters/pdf/{id}-{nameSlug}.pdf")
     */
    public function pdfAction(Characters $character, Request $request) {
        $response = new Response;

        $printer_friendly = $request->query->get('printer_friendly') === 'true';
        $sheet_type = $request->query->get('sheet_type') ?: 'original';

        $output_dir = $this->get('service_container')->getParameter('corahn_rin_generator.sheets_output');
        if (!is_dir($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        $file_name = ucfirst($character->getNameSlug()).
                ($printer_friendly ? '-pf' : '').
                '-'.$sheet_type.
                '-'.$this->get('translator')->getLocale().
                '-'.$character->getId().
                '.pdf';

        if (!file_exists($output_dir.$file_name) || true) {
            $manager = $this->get('corahn_rin_generator.sheets_manager');
            $pdf = $manager->getManager('pdf')
                ->generateSheet($character, $sheet_type, $printer_friendly)
                ->output($output_dir.$file_name, 'F');
        }

        $response->setContent(file_get_contents($output_dir.$file_name));
        $response->headers->add(array('Content-type'=>'application/pdf'));

        return $response;
    }

    /**
     * @Route("/characters/zip/{id}-{name}.zip")
     * @Template()
     */
    public function zipAction($id, $name)
    {
    }

    /**
     * @Route("/characters/jpg/{id}-{name}.zip")
     * @Template()
     */
    public function jpgAction($id, $name)
    {
    }

}
