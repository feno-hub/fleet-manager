<?php

namespace App\Controller;

use App\Repository\SubscriptionCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SubscriptionCategoryRepository $subscribRepos): Response
    {
        return $this->render('pages/home/index.html.twig', [
            'subscriptions' => $subscribRepos->findFreeSubscrib()
        ]);
    }
}
