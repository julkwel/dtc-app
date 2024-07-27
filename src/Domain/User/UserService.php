<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 21/07/2024
 */

namespace App\Domain\User;

use App\Entity\StudentFormation;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserService
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $userPasswordHasher, private UserRepository $userRepository, private PaginatorInterface $paginator, private SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/img/pictures')] private string $brochuresDirectory)
    {
    }

    public function fetchUsers(Request $request): PaginationInterface
    {
        $query = $this->userRepository->getAllUsers($request);

        return $this->paginator->paginate($query, $request->query->get('page') ?? 1, 10);
    }

    public function createUserFromCommand(StyleInterface $style)
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

    /**
     * @throws Exception
     */
    public function createUser(FormInterface $form): bool
    {
        /** @var User $user */
        $user = $form->getData();
        $file = $form->get('image')->getData();
        if ($file instanceof UploadedFile) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move($this->brochuresDirectory, $newFilename);
            } catch (FileException $e) {
                throw new Exception($e->getMessage());
            }

            $user->setImage($newFilename);
        }

        if (!$user->getId()) {
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();

        return true;
    }

    public function fetchUserFormation(UserInterface $user): array
    {
        return $this->entityManager->getRepository(StudentFormation::class)->findBy(['user' => $user]);
    }

    public function fetchNotPaidUserFormation(UserInterface $user): array
    {
        return $this->entityManager->getRepository(StudentFormation::class)->findBy(['user' => $user, 'isTotalPaid' => false]);
    }
}