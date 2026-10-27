<?php

namespace App\Controller\Account;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(VehicleRepository $vehicleRepos): Response
    {

        $user = $this->getUser();

        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        if ($user->getStatus() === 'pending') {
            $this->addFlash(
                'warning',
                'Votre compte est en attente de validation par l’administrateur.'
            );

            return $this->redirectToRoute('home');
        }

        $vehicles = $user->getVehicles();

        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('account/dashboard/index.html.twig', [
            'vehicles' => $vehicles
        ]);
    }
}
