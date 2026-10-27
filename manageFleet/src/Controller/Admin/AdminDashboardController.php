<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard')]
    public function index(
        UserRepository $userRepository,
        VehicleRepository $vehicleRepository
    ): Response {
        $users = $userRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            5
        );

        return $this->render('admin/dashboard.html.twig', [
            'totalUsers' => $userRepository->count([]),
            'pendingUsers' => $userRepository->count([
                'status' => 'pending',
            ]),
            'approvedUsers' => $userRepository->count([
                'status' => 'accepted',
            ]),
            'totalVehicles' => $vehicleRepository->count([]),
            'recentUsers' => $users,
        ]);
    }
}