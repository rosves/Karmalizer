<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Routing\RouterInterface;

class LoginHandler implements AuthenticationSuccessHandlerInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();
        var_dump($user->getRoles());

        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            $response = new RedirectResponse($this->router->generate('admin'));
        } elseif (in_array('ROLE_USER', $user->getRoles(), true)) {
            $response = new RedirectResponse($this->router->generate('app_dashboard'));
        } else {
            $response = new RedirectResponse($this->router->generate('app_home'));
        }

        return $response;
    }
}