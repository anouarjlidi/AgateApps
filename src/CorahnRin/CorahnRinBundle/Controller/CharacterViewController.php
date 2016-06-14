<?php

namespace CorahnRin\CorahnRinBundle\Controller;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CharacterViewController extends Controller
{
    /**
     * @Route("/characters/{id}-{nameSlug}", requirements={"id" = "\d+"})
     *
     * @param Characters $character
     *
     * @return Response
     */
    public function viewAction(Characters $character)
    {
        return $this->render('CorahnRinBundle:CharacterView:view.html.twig', ['character' => $character]);
    }

    /**
     * @Route("/characters/", name="corahnrin_characters_viewer_list")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function listAction(Request $request)
    {

        // Variables GET
        $page        = (int) $request->query->get('page') ?: 1;
        $limitPost   = $request->request->get('limit');
        $limit       = $limitPost ?: ((int) $request->query->get('limit') ?: 20);
        $searchField = $request->query->get('searchField') ?: 'name';
        $order       = $request->query->get('order') ?: 'asc';

        if ($page < 1) {
            $page = 1;
        }
        if ($limit < 5) {
            $limit = 5;
        } elseif ($limit > 100) {
            $limit = 100;
        }
        $order = strtolower($order) === 'desc' ? 'desc' : 'asc';

        $repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinBundle:Characters');

        $number_of_chars = $repo->getNumberOfElementsSearch($searchField, $order, $limit, ($page - 1) * $limit);
        $pages           = ceil($number_of_chars / $limit);

        if ($limitPost) {
            if ($page > $pages) {
                $page = $pages;
            }

            return $this->redirect($this->generateUrl('corahnrin_characters_viewer_list', [
                'searchField' => $searchField,
                'order'       => $order,
                'page'        => $page,
                'limit'       => $limitPost,
            ]));
        }

        $characters_list = $repo->findSearch($searchField, $order, $limit, ($page - 1) * $limit);

        return $this->render('CorahnRinBundle:CharacterView:list.html.twig', [
            'characters_list' => $characters_list,
            'number_of_chars' => $number_of_chars,
            'pages'           => $pages,
            'linkDatas'       => [
                'searchField' => $searchField,
                'order'       => $order,
                'page'        => $page,
                'limit'       => $limit,
            ],
            'orderSwaped'     => $order === 'desc' ? 'asc' : 'desc',
            'page'            => $page,
        ]);
    }

    /**
     * @Route("/characters/pdf/{id}-{nameSlug}.pdf")
     *
     * @param Characters $character
     * @param Request    $request
     *
     * @return Response
     */
    public function pdfAction(Characters $character, Request $request)
    {
        $response = new Response();

        $printer_friendly = $request->query->get('printer_friendly') === 'true';
        $sheet_type       = $request->query->get('sheet_type') ?: 'original';

        $output_dir = $this->get('service_container')->getParameter('corahnrin.generator.sheets_output');
        if (!is_dir($output_dir)) {
            $this->get('filesystem')->mkdir($output_dir, 0777);
        }

        $file_name = ucfirst($character->getNameSlug()).
            ($printer_friendly ? '-pf' : '').
            '-'.$sheet_type.
            '-'.$this->get('translator')->getLocale().
            '-'.$character->getId().
            '.pdf';

        // Generate the PDF if the file doesn't exist yet,
        // or if we're in debug mode.
        if (!file_exists($output_dir.$file_name) || $this->getParameter('kernel.debug')) {
            $this->get('corahn_rin_generator.pdf_manager')
                ->generateSheet($character, $printer_friendly)
                ->Output($output_dir.$file_name, 'F')
            ;
        }

        $response->setContent(file_get_contents($output_dir.$file_name));
        $response->headers->add(['Content-type' => 'application/pdf']);

        return $response;
    }

    /**
     * @Route("/characters/zip/{id}-{name}.zip")
     */
    public function zipAction($id, $name)
    {
    }

    /**
     * @Route("/characters/jpg/{id}-{name}.zip")
     */
    public function jpgAction($id, $name)
    {
    }
}
