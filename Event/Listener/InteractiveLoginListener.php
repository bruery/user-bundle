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

use Bruery\UserBundle\Model\ConfigManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class InteractiveLoginListener
{
    protected $userManager;
    protected $configManager;
    protected $session;

    public function __construct(Session $session, UserManagerInterface $userManager, ConfigManagerInterface $configManager)
    {
        $this->session = $session;
        $this->userManager = $userManager;
        $this->configManager = $configManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if ($user instanceof UserInterface) {
            // default FOS security checks
            if ($user->getExpiresAt()) {
                $daysToExpire = $user->getExpiresAt()->diff(new \DateTime());
                if ($daysToExpire->format('%a') >=  0) {
                    $this->session->set('_bruery_user.account_expired.'.$user->getId(), 'account_expired');
                }
            }

            if ($user->getCredentialsExpireAt()) {
                $daysToExpire = $user->getCredentialsExpireAt()->diff(new \DateTime());
                if ($daysToExpire->format('%a') >=  0) {
                    $this->session->set('_bruery_user.credentials_expired.'.$user->getId(), 'credentials_expired');
                }
            }

            if ($this->configManager->isEnabled()) {
                //password expire
                if ($this->configManager->getDaysToExpire() && $this->configManager->getRedirectRoute() && $user->getPasswordChangedAt()) {
                    $daysLastChange = $user->getPasswordChangedAt()->diff(new \DateTime());
                    if ((int) $daysLastChange->format('%a') >  $this->configManager->getDaysToExpire()) {
                        $this->session->set('_bruery_user.password_expire.'.$user->getId(), 'password_expire');
                    }
                } else {
                    $user->setPasswordChangedAt(new \DateTime());
                    $this->userManager->save($user);
                }
            }
        }
    }
}
