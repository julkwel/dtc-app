<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 01/08/2024
 */

namespace App\Controller\Admin;

use App\Repository\SiteContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/site-contact', name: 'admin_site_contact_')]
class SiteContactController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function listMessage(SiteContactRepository $siteContactRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('admin/site-contact/index.html.twig', ['messages' => $siteContactRepository->findAll()]);
    }
}