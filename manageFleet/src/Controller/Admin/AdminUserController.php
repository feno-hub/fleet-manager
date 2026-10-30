<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('/admin/user', name: 'app.admin.user', methods: ['GET'])]
    public function index(
        Request $request,
        UserRepository $userRepository
    ): Response {
        $recherche = trim($request->query->get('recherche', ''));
        $statut = $request->query->get('status', 'tous');

        $qb = $userRepository->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC');

        if ($recherche !== '') {
            $qb->andWhere(
                'LOWER(u.first_name) LIKE :recherche
                OR LOWER(u.last_name) LIKE :recherche
                OR LOWER(u.email) LIKE :recherche
                OR LOWER(u.name_company) LIKE :recherche'
            )
            ->setParameter(
                'recherche',
                '%' . mb_strtolower($recherche) . '%'
            );
        }

        if ($statut !== 'tous') {
            $qb->andWhere('u.status = :status')
                ->setParameter('status', $statut);
        }

        $utilisateurs = $qb->getQuery()->getResult();

        $tous = $userRepository->count([]);
        $enAttente = $userRepository->count(['status' => 'en_attente']);
        $approuves = $userRepository->count(['status' => 'accepte']);
        $refuses = $userRepository->count(['status' => 'refuse']);

        return $this->render('admin/admin_user/index.html.twig', [
            'utilisateurs' => $utilisateurs,
            'recherche' => $recherche,
            'statusActuel' => $statut,
            'totalUtilisateurs' => $tous,
            'totalEnAttente' => $enAttente,
            'totalApprouves' => $approuves,
            'totalRefuses' => $refuses,
        ]);
    }

    // #[Route('/utilisateurs/{id}', name: 'admin_utilisateur_detail', methods: ['GET'])]
    // public function detail(User $user): Response
    // {
    //     return $this->render('admin/utilisateurs/detail.html.twig', [
    //         'utilisateur' => $user,
    //     ]);
    // }
}
