<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
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
     * @Route("/", name="wild_index")
     */
    public function index(ProgramRepository $programs)
    {
        return $this->render('wild/index.html.twig', [
            'programs' => $programs->findAll()
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
    public function show(?string $slug)
    {

        /* Code for Quest 5

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
        */


        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
            'program' => $program,
        ]);

    }

    /**
     * Getting three last programs in a category
     *
     * @Route("/category/{categoryName}", name="show_category")
     * @param string $categoryName
     * @param ProgramRepository $programs
     * @param CategoryRepository $categories
     * @return Response
     */

    public function showByCategory(string $categoryName, ProgramRepository $programs, CategoryRepository $categories): response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category has been sent to find a program in program\'s table.');
        }

        return $this->render('wild/category.html.twig', [
            'category' => $categories->findOneByName($categoryName),
            'programs' => $programs->findThreeLastProgramsByCategory(),
        ]);
    }
}
