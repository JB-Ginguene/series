<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
        //TODO récupérer la liste de mes séries
        // $series = $serieRepository->findAll();

        // $series = $serieRepository->findBy([], ["vote" => "DESC"], 50);
        $series = $serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig', ["series" => $series]);
    }


    /**
     * @Route("/series/detail/{id}", name="serie_detail")
     */
    public function detail($id, SerieRepository $serieRepository): Response
    {
        //TODO récupérer la série en fonction de son id
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('Oops, this series seems to not exist in our database!');
        }

        return $this->render('serie/detail.html.twig', [
            "serie" => $serie
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
