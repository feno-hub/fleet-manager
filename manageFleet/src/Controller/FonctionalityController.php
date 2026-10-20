<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FonctionalityController extends AbstractController
{
    #[Route('/fonctionality', name: 'fonctionality')]
    public function index(): Response
    {
        return $this->render('pages/fonctionality/index.html.twig', [
            'controller_name' => 'FonctionalityController',
        ]);
    }
}
