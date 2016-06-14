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
     * @Route("/characters/{id}-{nameSlug}", requirements={"id" = "\d+"}, name="corahnrin_character_view")
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
     * @Route("/characters/", name="corahnrin_character_list")
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

}
