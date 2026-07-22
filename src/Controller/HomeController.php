<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\CategorieRepository;
use App\Repository\EmpruntRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        LivreRepository $livreRepository,
        AuteurRepository $auteurRepository,
        CategorieRepository $categorieRepository,
        EmpruntRepository $empruntRepository
    ): Response {
        return $this->render('home/index.html.twig', [
            'nbLivres' => count($livreRepository->findAll()),
            'nbAuteurs' => count($auteurRepository->findAll()),
            'nbCategories' => count($categorieRepository->findAll()),
            'empruntsEnCours' => $empruntRepository->findEnCours(),
        ]);
    }
}
