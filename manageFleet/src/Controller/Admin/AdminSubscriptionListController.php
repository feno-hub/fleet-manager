<?php

namespace App\Controller\Admin;

use App\Entity\SubscriptionCategory;
use App\Form\SubscriptionCategoryType;
use App\Repository\SubscriptionCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\OpenTestReporting\Status;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminSubscriptionListController extends AbstractController
{
    #[Route('/admin/subscription/category/list', name: 'admin.subscription.list')]
    public function index(SubscriptionCategoryRepository $repos): Response
    {
        return $this->render('admin/admin_category_subscription/index.html.twig', [
            'subscriptionCategories' => $repos->findAll(),
            'totalSubscription' => $repos->count(),
            'totalSubscriptionActive' => $repos->count([
                'status' => 'active' 
            ]),
            'totalSubscriptionInactive' => $repos->count([
                'status' => 'inactive' 
            ]),
        ]);
    }

    #[Route('/admin/subscription/category/new', name: 'admin.subscription.new')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {

        $subscription = new SubscriptionCategory();

        $subscription->setDuration(30);

        $form = $this->createForm(SubscriptionCategoryType::class, $subscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $subscription->setCreatedAt(new \DateTimeImmutable());
            $subscription->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($subscription);
            $manager->flush();

            $this->addFlash('success', "La catégorie d'abonnement a été ajoutée avec succès.");

            return $this->redirectToRoute('admin.subscription.list');
        }

        return $this->render('admin/admin_category_subscription/insert.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

