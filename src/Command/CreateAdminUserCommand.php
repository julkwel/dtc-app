<?php

namespace App\Command;

use App\Domain\User\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'dtc:user',
    description: 'Create user with ROLE_ADMIN',
)]
class CreateAdminUserCommand extends Command
{
    public function __construct(private readonly UserService $userService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('create', null, InputOption::VALUE_NONE, 'Create user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        if ($input->getOption('create')) {
            $this->userService->createUserFromCommand($style);

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
