<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 24/07/2024
 */

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    #[Route('', name: 'list')]
    public function listUser()
    {

    }
}