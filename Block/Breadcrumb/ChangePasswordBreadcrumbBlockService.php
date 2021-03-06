<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Block\Breadcrumb;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ChangePasswordBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
{
    protected $menuData;
    protected $translator;
    protected $translationDomain;

    /**
     * @param string $context
     * @param string $name
     * @param EngineInterface $templating
     * @param MenuProviderInterface $menuProvider
     * @param FactoryInterface $factory
     * @param TranslatorInterface $translator
     * @param string $translationDomain
     */
    public function __construct($context,
                                $name,
                                EngineInterface $templating,
                                MenuProviderInterface $menuProvider,
                                FactoryInterface $factory,
                                TranslatorInterface $translator,
                                $translationDomain = 'SonataUserBundle')
    {
        parent::__construct($context, $name, $templating, $menuProvider, $factory);
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
        $this->menuData = array();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Breadcrumb: Change Password';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = $this->getRootMenu($blockContext);
        $menu->addChild($this->translator->trans('sonata_user_profile_breadcrumb_index', array(), $this->translationDomain), array('route' => 'sonata_user_profile_show'));
        $menu->addChild($this->translator->trans('breadcrumb.profile.link_change_password', array(), $this->translationDomain), array('route' => 'sonata_user_change_password'));
        return $menu;
    }
}
