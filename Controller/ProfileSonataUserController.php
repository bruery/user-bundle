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

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Sonata\UserBundle\Controller\ProfileFOSUser1Controller;
use Symfony\Component\HttpFoundation\Response;

class ProfileSonataUserController extends ProfileFOSUser1Controller
{
    /**
     * Renders a view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $template = $this->get('bruery_core.template_loader')->getTemplates();
        switch ($view) {
            case 'SonataUserBundle:Profile:show.html.twig':
                return parent::render($template['bruery_user.template.profile.show'], $parameters, $response);
                break;

            case 'SonataUserBundle:Profile:edit_authentication.html.twig':
                return parent::render($template['bruery_user.template.profile.edit_authentication'], $parameters, $response);
                break;

            case 'SonataUserBundle:Profile:edit_profile.html.twig':
                return parent::render($template['bruery_user.template.profile.edit'], $parameters, $response);
                break;

            default:
                return parent::render($view, $parameters, $response);
                break;
        }
    }
}
