<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 21/07/2024
 */

namespace App\Domain\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function createUserFromCommand(SymfonyStyle $style)
    {
        $firstname = $style->ask('Please enter your firstname [required]');
        $lastname = $style->ask('Please enter your lastname [optional]');
        $username = $style->ask('Please enter your username [required]');
        $password = $style->askHidden('Please enter your password [required]');
        $role = $style->ask('Role ?', 'ROLE_ADMIN');


        if (empty($firstname) || empty($username) || empty($password)) {
            $style->warning('Please fill all fields');
            return Command::FAILURE;
        }

        $user = new User();
        $user->setFirstname($firstname);
        $user->setUsername($username);
        $user->setLastname($lastname);

        $encodedPassword = $this->userPasswordHasher->hashPassword($user, $password);
        $user->setPassword($encodedPassword);
        $user->setRoles([$role]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $style->success('Admin created successfully.');
    }
}