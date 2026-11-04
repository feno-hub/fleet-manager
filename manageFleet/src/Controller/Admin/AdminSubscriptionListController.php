<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminSubscriptionListController extends AbstractController
{
    #[Route('/admin/subscription/category/list', name: 'admin.subscription.list')]
    public function index(): Response
    {
        return $this->render('admin/admin_subscription_list/index.html.twig', [
            'controller_name' => 'AdminSubscriptionListController',
        ]);
    }
}
