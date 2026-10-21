<?php

namespace App\Controller\Account;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {

        // $user = $this->getUser();

        // if(!$user) {
        //     return $this->redirectToRoute('app_login');
        // }

        // if ($user->getStatus() == 'pending') {
        //     $this->addFlash(
        //         'warning',
        //         'Votre compte est en attente de validation par l’administrateur.'
        //     );

        //     return $this->redirectToRoute('home');
        // }

        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('account/dashboard/index.html.twig');
    }
}

