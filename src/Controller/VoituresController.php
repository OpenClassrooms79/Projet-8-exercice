<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function var_dump;

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

    /*
     * ajout d'une nouvelle voiture
     */
    #[Route('/ajout', name: 'app_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $form->getData();

            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('app_detail', ['id' => $voiture->getId()]);
        }
        return $this->render(
            'ajout.html.twig',
            [
                'form' => $form,
            ],
        );
    }
}
