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
        $user = $this->getUser();
        if(!$user){
            //Le retourne vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
