<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/emprunt')]
class EmpruntController extends AbstractController
{
    #[Route('/', name: 'emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'emprunt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $emprunt = new Emprunt();
        $emprunt->setDateEmprunt(new \DateTime());

        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le livre emprunté devient indisponible
            $emprunt->getLivre()?->setDisponible(false);

            $em->persist($emprunt);
            $em->flush();
            $this->addFlash('success', 'Emprunt enregistré avec succès.');
            return $this->redirectToRoute('emprunt_index');
        }

        return $this->render('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/retour', name: 'emprunt_retour', methods: ['POST'])]
    public function retour(Request $request, Emprunt $emprunt, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('retour' . $emprunt->getId(), $request->request->get('_token'))) {
            $emprunt->setRendu(true);
            $emprunt->setDateRetourEffective(new \DateTime());
            $emprunt->getLivre()?->setDisponible(true);
            $em->flush();
            $this->addFlash('success', 'Retour du livre enregistré.');
        }

        return $this->redirectToRoute('emprunt_index');
    }

    #[Route('/{id}', name: 'emprunt_delete', methods: ['POST'])]
    public function delete(Request $request, Emprunt $emprunt, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $emprunt->getId(), $request->request->get('_token'))) {
            if (!$emprunt->isRendu()) {
                $emprunt->getLivre()?->setDisponible(true);
            }
            $em->remove($emprunt);
            $em->flush();
            $this->addFlash('success', 'Emprunt supprimé.');
        }

        return $this->redirectToRoute('emprunt_index');
    }
}
