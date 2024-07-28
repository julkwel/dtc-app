<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 28/07/2024
 */

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/review', name: 'admin_review_')]
class ReviewController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private ReviewRepository $repository)
    {
    }

    #[Route('/', name: 'list')]
    public function listReview()
    {
        return $this->render('admin/dashboard/review/index.html.twig', ['reviews' => $this->repository->findAll()]);
    }

    #[Route('/change-status/{id}', name: 'status')]
    public function changeStatus(Review $review)
    {
        $review->setEnabled(!$review->isEnabled());
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_review_list');
    }

    #[Route('/manage/{id?}', name: 'manage')]
    public function createReview(Request $request, Review $review = null)
    {
        $review = $review ?? new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setUser($this->getUser());
            if (!$review->getId()) {
                $this->entityManager->persist($review);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_review_list');
        }

        return  $this->render('admin/dashboard/review/manage_review.html.twig', ['form' => $form->createView()]);
    }
}