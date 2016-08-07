<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Block;

use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\MenuBlockService;
use Sonata\UserBundle\Menu\ProfileMenuBuilder;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProfileMenuBlockService
 *
 * @package Sonata\UserBundle\Block
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class ProfileMenuBlockService extends MenuBlockService
{
    /**
     * @var ProfileMenuBuilder
     */
    private $menuBuilder;

    /**
     * Constructor
     *
     * @param string                $name
     * @param EngineInterface       $templating
     * @param MenuProviderInterface $menuProvider
     * @param ProfileMenuBuilder    $menuBuilder
     */
    public function __construct($name, EngineInterface $templating, MenuProviderInterface $menuProvider, ProfileMenuBuilder $menuBuilder)
    {
        parent::__construct($name, $templating, $menuProvider, array());

        $this->menuBuilder = $menuBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User Profile Menu';
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        parent::configureSettings($resolver);
        $resolver->setDefaults(array(
                                   'cache_policy' => 'private',
                                   'menu_template' => "BrueryUserBundle:Profile:block_side_menu_template.html.twig",
                               ));
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getMenu($blockContext);

        $settings = $blockContext->getSettings();

        if (null === $menu || "" === $menu) {
            $menu = $this->menuBuilder->createProfileMenu(
                                      array(
                                          'childrenAttributes' => array('class' => $settings['menu_class']),
                                          'attributes'         => array('class' => $settings['children_class']),
                                      )
            );

            // Prevents BC break with KnpMenuBundle v1.x
            if (method_exists($menu, "setCurrentUri")) {
                $menu->setCurrentUri($settings['current_uri']);
            }
        }

        return $menu;
    }
}
