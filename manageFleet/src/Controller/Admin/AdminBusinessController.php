<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminEntrepriseController extends AbstractController
{
    #[Route('/entreprises', name: 'admin_entreprises', methods: ['GET'])]
    public function index(
        Request $request,
        UserRepository $userRepository
    ): Response {
        $status = $request->query->get('status', 'tous');

        $allowedStatuses = ['tous', 'en_attente', 'accepte', 'refuse'];

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'tous';
        }

        $users = $userRepository->findBy([], ['createdAt' => 'DESC']);

        $entreprises = array_filter(
            $users,
            static function (User $user) use ($status): bool {
                if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                    return false;
                }

                if ($status !== 'tous' && $user->getStatus() !== $status) {
                    return false;
                }

                return true;
            }
        );

        return $this->render('admin/entreprises/index.html.twig', [
            'entreprises' => $entreprises,
            'statusActuel' => $status,
            'totalEntreprises' => count(array_filter(
                $users,
                static fn (User $user): bool =>
                    !in_array('ROLE_ADMIN', $user->getRoles(), true)
            )),
        ]);
    }
}
