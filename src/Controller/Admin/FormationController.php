<?php

/**
 * @author Fullfifax
 * Date : 03/11/2023
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/dashboard/formation', name: 'admin_formation_')]
class FormationController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function listFormation()
    {
        return $this->render('admin/dashboard/formation.html.twig');
    }
}