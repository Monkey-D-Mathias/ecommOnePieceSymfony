<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\File;
use App\Form\FileType;
use App\Repository\CartRepository;
use App\Service\ImageManager;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\ProductType;
use App\Form\UserType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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

    #[Route('/upload', name: 'app_admin_upload')]
    public function upload(Request $request, ImageManager $imageManager, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $file = new File();

        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('file')->getData();
            $fileName = $imageManager->upload($uploadedFile, $file->isPublic());

            $file->setPath($fileName);
            $file->setType('image');
            $file->setCreatedOn(new \DateTimeImmutable());

            $entityManager->persist($file);
            $entityManager->flush();
        }

        return $this->render('admin/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/download', name: 'app_admin_download')]
    public function download(EntityManagerInterface $em)
    {
        $images = $em->getRepository(File::class)->findAll();
        return $this->render("admin/download.html.twig", [
            'images' => $images
        ]);

    }

    #[Route('/image/stream/{id}', name: 'app_image_stream')]
    public function imageStream(int $id, EntityManagerInterface $em, ImageManager $imageManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $image = $em->getRepository(File::class)->find($id);
        $filePath = $image->getPath();

        //return new Response('Fichier ok derrier image->path');

        return $imageManager->stream($filePath);
    }

    //#[Route('/user', name: 'app_user_index', methods: ['GET'])]
    #[Route('/user', name: 'app_user_index_admin', methods: ['GET'])]
    public function indexUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/new', name: 'app_user_new_admin', methods: ['GET', 'POST'])]
    public function newUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show_admin', methods: ['GET'])]
    public function showUser(User $user, AuthorizationCheckerInterface $authorizationChecker, Request $request): Response
    {
        return $this->render('/admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /*
    #[Route('/user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    */
  
    #[Route('/user/{id}/edit', name: 'app_user_edit_admin', methods: ['GET', 'POST'])]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $role = $form->get('roles')->getData();;
            $roles = [];
            $roles[] = $role;
            $roles[] = "ROLE_USER"; 
            $user->setRoles($roles);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /*
    #[Route('/user/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    */
  
    #[Route('/user/{id}', name: 'app_user_delete_admin', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    //Produits
    #[Route('/product', name: 'app_product_index_admin', methods: ['GET'])]
    public function indexProducts(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product/new', name: 'app_product_new_admin', methods: ['GET', 'POST'])]
    public function newProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTime);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_show_admin', methods: ['GET'])]
    public function showProduct(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/edit', name: 'app_product_edit_admin', methods: ['GET', 'POST'])]
    public function editProduct(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_delete_admin', methods: ['POST'])]
    public function deleteProduct(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index_admin', [], Response::HTTP_SEE_OTHER);
    }
}
