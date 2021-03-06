<?php

/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bruery\UserBundle\Event\Listener\PasswordUpdateListener;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface') &&
            interface_exists('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')) {
            $definition = $container->getDefinition('bruery.user.password_expire.force_update_password_listener');
            $definition->setClass(PasswordUpdateListener::class);
        }

        // override User Admin - TO BE REMOVED
//        $definition = $container->getDefinition('sonata.user.admin.user');
//        $definedTemplates = array_merge($container->getParameter('sonata.admin.configuration.templates'),
//                                        $container->getParameter('bruery_user.configuration.user.templates'));
//        $definition->addMethodCall('setTemplates', array($definedTemplates));
//
//        $definition = $container->getDefinition('sonata.user.admin.group');
//        $definedTemplates = array_merge($container->getParameter('sonata.admin.configuration.templates'),
//                                        $container->getParameter('bruery_user.configuration.group.templates'));
//        $definition->addMethodCall('setTemplates', array($definedTemplates));
//
//
//        $definition = $container->getDefinition('sonata.user.block.menu');
//        $definition->setClass($container->getParameter('bruery.user.user.block.menu.class'));
//
//
//        $definition = $container->getDefinition('sonata.user.orm.user_manager');
//        $definition->setClass($container->getParameter('bruery.user.manager.user.class'));
//
//        $definition = $container->getDefinition('sonata.user.orm.group_manager');
//        $definition->setClass($container->getParameter('bruery.user.manager.group.class'));
    }
}
