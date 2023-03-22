<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReviewRepository $repository): Response
    {
        return $this->render('home/index.html.twig', [
            'companies' => ['Apple', 'Boxydev', 'Microsoft'],
            'reviews' => $repository->findAll(),
        ]);
    }

    #[Route('/review/new', name: 'app_review_new')]
    #[IsGranted('ROLE_USER')]
    public function new()
    {
        return $this->redirectToRoute('app_home');
    }
}
