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

use Bruery\UserBundle\Entity\UserAuthenticationLogsManager;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationListener
{
    protected $userAuthenticationLogsManager;
    protected $logsEnabled;

    public function __construct(UserAuthenticationLogsManager $userAuthenticationLogsManager, $enabled = false)
    {
        $this->logsEnabled = $enabled;
        $this->userAuthenticationLogsManager = $userAuthenticationLogsManager;
    }

    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        if ($this->logsEnabled) {
            $user = $event->getAuthenticationToken()->getUser();
            if ($user && $user instanceof UserInterface) {
                $log = $this->userAuthenticationLogsManager->create();
                $log->setUser($user);
                $log->setType('login');
                $this->userAuthenticationLogsManager->save($log);
            }
        }
    }
}
