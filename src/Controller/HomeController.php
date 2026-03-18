<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home', methods: ['GET', 'POST'])]
    public function index(Request $request, AnnonceRepository $annonceRepository): Response
    {
        if ($request->isMethod('POST') && $request->request->has('contact_name')) {
            $name = $request->request->get('contact_name');
            $email = $request->request->get('contact_email');
            $interest = $request->request->get('interest');
            $message = $request->request->get('message');

            if ($name && $email && $message) {
                $this->addFlash('success', 'Votre message a bien été envoyé, nous vous répondrons rapidement !');
            } else {
                $this->addFlash('error', 'Veuillez remplir tous les champs.');
            }

            return $this->redirectToRoute('home', ['_fragment' => 'contacte']);
        }

        $annoncesVente = $annonceRepository->findByType('vente');
        $annoncesLocation = $annonceRepository->findByType('location');

        return $this->render('index.html.twig', [
            'annonces_vente' => $annoncesVente,
            'annonces_location' => $annoncesLocation,
        ]);
    }
}