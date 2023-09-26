<?php

namespace App\Controller\Middle;

use App\Form\EditUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student', name: 'dtc_student_')]
class StudentProfileController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        $student = $this->getUser();

        return $this->render('middle/student_profile/index.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editUser(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $user = $this->userRepository->find($id);

        $form = $this->createForm(EditUserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();

            if ($file) {
                $fileContents = base64_encode(file_get_contents($file->getPathname()));

                $user->setImage($fileContents);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('dtc_student_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('middle/student_profile/edit_user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
