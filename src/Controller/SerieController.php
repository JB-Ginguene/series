<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(): Response
    {

        $serie = "Sliders";
        $test = "Test";

        dump($serie);
        dump($test);

        //TODO récupérer la liste de mes séries

        return $this->render('serie/list.html.twig', [

        ]);
    }


    /**
     * @Route("/series/detail/{id}", name="serie_detail")
     */
    public function detail($id): Response
    {

        //TODO récupérer la série en fonction de son id

        return $this->render('serie/detail.html.twig', [

        ]);
    }



    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(): Response
    {

        //TODO générer un formulaire pour ajouter ma nouvelle série

        return $this->render('serie/create.html.twig', [

        ]);
    }
}
