<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Controller;

use Sonata\UserBundle\Controller\SecurityFOSUser1Controller;

class SecuritySonataUserController extends SecurityFOSUser1Controller
{
    protected function renderLogin(array $data)
    {
        $template = $this->container->get('bruery_core.template_loader')->getTemplates();
        return $this->container->get('templating')->renderResponse($template['bruery_user.template.login.frontend'], $data);
    }
}
