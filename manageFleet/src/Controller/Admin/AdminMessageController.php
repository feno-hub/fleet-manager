<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminMessageController extends AbstractController
{
    #[Route('/admin/message/liste', name: 'app.admin.message')]
    public function index(): Response
    {
        return $this->render('admin/admin_message/list.html.twig', [
            'controller_name' => 'AdminMessageController',
        ]);
    }
}
