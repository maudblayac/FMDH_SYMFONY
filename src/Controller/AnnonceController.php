<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/{id}', name: 'annonce_show', requirements: ['id' => '\d+'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/new', name: 'annonce_new', priority: 1)]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($request->isMethod('POST')) {
            $annonce = new Annonce();
            $annonce->setNom($request->request->get('nom'));
            $annonce->setPrix($request->request->get('prix'));
            $annonce->setTypeTransaction($request->request->get('type_transaction'));
            $annonce->setPropertyType($request->request->get('property_type'));
            $annonce->setVille($request->request->get('ville'));
            $annonce->setDescriptions($request->request->get('descriptions'));
            $annonce->setUser($this->getUser());

            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $frontFile = $request->files->get('frontPicture');
            $backFile = $request->files->get('backPicture');

            if ($frontFile && $backFile) {
                $frontFilename = uniqid('front_') . '_' . $frontFile->getClientOriginalName();
                $backFilename = uniqid('back_') . '_' . $backFile->getClientOriginalName();

                $frontFile->move($uploadDir, $frontFilename);
                $backFile->move($uploadDir, $backFilename);

                $annonce->setFrontPicture('uploads/' . $frontFilename);
                $annonce->setBackPicture('uploads/' . $backFilename);
            } else {
                $this->addFlash('error', 'Veuillez sélectionner une photo pour le devant et l\'arrière.');
                return $this->render('annonce/new.html.twig');
            }

            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success', 'Votre annonce a été ajoutée avec succès !');
            return $this->redirectToRoute('home');
        }

        return $this->render('annonce/new.html.twig');
    }

    #[Route('/edit/{id}', name: 'annonce_edit')]
    public function edit(Annonce $annonce, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($annonce->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres annonces.');
        }

        if ($request->isMethod('POST')) {
            $annonce->setNom($request->request->get('nom'));
            $annonce->setPrix($request->request->get('prix'));
            $annonce->setTypeTransaction($request->request->get('type_transaction'));
            $annonce->setPropertyType($request->request->get('property_type'));
            $annonce->setVille($request->request->get('ville'));
            $annonce->setDescriptions($request->request->get('descriptions'));

            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            $frontFile = $request->files->get('frontPicture');
            $backFile = $request->files->get('backPicture');

            if ($frontFile) {
                $frontFilename = uniqid('front_') . '_' . $frontFile->getClientOriginalName();
                $frontFile->move($uploadDir, $frontFilename);
                $annonce->setFrontPicture('uploads/' . $frontFilename);
            }
            if ($backFile) {
                $backFilename = uniqid('back_') . '_' . $backFile->getClientOriginalName();
                $backFile->move($uploadDir, $backFilename);
                $annonce->setBackPicture('uploads/' . $backFilename);
            }

            $em->flush();

            $this->addFlash('success', 'Annonce modifiée avec succès !');
            return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/delete/{id}', name: 'annonce_delete', methods: ['POST'])]
    public function delete(Annonce $annonce, EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($annonce->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres annonces.');
        }

        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->request->get('_token'))) {
            $em->remove($annonce);
            $em->flush();
            $this->addFlash('success', 'Annonce supprimée.');
        }

        return $this->redirectToRoute('home');
    }
}
