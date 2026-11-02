<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminSubscriptionController extends AbstractController
{
    #[Route('/admin/subscription/list', name: 'app.admin.subscription')]
    public function index(): Response
    {
        return $this->render('admin/admin_subscription/list.html.twig', [
            'controller_name' => 'AdminSubscriptionController',
        ]);
    }

    #[Route('/admin/subscription/show', name: 'app.admin.subscription.show')]
    public function show(): Response
    {
        return $this->render('admin/admin_subscription/show.html.twig', [
            'controller_name' => 'AdminSubscriptionController',
        ]);
    }
}
