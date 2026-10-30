<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Logging\OpenTestReporting\Status;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminCompanyController extends AbstractController
{
    #[Route('/admin/company', name: 'app_admin_company')]
    public function index(
        UserRepository $userRepository,
        Request $request
    ): Response
    {

        $users = $userRepository->findAll();

        $totalUser = count($users);

        $currentStatus = $request->query->get('status', 'all');


        if ($currentStatus === 'all') {
            $users = $userRepository->findAll();
        } else {
            $users = $userRepository->findBy([
                'status' => $currentStatus
            ]);
        }

        return $this->render('admin/admin_company/index.html.twig', [
            'users' => $users,
            'totalUser' => $totalUser,
            'currentStatus' => $currentStatus
        ]);
    }
}
