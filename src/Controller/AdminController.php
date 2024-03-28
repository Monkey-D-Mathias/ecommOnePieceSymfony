<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
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
}
