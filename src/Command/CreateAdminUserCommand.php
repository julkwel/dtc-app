<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'dtc-app:create:admin',
    description: 'Create user with ROLE_ADMIN',
)]
class CreateAdminUserCommand extends Command
{
    private $entityManager;
    private $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher,)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('firstname', null, InputOption::VALUE_REQUIRED, 'Firstname')
            ->addOption('lastname', null, InputOption::VALUE_OPTIONAL, 'Lastname')
            ->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Username')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $firstname = $style->ask('Please enter your firstname [required]');
        $lastname = $style->ask('Please enter your lastname [optional]');
        $username = $style->ask('Please enter your username [required]');
        $password = $style->askHidden('Please enter your password [required]');

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
        $user->setRoles(['ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $style->success('Admin created successfully.');

        return Command::SUCCESS;

    }
}
