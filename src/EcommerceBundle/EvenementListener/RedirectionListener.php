<?php
namespace EcommerceBundle\EvenementListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\User;

Class RedirectionListener
{
    private $tokenStorage;
    private $router;
    private $session;


    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router, Session $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->session = $session;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');

        if ($route == 'ecommerce_panier_livraison' || $route == 'ecommerce_panier_validation')
        {
            if ($this->session->has('panier'))
            {
                if (count($this->session->has('panier')) == 0)
                    $event->setResponse(new RedirectResponse($this->router->generate('ecommerce_panier_panier')));
            }

            if (!is_object($this->tokenStorage->getToken()->getUser()))
            {
                $this->session->getFlashBag()->add('warning', 'Vous devez d\'abord vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }
}