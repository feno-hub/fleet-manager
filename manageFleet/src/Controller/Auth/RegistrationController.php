<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use DateTimeImmutable;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private EmailVerifier $emailVerifier
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserRepository $userRepos,
        Security $security,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();

        $form = $this->createForm(
            RegistrationFormType::class,
            $user
        );

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $nif = $user->getNif();
            $email = $user->getEmail();

            if ($nif !== null && trim((string) $nif) !== '') {
                $existingNif = $userRepos->findOneBy([
                    'nif' => $nif,
                ]);

                if ($existingNif !== null) {
                    $form->get('nif')->addError(
                        new FormError(
                            'Ce numéro de NIF est déjà utilisé.'
                        )
                    );
                }
            }

            if ($email !== null && trim($email) !== '') {
                $existingEmail = $userRepos->findOneBy([
                    'email' => $email,
                ]);

                if ($existingEmail !== null) {
                    $form->get('email')->addError(
                        new FormError(
                            'Cette adresse e-mail est déjà utilisée.'
                        )
                    );
                }
            }

            if ($form->isValid()) {
                $plainPassword = $form
                    ->get('plainPassword')
                    ->getData();

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $plainPassword
                    )
                );

                $user->setCreatedAt(
                    new DateTimeImmutable()
                );

                $user->setStatus(
                    'pending'
                );

                $user->setRoles(['ROLE_USER']);

                $entityManager->persist($user);

                try {
                    $entityManager->flush();
                } catch (UniqueConstraintViolationException $exception) {
                    $entityManager->refresh($user);

                    $form->addError(
                        new FormError(
                            'Un compte existe déjà avec ces informations. Vérifiez votre NIF et votre adresse e-mail.'
                        )
                    );

                    return $this->render(
                        'pages/auth/registration/register.html.twig',
                        [
                            'registrationForm' => $form,
                        ]
                    );
                }

                $this->emailVerifier->sendEmailConfirmation(
                    'app_verify_email',
                    $user,
                    (new TemplatedEmail())
                        ->from(
                            new Address(
                                'fenosoarafidinirina@gmail.com',
                                'Gestion de flotte automobile'
                            )
                        )
                        ->to((string) $user->getEmail())
                        ->subject('Confirmez votre adresse e-mail')
                        ->htmlTemplate(
                            'pages/auth/registration/confirmation_email.html.twig'
                        )
                );

                $this->addFlash(
                    'success',
                    'Votre compte a été créé avec succès ! Il est en attente de validation par l’administrateur. Vous pourrez accéder à votre espace après approbation.'
                );

                return $this->redirectToRoute('home');
            }
        }

        return $this->render(
            'pages/auth/registration/register.html.twig',
            [
                'registrationForm' => $form,
            ]
        );
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(
            'IS_AUTHENTICATED_FULLY'
        );

        /** @var User $user */
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        try {
            $this->emailVerifier->handleEmailConfirmation(
                $request,
                $user
            );
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash(
                'verify_email_error',
                $translator->trans(
                    $exception->getReason(),
                    [],
                    'VerifyEmailBundle'
                )
            );

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash(
            'success',
            'Votre adresse e-mail a été confirmée avec succès.'
        );

        return $this->redirectToRoute('app_register');
    }
}
