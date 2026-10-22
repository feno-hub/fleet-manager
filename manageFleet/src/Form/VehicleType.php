<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class, [
                'label' => 'Marque',
                'attr' => [
                    'placeholder' => 'Ex. : Toyota',
                ],
            ])
            ->add('model', TextType::class, [
                'label' => 'Modèle',
                'attr' => [
                    'placeholder' => 'Ex. : Hilux',
                ],
            ])
            ->add('registrationNumber', TextType::class, [
                'label' => 'Numéro d’immatriculation',
                'attr' => [
                    'placeholder' => 'Ex. : 1234 TAA',
                ],
            ])
            ->add('vin', TextType::class, [
                'label' => 'Numéro VIN',
                'attr' => [
                    'placeholder' => 'Numéro d’identification du véhicule',
                ],
            ])
            ->add('vehicleType', ChoiceType::class, [
                'label' => 'Type de véhicule',
                'placeholder' => 'Sélectionnez un type',
                'choices' => [
                    'Berline' => 'Berline',
                    'SUV' => 'SUV',
                    'Utilitaire' => 'Utilitaire',
                    'Camion' => 'Camion',
                    'Bus' => 'Bus',
                    'Moto' => 'Moto',
                    'Pick-up' => 'Pick-up',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('color', TextType::class, [
                'label' => 'Couleur',
                'attr' => [
                    'placeholder' => 'Ex. : Blanc',
                ],
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année de fabrication',
                'attr' => [
                    'placeholder' => 'Ex. : 2024',
                    'min' => 1900,
                    'max' => (int) date('Y') + 1,
                ],
            ])
            ->add('mileage', TextType::class, [
                'label' => 'Kilométrage (km)',
                'attr' => [
                    'placeholder' => 'Ex. : 45000',
                    'inputmode' => 'numeric',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'État du véhicule',
                'placeholder' => 'Sélectionnez un état',
                'choices' => [
                    'Disponible' => 'Disponible',
                    'En utilisation' => 'En utilisation',
                    'En maintenance' => 'En maintenance',
                    'Hors service' => 'Hors service',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
