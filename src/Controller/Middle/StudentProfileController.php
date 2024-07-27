<?php

namespace App\Controller\Middle;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student', name: 'dtc_student_')]
class StudentProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        $student = $this->getUser();

        return $this->render('middle/student_profile/index.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editUser(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file) {
                $fileContents = base64_encode(file_get_contents($file->getPathname()));

                $user->setImage($fileContents);
            }

            foreach ($user->getContacts() as $contact) {
                $contact->setUser($user);
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
