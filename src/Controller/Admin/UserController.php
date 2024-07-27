<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 24/07/2024
 */

namespace App\Controller\Admin;

use App\Domain\User\UserService;
use App\Entity\User;
use App\Form\UserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('', name: 'list')]
    public function listUser(Request $request): Response
    {
        $pagination = $this->userService->fetchUsers($request);

        return $this->render(
            'admin/dashboard/user/index.html.twig',
            [
                'pagination' => $pagination,
                'search' => $request->get('search'),
            ]
        );
    }

    #[Route('/edit/{id?}', name: 'edit')]
    public function editUser(Request $request, User $user = null): Response
    {
        $user = $user ?? new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->userService->createUser($form);
                $this->addFlash('success', 'Utilisateur crée avec success !');

                return $this->redirectToRoute('admin_user_list');
            } catch (Exception $exception) {
                dd($exception->getMessage());
                $this->addFlash('error', $exception->getMessage());

                $this->redirectToRoute('admin_user_edit', ['id' => $user->getId()]);
            }
        }

        return $this->render('admin/dashboard/user/edit.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }
}