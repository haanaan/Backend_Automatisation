<?php

namespace App\Controller;

use App\Entity\Batiments;
use App\Form\BatimentsType;
use App\Repository\BatimentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/batiments')]
final class BatimentsController extends AbstractController
{
    #[Route(name: 'app_batiments_index', methods: ['GET'])]
    public function index(BatimentsRepository $batimentsRepository): Response
    {
        return $this->render('batiments/index.html.twig', [
            'batiments' => $batimentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_batiments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $batiment = new Batiments();
        $form = $this->createForm(BatimentsType::class, $batiment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($batiment);
            $entityManager->flush();

            return $this->redirectToRoute('app_batiments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('batiments/new.html.twig', [
            'batiment' => $batiment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_batiments_show', methods: ['GET'])]
    public function show(Batiments $batiment): Response
    {
        return $this->render('batiments/show.html.twig', [
            'batiment' => $batiment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_batiments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Batiments $batiment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BatimentsType::class, $batiment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_batiments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('batiments/edit.html.twig', [
            'batiment' => $batiment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_batiments_delete', methods: ['POST'])]
    public function delete(Request $request, Batiments $batiment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $batiment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($batiment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_batiments_index', [], Response::HTTP_SEE_OTHER);
    }
}
