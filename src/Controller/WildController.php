<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class WildController
 * @package App\Controller
 *
 * @Route("/wild")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="wild")
     */
    public function index()
    {
        return $this->render('wild/index.html.twig', [
            'wildseries' => 'Wild Series',
        ]);
    }

    /**
     *
     * @Route("/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="wild_show")
     * @param string $slug
     * @return Response
     */
    public function show(?string $slug){

        if (!$slug) {
            $slug = 'Aucune série sélectionnée, veuillez choisir une série';
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
        ]);

    }
}
