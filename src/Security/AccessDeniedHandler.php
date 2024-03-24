<?php

namespace App\Security;

use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $urlGenerator;
    private $requestStack;

    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
    {
        // acceder à la session 
        $session = $this->requestStack->getSession();

        // ajouter un message flash personnalisé
        $session->getFlashBag()->add('errorAccesDenied', 'Access Denied.');


        //Générer l'URL de redirection
        $loginUrl = $this->urlGenerator->generate('app_login');
        // redirection vers la page login
        return new RedirectResponse($loginUrl);
        
    }
}