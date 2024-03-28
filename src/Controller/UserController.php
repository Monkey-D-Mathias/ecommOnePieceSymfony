<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

/*     #[Route('/my-profile', name: 'app_user_my_profile')]
    public function myProfile(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Si aucun utilisateur n'est connecté, exception ou redirection vers page connexion
            throw new AccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    } */

    #[Route('/profil', name: 'app_user_show', methods: ['GET'])]
    public function show(UserRepository $userRepository, AuthorizationCheckerInterface $authorizationChecker, Request $request): Response
    {
        $user = $userRepository->findOneBy(['id' => $this->getUser()->getId()]);
        if(!$user){
            return new Response('NON', 403);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show_admin', methods: ['GET'])]
    public function showAdmin(User $user, AuthorizationCheckerInterface $authorizationChecker, Request $request): Response
    {

        if(!$authorizationChecker->isGranted('ROLE_ADMIN') && $this->getUser()->getId() != $user->getId()){
            return new Response('NON', 403);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
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

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
