<?php

namespace App\Controller\Account;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'vehicule')]
    public function index(): Response
    {
        return $this->render('account/vehicule/index.html.twig', [
            'controller_name' => 'VehiculeController',
        ]);
    }
  

    #[Route('/dashboard/vehicles/new', name: 'app_vehicle_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $vehicle = new Vehicle();

        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vehicle->setCreatedAt(new \DateTimeImmutable());

            // Associer le véhicule à l'utilisateur connecté
            $vehicle->setUser($user);

            $entityManager->persist($vehicle);
            $entityManager->flush();

            $this->addFlash('success', 'Le véhicule a été ajouté avec succès.');

            return $this->redirectToRoute('app_vehicle_new');
        }

        return $this->render('account/vehicule/insert.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
