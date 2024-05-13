<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\CartItemRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    // #[Route('/', name: 'app_cart_index', methods: ['GET'])]
    // public function index(CartRepository $cartRepository): Response
    // {
        // return $this->render('cart/index.html.twig', [
            // 'carts' => $cartRepository->findAll(),
        // ]);
    // }

    #[Route('/add/product/{id}', name: 'add_cart_product', methods: ['GET'])]
    public function new(Product $product, CartRepository $cartRepository, CartItemRepository $cartItemRepoitory, Request $request, EntityManagerInterface $entityManager)//: Response
    {
        $user = $this->getUser();
        $userHaveCart = $cartRepository->findOneBy(["user" => $this->getUser(), "savedAt" => null]);
        //Si l'utilisateur n'as pas de panier
        if(!$userHaveCart){
            //On le créer
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setCreatedAt(new \DateTimeImmutable);
            $entityManager->persist($cart);
            $entityManager->flush();
        }
        else{
            $cart = $userHaveCart;
        }

        //Recherche si des produit existe ou pas
        $productAlreadyExist = false;
        $cartProducts = $cartItemRepoitory->findOneBy(["cart" => $cart]);
        if ($cartProducts) {
            // Recherche le produit ajouter si il existe ou pas dans la liste
            foreach ($cartProducts->getProducts() as $cartProduct) {
                if ($cartProduct == $product) {
                    $productAlreadyExist = true;
                    break;
                }
            }
        }
        //Si il existe pas 
        if (!$productAlreadyExist) {
            //On ajoute le produit
            $cartItem = new CartItem();
            $cartItem->addProduct($product);
            $cartItem->setCart($cart);
            $cartItem->setQuantity(1);
            $cartItem->setCreatedAt(new DateTime);
        }
        else{
            //Si le produit existe déjà dans la panier on modifie la quantité
            $cartItem = $cartProducts;
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        }
        $entityManager->persist($cartItem);
        $entityManager->flush();
        // Envoyer un message flash
        $this->addFlash('add_product', 'Produit ajouté avec succès.');
        return $this->redirectToRoute('app_product_show', ["id" => $product->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/', name: 'app_cart_show', methods: ['GET'])]
    public function show(CartRepository $cartRepository): Response
    {
        $user = $this->getUser();
        $cart = $cartRepository->findOneBy(["user" => $user, "savedAt" => null]);
        $total = 0;
        foreach ($cart->getCartItems() as $item) {
            $products = $item->getProducts();
            $quantity = $item->getQuantity();
            foreach ($products as $product) {
                $total = $total + $product->getPriceHt() * $quantity;
            }
        }
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
            'total' =>  $total
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_cart_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    // {
        // $form = $this->createForm(CartType::class, $cart);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager->flush();

            // return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->render('cart/edit.html.twig', [
            // 'cart' => $cart,
            // 'form' => $form,
        // ]);
    // }

    // #[Route('/{id}', name: 'app_cart_delete', methods: ['POST'])]
    // public function delete(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    // {
        // if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            // $entityManager->remove($cart);
            // $entityManager->flush();
        // }

        // return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    // }
}
