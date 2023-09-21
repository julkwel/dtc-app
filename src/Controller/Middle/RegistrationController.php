<?php

namespace App\Controller\Middle;

use App\Entity\Student;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'dtc_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $student = new Student();
        $form = $this->createForm(RegistrationFormType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();

            $encodedPassword = $userPasswordHasher->hashPassword($student, $plainPassword);
            $student->setPassword($encodedPassword);

            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('dtc_student_profile');
        }

        return $this->render('middle/_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
