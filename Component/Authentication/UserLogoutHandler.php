<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Component\Authentication;

use Bruery\UserBundle\Entity\UserAuthenticationLogsManager;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class UserLogoutHandler implements LogoutHandlerInterface
{
    protected $userLogsEnabled;
    protected $userAuthenticationLogsManager;

    public function __construct(UserAuthenticationLogsManager $userAuthenticationLogsManager, $enabled = false)
    {
        $this->userLogsEnabled = $enabled;
        $this->userAuthenticationLogsManager = $userAuthenticationLogsManager;
    }
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        if ($this->userLogsEnabled) {
            $user = $token->getUser();
            if ($user && $user instanceof UserInterface) {
                $log = $this->userAuthenticationLogsManager->create();
                $log->setUser($user);
                $log->setType('logout');
                $this->userAuthenticationLogsManager->save($log);
            }
        }
    }
}
