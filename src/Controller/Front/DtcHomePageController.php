<?php

namespace App\Controller\Front;

use App\Entity\Cohorte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'dtc_')]
class DtcHomePageController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'home_page')]
    public function index(): Response
    {
        $openFormation = $this->entityManager->getRepository(Cohorte::class)->findBy(['isRegisterOpen' => true]);

        return $this->render('dtc_home_page/index.html.twig', [
            'controller_name' => '',
            'formations' => $openFormation,
        ]);
    }
}
