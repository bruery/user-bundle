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

use FOS\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Controller\ChangePasswordFOSUser1Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ChangePasswordSonataUserController extends ChangePasswordFOSUser1Controller
{
    /**
     * @return Response|RedirectResponse
     *
     * @throws AccessDeniedException
     */
    public function changePasswordAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $this->createAccessDeniedException('This user does not have access to this section.');
        }

        $this->get('session')->remove('_bruery_user.password_expire.' . $user->getId());

        $form = $this->container->get('bruery.user.change_password.form');
        $formHandler = $this->container->get('bruery.user.change_password.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
            $this->setFlash('fos_user_success', 'change_password.flash.success');
            return $this->redirect($this->getRedirectionUrl($user));
        }

        $template = $this->get('bruery_core.template_loader')->getTemplates();

        return $this->render($template['bruery_user.template.change_password.form'], array('form' => $form->createView()));
    }
}
