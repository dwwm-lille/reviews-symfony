<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'reviews' => $repository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/review/new', name: 'app_review_new')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $manager, ReviewRepository $repository)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Configurer la date de création et le créateur du commentaire (l'utilisateur connecté)
            $review->setCreatedAt(new \DateTimeImmutable());
            $review->setUser($this->getUser());

            // Méthode 1 pour ajouter en BDD
            $manager->persist($review);
            $manager->flush();

            // Méthode 2
            // $repository->save($review, true);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('review/new.html.twig', [
            'form' => $form,
        ]);
    }
}
