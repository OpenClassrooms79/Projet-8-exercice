<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VoituresController extends AbstractController
{
    /*
     * page d'accueil : Liste des voitures
     */
    #[Route('/', name: 'app_home')]
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('accueil.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
    }

    /*
     * page de détail d'une voiture
     */
    #[Route('/voiture/{id}', name: 'app_detail')]
    public function detail(VoitureRepository $voitureRepository, int $id): Response
    {
        $voiture = $voitureRepository->find($id);

        if ($voiture === null) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('detail.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}
