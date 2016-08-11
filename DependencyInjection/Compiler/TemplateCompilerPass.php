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

class TemplateCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('bruery_core.template_loader');
        $templates = $container->getParameter('bruery_user.templates');
        $bunldeTemplates = [];
        foreach ($templates as $key => $templates) {
            if (is_array($templates)) {
                foreach ($templates as $id=>$template) {
                    $bunldeTemplates[sprintf('bruery_user.template.%s.%s', $key, $id)] = $template;
                }
            } else {
                $bunldeTemplates[sprintf('bruery_user.template.%s', $key)] = $templates;
            }
        }
        $definition->addMethodCall('setTemplates', array($bunldeTemplates));
    }
}
