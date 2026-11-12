<?php

namespace App\Controller;

use App\Repository\SubscriptionCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PriceController extends AbstractController
{
    #[Route('/price', name: 'price')]
    public function index(SubscriptionCategoryRepository $subscribRepos): Response
    {
        return $this->render('pages/price/index.html.twig', [
            'subscriptions' => $subscribRepos->findSubscrib(),
        ]);
    }
}
