<?php
/**
 * @author Bocasay jul
 * Date : 19/09/2023
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/dashboard', name: 'admin_dashboard_')]
class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index()
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}