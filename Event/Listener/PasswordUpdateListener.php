<?php
/**
 * This file is part of the Mosaic Platform.
 *
 * (c) Rommel M. Zamora <rommel.zamora@groupm.com>
 * (c) Andrew Aculana <andrew.aculana@movent.com>
 *
 * Copyright (c)  2017. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Event\Listener;

use Bruery\UserBundle\Model\ConfigManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PasswordUpdateListener
{

    protected $configManager;
    protected $session;
    protected $router;
    protected  $tokenStorage;
    protected  $authorizationChecker;

    public function __construct(ChainRouter $router,TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker, Session $session, ConfigManagerInterface $configManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->configManager = $configManager;
        $this->session = $session;
        $this->router = $router;
    }

    public function onCheckPasswordExpired(GetResponseEvent $event)
    {

        if ($this->tokenStorage->getToken() && $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->tokenStorage->getToken()->getUser();

            if ($user instanceof UserInterface && $this->session->get('_bruery_user.password_expire.'.$user->getId()) === 'password_expire'   && $event->getRequest()->get('_route') != null && $event->getRequest()->get('_route') !== 'fos_user_change_password') {
                $event->setResponse($this->getRedirectResponse());
            }
        }
    }

    protected function getRedirectResponse()
    {
        $route = $this->configManager->getRedirectRoute();
        $response = new RedirectResponse($this->router->generate($route));
        $this->session->getFlashBag()->set('bruery_user_error', 'password_expire.flash.error');
        return $response;
    }
}
