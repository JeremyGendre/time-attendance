<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\ServiceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, ServiceRepository $serviceRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->serviceRepository = $serviceRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@test.com',
                'lastname' => 'Doe',
                'firstname' => 'John',
                'service' => 'DIR',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'username' => 'user1',
                'email' => 'user1@test.com',
                'lastname' => 'Valjean',
                'firstname' => 'Jean',
                'service' => 'IT',
                'roles' => null
            ]
        ];

        foreach ($data as $userInfos){
            $user = new User();
            $user
                ->setEmail($userInfos['email'])
                ->setUsername($userInfos['username'])
                ->setRoles($userInfos['roles'] ?? ['ROLE_USER'])
                ->setFirstname($userInfos['firstname'])
                ->setLastname($userInfos['lastname'])
                ->setPassword($this->passwordHasher->hashPassword($user, 'johndoe'));

            $service = $this->serviceRepository->findOneBy(['shortname' => $userInfos['service']]);
            if($service){
                $user->setService($service);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @psalm-return array<class-string<FixtureInterface>>
     */
    public function getDependencies()
    {
        return [
            ServiceFixtures::class
        ];
    }
}
