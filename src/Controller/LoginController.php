<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authUtils, Security $security): Response
    {
         // Vérifie si l'utilisateur est déjà authentifié
         if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Redirige l'utilisateur vers une autre page, par exemple la page d'accueil
            if ($security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin');
            }
            else{
                return $this->redirectToRoute('app_default');
            }
        }
        // récupère l'erreur et l'email utilisé pour la dernière tentative de connexion
        $error = $authUtils->getLastAuthenticationError();
        $username = $authUtils->getLastUserName();

        return $this->render('login/index.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
