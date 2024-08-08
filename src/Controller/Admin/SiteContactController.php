<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 01/08/2024
 */

namespace App\Controller\Admin;

use App\Entity\SiteContact;
use App\Repository\SiteContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/site-contact', name: 'admin_site_contact_')]
class SiteContactController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function listMessage(SiteContactRepository $siteContactRepository): Response
    {
        return $this->render('admin/site-contact/index.html.twig', ['messages' => $siteContactRepository->findAll()]);
    }

    #[Route('/view/{id}', name: 'view')]
    public function viewMessage(EntityManagerInterface $entityManager, SiteContact $siteContact): RedirectResponse
    {
        $siteContact->setView(true);
        $siteContact->setViewDate(new \DateTime('now'));
        $entityManager->flush();

        return $this->redirectToRoute('admin_site_contact_list');
    }
}