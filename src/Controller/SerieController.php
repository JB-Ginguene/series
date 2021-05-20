<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series/{page}", name="serie_list", requirements={"page"="\d+"})
     */
    public function list(int $page = 1, SerieRepository $serieRepository): Response
    {
        //TODO récupérer la liste de mes séries
        // $series = $serieRepository->findAll();

        // $series = $serieRepository->findBy([], ["vote" => "DESC"], 50);
        $series = $serieRepository->findBestSeries($page);

        $nbSeries = $serieRepository->count([]);
        $maxPage = ceil($nbSeries / 50);

        if ($page >= 1 && $page <= $maxPage) {
            return $this->render('serie/list.html.twig', [
                "series" => $series,
                "currentPage" => $page,
                "maxPage" => $maxPage
            ]);
        } else {
            throw $this->createNotFoundException('Oops, this page was not found!');
        }
    }


    /**
     * @Route("/series/detail/{id}", name="serie_detail")
     */
    public
    function detail($id, SerieRepository $serieRepository): Response
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
    public
    function create(): Response
    {
        //TODO générer un formulaire pour ajouter ma nouvelle série

        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateCreated(new \DateTime());

        return $this->render('serie/create.html.twig', [
            "createSerieForm"=>$serieForm->createView()
        ]);
    }
}
