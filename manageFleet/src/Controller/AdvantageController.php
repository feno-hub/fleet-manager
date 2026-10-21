<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdvantageController extends AbstractController
{
    #[Route('/advantage', name: 'advantage')]
    public function index(): Response
    {
        return $this->render('pages/advantage/index.html.twig', [
            'controller_name' => 'AdvantageController',
        ]);
    }
}
