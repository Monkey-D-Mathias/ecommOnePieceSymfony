<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginSuccessRedirect implements AuthenticationSuccessHandlerInterface
{
    private $urlGenerator;
    private $security;

    public function __construct(UrlGeneratorInterface $urlGenerator, Security $security)
    {
        $this->urlGenerator = $urlGenerator;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ? RedirectResponse
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            // Redirige les utilisateurs avec le rôle admin vers une autre page
            return new RedirectResponse($this->urlGenerator->generate('app_admin'));
        }

        // Redirige les autres utilisateurs vers la page de profil par défaut
        return new RedirectResponse($this->urlGenerator->generate('app_default'));
    }
}