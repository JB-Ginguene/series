<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\ManageEntity\UpdateEntity;
use App\Repository\SerieRepository;
use App\Upload\SerieImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
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
    function create(Request $request,
                    EntityManagerInterface $entityManager,
                    UpdateEntity $updateEntity,
                    SerieImage $serieImage): Response
    {
        //TODO générer un formulaire pour ajouter ma nouvelle série

        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateCreated(new \DateTime());

        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted() && $serieForm->isValid()) {
            $file = $serieForm->get('poster')->getData();
            /**
             * @var UploadedFile $file
             */
            if ($file) {
                $directory = $this->getParameter('upload_poster_series_dir');
                $serieImage->save($file, $serie, $directory);
            }

            $updateEntity->save($serie);

            //message flash :
            $this->addFlash('success', 'The serie has been added');
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);

        }

        return $this->render('serie/create.html.twig', [
            "createSerieForm" => $serieForm->createView()
        ]);
    }

    /**
     * @Route("/series/edit/{id}", name="serie_edit")
     */
    public
    function edit($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        //TODO générer un formulaire pour ajouter ma nouvelle série

        $serie = $entityManager->find(Serie::class, $id);
        if (!$serie) {
            throw $this->createNotFoundException("Oops, this series doesn't exist in our DB");
        }

        $serieForm = $this->createForm(SerieType::class, $serie);
        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted() && $serieForm->isValid()) {
            $serie->setDateModified(new \DateTime());
            $entityManager->persist($serie);
            $entityManager->flush();

            //message flash :
            $this->addFlash('success', 'The serie has been edited');
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);
        }

        return $this->render('serie/edit.html.twig', [
            "serie" => $serie,
            "serieForm" => $serieForm->createView()
        ]);
    }

    /**
     * @Route("/series/delete/{id}", name="serie_delete")
     */
    public
    function delete($id, EntityManagerInterface $entityManager): Response
    {
        $serie = $entityManager->find(Serie::class, $id);
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('main_home');
    }

}
