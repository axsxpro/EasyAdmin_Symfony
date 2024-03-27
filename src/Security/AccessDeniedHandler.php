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

        // // acceder à la session 
        // $session = $this->requestStack->getSession();

        // // ajouter un message flash personnalisé
        // $session->getFlashBag()->add('errorAccessDenied', 'Access Denied.');

        // // Générer l'URL de redirection 
        // $loginUrl = $this->urlGenerator->generate('app_login');

        // // Redirection vers app_login 
        // return new RedirectResponse($loginUrl);


        // Générer l'URL de déconnexion
        $logoutUrl = $this->urlGenerator->generate('app_logout');

        // Redirection vers la page de déconnexion pour déconnecter l'utilisateur
        $response = new RedirectResponse($logoutUrl);

        // Supprimer tout cookie de session potentiellement persistant
        // headers: propriété de l'objet $response, en-têtes de la réponse HTTP. Les en-têtes HTTP sont des métadonnées associées à la réponse HTTP qui contrôlent différents aspects de la communication entre le client et le serveur.
        // PHPSESSID: identifiant de session PHP 
        $response->headers->clearCookie('PHPSESSID');

        // l'en-tête de la réponse est modifié pour définir une nouvelle redirection (Location) vers la page de connexion (app_login)
        $response->headers->set('Location', $this->urlGenerator->generate('app_login', ['errorAccessDenied' => true]));

        return $response;

    }

}