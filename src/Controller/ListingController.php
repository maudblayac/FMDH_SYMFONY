<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListingController extends AbstractController
{
    #[Route('/apartments', name: 'listing_apartments')]
    public function apartments(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findByPropertyType('apartment');
        $page = max(1, $request->query->getInt('page', 1));

        return $this->render('listing/apartments.html.twig', [
            'annonces' => $annonces,
            'current_page' => $page,
            'per_page' => 6,
        ]);
    }

    #[Route('/houses', name: 'listing_houses')]
    public function houses(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findByPropertyType('house');
        $page = max(1, $request->query->getInt('page', 1));

        return $this->render('listing/houses.html.twig', [
            'annonces' => $annonces,
            'current_page' => $page,
            'per_page' => 6,
        ]);
    }
}
