<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use App\Repository\DirectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DirectorController extends AbstractController
{
    #[Route('/directors', name: 'app_directors')]
    public function list(DirectorRepository $directorRepository): Response
    {
        $directors = $directorRepository->findAll();

        return $this->render('director/list.html.twig', [
            'directors' => $directors,
        ]);
    }

    #[Route('/directors/new', name: 'app_director_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($director);
            $entityManager->flush();

            return $this->redirectToRoute('app_directors');
        }

        return $this->render('director/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/directors/{id}', name: 'app_director_show')]
    public function show(Director $director): Response
    {
        return $this->render('director/show.html.twig', [
            'director' => $director,
        ]);
    }
}
