<?php

namespace App\Form;

use App\Entity\SubscriptionCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class SubscriptionCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du forfait',
                'attr' => [
                    'placeholder' => 'Ex : Premium',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le nom du forfait est obligatoire.'),
                    new Length(
                        min: 2,
                        max: 30,
                        minMessage: 'Le nom doit contenir au moins 2 caractères.',
                        maxMessage: 'Le nom ne doit pas dépasser 30 caractères.'
                    ),
                ],
            ])

            ->add('price', NumberType::class, [
                'label' => 'Prix (Ar)',
                'scale' => 0,
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Ex : 150000',
                    'min' => 0,
                    'step' => 1,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le prix est obligatoire.'),
                    new PositiveOrZero(message: 'Le prix doit être positif ou égal à zéro.'),
                ],
            ])

            ->add('duration', IntegerType::class, [
                'label' => 'Durée (jours)',
                'attr' => [
                    'placeholder' => 'Ex : 30',
                    'min' => 1,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(message: 'La durée est obligatoire.'),
                    new Positive(message: 'La durée doit être supérieure à zéro.'),
                ],
            ])

            ->add('vehicle_limit', IntegerType::class, [
                'label' => 'Nombre de véhicules',
                'attr' => [
                    'placeholder' => 'Ex : 10',
                    'min' => 1,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(message: 'La limite de véhicules est obligatoire.'),
                    new Positive(message: 'La limite doit être supérieure à zéro.'),
                ],
            ])

            ->add('driver_limit', IntegerType::class, [
                'label' => 'Nombre de conducteurs',
                'attr' => [
                    'placeholder' => 'Ex : 5',
                    'min' => 1,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(message: 'La limite de conducteurs est obligatoire.'),
                    new Positive(message: 'La limite doit être supérieure à zéro.'),
                ],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description du forfait',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Décrivez les avantages de ce forfait...',
                    'class' => 'form-control',
                ],
            ])

            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Actif' => 'active',
                    'Inactif' => 'inactive',
                ],
                'placeholder' => 'Choisir un statut',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(message: 'Veuillez sélectionner un statut.'),
                ],
            ])

            ->add('isPopular', CheckboxType::class, [
                'label' => 'Afficher comme forfait le plus populaire',
                'required' => false,
                'attr' => [
                    'class' => 'form-checkbox',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubscriptionCategory::class,
        ]);
    }
}
