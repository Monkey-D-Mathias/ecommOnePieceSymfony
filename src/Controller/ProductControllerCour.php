<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductControllerCour extends AbstractController
{
    //Method with request XHR

    #[Route('/cour/list/produit', name: 'list')]
    //our SF 6.x
    public function list(ProductRepository $pr): Response
    //ublic function list(EntityManager $em): Response
    {
     //   Avant SF 6.x
        //$products = $em->getRepository(Product::class)->finBy(['deletedOn' => null]);
        //Depuis SF 6.x
      //  $product = $pr->findAll();
        $products = $pr->findBy(['deleted_at' => null]);

        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }

    public function view(string $slug): Response
    {
        return $this->render('product/view.html.twig');
    }
}