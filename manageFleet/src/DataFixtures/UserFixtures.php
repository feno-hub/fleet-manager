<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $users = [];

        for ($i = 0; $i < 30; $i++) {

            $user = new User();

            $user->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPhone($faker->phoneNumber())
                ->setPoste($faker->jobTitle())
                ->setRoles(['ROLE_USER'])
                ->setNameCompany($faker->company())
                ->setTotalCar($faker->numberBetween(5, 35))
                ->setSector($faker->randomElement([
                    'Informatique',
                    'Transport',
                    'Automobile',
                    'Restauration',
                    'Commerce',
                    'Bâtiment',
                    'Santé',
                    'Éducation',
                    'Finance',
                    'Agriculture',
                ]))
                ->setStatus($faker->randomElement([
                    'pending',
                    'accepted',
                    'rejected',
                ]))
                ->setAddressCompany($faker->address())
                ->setPassword(
                    $this->passwordHasher->hashPassword(
                        $user,
                        'password'
                    )
                )
                ->setNif($faker->unique()->numerify('##########'))
                ->setEmail($faker->unique()->safeEmail())
                ->setIsVerified(mt_rand(0, 1))
                ->setCreatedAt(
                    \DateTimeImmutable::createFromMutable(
                        $faker->dateTimeBetween('-1 year', 'now')
                    )
                );

            $manager->persist($user);
        }

        $manager->flush();


        $manager->flush();
    }
}
