<?php

namespace App\Controller\Middle;

use App\Domain\User\UserService;
use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactFormType;
use App\Form\UserType;
use App\Repository\TransactionRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student', name: 'dtc_student_')]
class StudentProfileController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        $student = $this->getUser();

        return $this->render('middle/student_profile/index.html.twig', [
            'student' => $student,
            'formations' => $this->userService->fetchUserFormation($student),
            'paiements' => $this->userService->fetchNotPaidUserFormation($student),
        ]);
    }

    #[Route('/my-formation', name: 'my_formation')]
    public function myFormation(): Response
    {
        $student = $this->getUser();

        return $this->render('middle/student_profile/formations.html.twig', ['formations' => $this->userService->fetchUserFormation($student)]);
    }

    /**
     * @throws Exception
     */
    #[Route('/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editUser(Request $request): Response
    {
        $user = $this->getUser();
        $formations = $this->userService->fetchUserFormation($user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->handleUser($form);

            return $this->redirectToRoute('dtc_student_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('middle/student_profile/edit_user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formations' => $formations,
        ]);
    }
}
