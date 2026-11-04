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
        $enAttente = $userRepository->count(['status' => 'pending']);
        $approuves = $userRepository->count(['status' => 'accepted']);
        $refuses = $userRepository->count(['status' => 'rejected']);

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

    #[Route('/admin/user/{id}', name: 'admin.user.show', methods: ['GET'])]
    public function shoW(UserRepository $repos, string $id): Response
    {

        return $this->render('admin/admin_user/show.html.twig', [
            "user" => $repos->find($id)
        ]);
    }

    #[Route(
        '/admin/user/{id}/status',
        name: 'admin.user.status',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function updateStatus(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid(
            'status'.$user->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException();
        }

        $status = $request->request->get('status');

        if (!in_array($status, ['accepted', 'rejected', 'suspend'], true)) {
            throw $this->createNotFoundException('Statut invalide.');
        }

        $user->setStatus($status);

        $entityManager->flush();

        $this->addFlash(
            'success',
            $status === 'accepted'
                ? 'Utilisateur accepté avec succès.'
                : 'Utilisateur refusé avec succès.'
        );

        $this->addFlash(
            'success',
            $status === 'suspend'
                ? 'Utilisateur suspendu.'
                : "" 
        );

        return $this->redirectToRoute('app.admin.user');
    }

    #[Route(
        '/admin/user/{id}/delete',
        name: 'admin.user.delete',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid(
            'delete'.$user->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException();
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé avec succès.');

        return $this->redirectToRoute('app.admin.user');
    }

}
