<?php

namespace App\Controller\Middle;

use App\Domain\User\UserService;
use App\Entity\User;
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
    public function register(Request $request, UserService $userService, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {
        $student = new User();
        $form = $this->createForm(RegistrationFormType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->registerFromHomePage($form, $student);
            $this->addFlash('success', 'Merci pour votre inscription, nous vous contacterons plus tard');

            return $this->redirectToRoute('dtc_login');
        }

        return $this->render('middle/_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
