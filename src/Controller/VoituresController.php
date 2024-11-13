<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /*
     * suppression d'une voiture
     */
    #[Route('/voiture/{id}/supprimer', name: 'app_delete')]
    public function delete(EntityManagerInterface $entityManager, VoitureRepository $voitureRepository, int $id): Response
    {
        //$voiture = $entityManager->find(Voiture::class, $id);
        $voiture = $voitureRepository->find($id);
        if ($voiture !== null) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_home');
    }
}
