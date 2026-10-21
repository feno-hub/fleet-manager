<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'vehicule')]
    public function index(): Response
    {
        return $this->render('account/vehicule/index.html.twig', [
            'controller_name' => 'VehiculeController',
        ]);
    }
}
