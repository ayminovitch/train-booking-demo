<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$firstname, $lastname, $username, $password, $email, $phone, $roles, $confirmed, $active]) {
            $user = new User();
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setUsername($username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setConfirmed($confirmed);
            $user->setActive($active);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$firstname, $lastname, $username, $password, $email, $phone, $roles, $confirmed, $active];
            ['Jane', 'Doe', 'jane_admin', 'kitten', 'jane_admin@symfony.com', '2222222222222', ['ROLE_ADMIN'], true, true],
            ['Tom', 'Doe', 'tom_admin', 'kitten', 'tom_admin@symfony.com', '2222222222222', ['ROLE_CONDUCTOR'], true, true],
            ['John', 'Doe', 'john_user', 'kitten', 'john_user@symfony.com', '2222222222222', ['ROLE_USER'], true, true],
        ];
    }
}
