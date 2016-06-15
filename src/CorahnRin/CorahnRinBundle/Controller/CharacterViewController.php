<?php

namespace CorahnRin\CorahnRinBundle\Controller;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Repository\CharactersRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Route("/characters")
 */
class CharacterViewController extends Controller
{

    /**
     * @Route("/", name="corahnrin_characters_list")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function listAction(Request $request)
    {
        // GET variables used for searching
        $page        = (int) $request->query->get('page') ?: 1;
        $limit       = (int) $request->query->get('limit') ?: 20;
        $searchField = $request->query->get('search_field') ?: 'name';
        $order       = strtolower($request->query->get('order') ?: 'asc');

        if ($limit > 100) {
            throw new BadRequestHttpException('Cannot retrieve more than 100 characters.');
        }

        if (!in_array($order, ['desc', 'asc'], true)) {
            throw new BadRequestHttpException('Filter order must be either "desc" or "asc".');
        }

        /** @var CharactersRepository $repo */
        $repo       = $this->getDoctrine()->getManager()->getRepository('CorahnRinBundle:Characters');
        $countChars = $repo->countSearch($searchField, $order);
        $characters = $repo->findSearch($searchField, $order, $limit, ($page - 1) * $limit);
        $pages      = ceil($countChars / $limit);

        return $this->render('@CorahnRin/CharacterView/list.html.twig', [
            'characters'      => $characters,
            'count_chars'     => $countChars,
            'count_pages'     => $pages,
            'page'            => $page,
            'order_swaped'    => $order === 'desc' ? 'asc' : 'desc',
            'link_data'       => [
                'search_field' => $searchField,
                'order'        => $order,
                'page'         => $page,
                'limit'        => $limit,
            ],
        ]);
    }

    /**
     * @Route("/{id}-{nameSlug}", requirements={"id" = "\d+"}, name="corahnrin_characters_view")
     *
     * @param Characters $character
     *
     * @return Response
     */
    public function viewAction(Characters $character)
    {
        return $this->render('@CorahnRin/CharacterView/view.html.twig', ['character' => $character]);
    }

}
