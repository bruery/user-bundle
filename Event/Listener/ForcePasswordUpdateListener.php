<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Event\Listener;

@trigger_error('The '.__NAMESPACE__.'\ForcePasswordUpdateListener class is deprecated since version 1.0 and will be removed in 2.0. Use Bruery\UserBundle\Event\Listener\PasswordUpdateListener instead.', E_USER_DEPRECATED);

use Bruery\UserBundle\Model\ConfigManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\SecurityContext;

class ForcePasswordUpdateListener
{
    protected $securityContext;
    protected $configManager;
    protected $session;
    protected $router;

    public function __construct(ChainRouter $router, SecurityContext $securityContext, Session $session, ConfigManagerInterface $configManager)
    {
        $this->securityContext = $securityContext;
        $this->configManager = $configManager;
        $this->session = $session;
        $this->router = $router;
    }

    public function onCheckPasswordExpired(GetResponseEvent $event)
    {
        if (($this->securityContext->getToken()) && ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY'))) {
            $user = $this->securityContext->getToken()->getUser();

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
