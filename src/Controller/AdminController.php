<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(CartRepository $cartRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // $entity = $cartRepo->findOneBy(['critère' => 'valeur']);
        // $this->denyAccessUnlessGranted('ADMIN_COMPTABLE', $entity);

        // $test = true;
        // if ($test === true) {
        //     throw $this->createAccessDeniedException('message de refus');
        // }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/users', name: 'app_user_index', methods: ['GET'])]
    public function indexUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
