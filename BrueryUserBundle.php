<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle;

use Bruery\UserBundle\DependencyInjection\Compiler\TemplateCompilerPass;
use Bruery\UserBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BrueryUserBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TemplateCompilerPass());
        $container->addCompilerPass(new OverrideServiceCompilerPass());
    }
}
