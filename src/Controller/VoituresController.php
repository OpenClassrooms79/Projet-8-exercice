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
}
