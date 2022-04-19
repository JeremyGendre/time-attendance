<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@test.com',
                'lastname' => 'Doe',
                'firstname' => 'John',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'username' => 'user1',
                'email' => 'user1@test.com',
                'lastname' => 'Valjean',
                'firstname' => 'Jean',
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
            $manager->persist($user);
        }

        $manager->flush();
    }
}
