<?php

namespace App\Controller\Middle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student', name: 'dtc_student_')]
class StudentProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('middle/student_profile/index.html.twig', [
            'student' => $this->getUser(),
        ]);
    }
}
