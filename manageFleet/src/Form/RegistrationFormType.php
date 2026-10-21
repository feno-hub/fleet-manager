<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Positive;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Entrez votre prénom',
                    'autocomplete' => 'given-name',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le prénom est obligatoire.'),
                    new Length(
                        min: 2,
                        max: 25,
                        minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        maxMessage: 'Le prénom ne doit pas dépasser {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Entrez votre nom',
                    'autocomplete' => 'family-name',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le nom est obligatoire.'),
                    new Length(
                        min: 2,
                        max: 25,
                        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.',
                        maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => '+261 34 00 000 00',
                    'autocomplete' => 'tel',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le numéro de téléphone est obligatoire.'),
                    new Length(
                        min: 9,
                        max: 20,
                        minMessage: 'Le numéro de téléphone est trop court.',
                        maxMessage: 'Le numéro de téléphone est trop long.'
                    ),
                    new Regex(
                        pattern: '/^\+?[0-9\s().-]+$/',
                        message: 'Veuillez saisir un numéro de téléphone valide.'
                    ),
                ],
            ])
            ->add('name_company', TextType::class, [
                'label' => 'Nom de l’entreprise',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Nom de votre entreprise',
                    'autocomplete' => 'organization',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le nom de l’entreprise est obligatoire.'),
                    new Length(
                        min: 2,
                        max: 100,
                        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.',
                        maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('nif', TextType::class, [
                'label' => 'NIF de l’entreprise',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Entrez le NIF de votre entreprise',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le NIF est obligatoire.'),
                    new Length(
                        max: 50,
                        maxMessage: 'Le NIF ne doit pas dépasser {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('address_company', TextType::class, [
                'label' => 'Adresse de l’entreprise',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Adresse complète de votre entreprise',
                    'autocomplete' => 'street-address',
                ],
                'constraints' => [
                    new NotBlank(message: 'L’adresse de l’entreprise est obligatoire.'),
                    new Length(
                        min: 5,
                        max: 255,
                        minMessage: 'L’adresse doit contenir au moins {{ limit }} caractères.',
                        maxMessage: 'L’adresse ne doit pas dépasser {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('sector', TextType::class, [
                'label' => 'Secteur d’activité',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Ex. : Transport, logistique',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le secteur d’activité est obligatoire.'),
                    new Length(min: 2, max: 255),
                ],
            ])
            ->add('poste', TextType::class, [
                'label' => 'Votre poste dans l’entreprise',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Ex. : Responsable de flotte',
                ],
                'constraints' => [
                    new NotBlank(message: 'Votre poste est obligatoire.'),
                    new Length(min: 2, max: 255),
                ],
            ])
            ->add('total_car', IntegerType::class, [
                'label' => 'Nombre de véhicules',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'Ex. : 10',
                    'min' => 1,
                ],
                'constraints' => [
                    new NotBlank(message: 'Le nombre de véhicules est obligatoire.'),
                    new Positive(
                        message: 'Le nombre de véhicules doit être supérieur à zéro.'
                    ),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail professionnelle',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => 'nom@entreprise.mg',
                    'autocomplete' => 'email',
                ],
                'constraints' => [
                    new NotBlank(message: 'L’adresse e-mail est obligatoire.'),
                    new Email(message: 'Veuillez saisir une adresse e-mail valide.'),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'register-input',
                    'placeholder' => '8 caractères minimum',
                    'autocomplete' => 'new-password',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le mot de passe est obligatoire.'),
                    new Length(
                        min: 8,
                        max: 4096,
                        minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J’accepte les conditions d’utilisation.',
                'row_attr' => [
                    'class' => 'form-check register-terms',
                ],
                'attr' => [
                    'class' => 'register-checkbox',
                ],
                'label_attr' => [
                    'class' => 'register-terms-label',
                ],
                'constraints' => [
                    new IsTrue(
                        message: 'Vous devez accepter les conditions d’utilisation.'
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
