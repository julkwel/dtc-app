<?php

namespace App\Controller\Front;

use App\Entity\Cohorte;
use App\Entity\Review;
use App\Entity\SiteContact;
use App\Entity\StudentFormation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'dtc_')]
class DtcHomePageController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'home_page')]
    public function index(): Response
    {
        $openFormation = $this->entityManager->getRepository(Cohorte::class)->findBy(['isRegisterOpen' => true]);
        $students = $this->entityManager->getRepository(StudentFormation::class)->findBy([]);
        $reviews = $this->entityManager->getRepository(Review::class)->findBy(['isEnabled' => true]);

        return $this->render('dtc_home_page/index.html.twig', [
            'controller_name' => '',
            'formations' => $openFormation,
            'students' => $students,
            'reviews' => $reviews,
        ]);
    }

    #[Route('/message', name: 'site_message')]
    public function createMessage(Request $request): RedirectResponse
    {
        $firstName = $request->get('firstname');
        $email = $request->get('email');
        $subject = $request->get('subject');
        $message = $request->get('message');

        if (empty($firstName) || empty($message) || empty($email) || empty($subject)) {
            $this->addFlash('error', 'Message non envoyé, veuillez completer les champs !');

            return $this->redirectToRoute('dtc_home_page');
        }

        $siteMessage = new SiteContact();
        $siteMessage->setMessage($message)->setFirstname($firstName)->setEmail($email)->setSubject($subject);
        $this->entityManager->persist($message);
        $this->entityManager->flush();
        $this->addFlash('success', 'Nous avons bien reçu votre message !');

        return $this->redirectToRoute('dtc_home_page');
    }

    #[Route('/rest-password', name: 'reset_password')]
    public function resetPassword(): Response
    {
        return $this->render('dtc_home_page/_reset_pass.html.twig');
    }
}
