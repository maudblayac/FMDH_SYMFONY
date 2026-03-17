<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annoncesVente = $annonceRepository->findByType('vente');
        $annoncesLocation = $annonceRepository->findByType('location');

        return $this->render('index.html.twig', [
            'annonces_vente' => $annoncesVente,
            'annonces_location' => $annoncesLocation,
        ]);
    }
}