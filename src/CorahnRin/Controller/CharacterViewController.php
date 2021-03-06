<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Controller;

use CorahnRin\Entity\Characters;
use CorahnRin\Repository\CharactersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/characters")
 */
class CharacterViewController extends Controller
{
    /**
     * @Route("/", name="corahnrin_characters_list", methods={"GET"})
     *
     * @return RedirectResponse|Response
     */
    public function listAction(Request $request)
    {
        // GET variables used for searching
        $page = (int) $request->query->get('page') ?: 1;
        $searchField = $request->query->get('search_field') ?: 'name';
        $order = \mb_strtolower($request->query->get('order') ?: 'asc');

        $limit = 25;

        if (!\in_array($order, ['desc', 'asc'], true)) {
            throw new BadRequestHttpException('Filter order must be either "desc" or "asc".');
        }

        /** @var CharactersRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Characters::class);
        $countChars = $repo->countSearch($searchField, $order);
        $characters = $repo->findSearch($searchField, $order, $limit, ($page - 1) * $limit);
        $pages = \ceil($countChars / $limit);

        return $this->render('corahn_rin/CharacterView/list.html.twig', [
            'characters' => $characters,
            'count_chars' => $countChars,
            'count_pages' => $pages,
            'page' => $page,
            'order_swaped' => 'desc' === $order ? 'asc' : 'desc',
            'link_data' => [
                'search_field' => $searchField,
                'order' => $order,
                'page' => $page,
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * @Route("/{id}-{nameSlug}", requirements={"id" = "\d+"}, name="corahnrin_characters_view", methods={"GET"})
     *
     * @return Response
     */
    public function viewAction(Characters $character)
    {
        return $this->render('corahn_rin/CharacterView/view.html.twig', ['character' => $character]);
    }
}
