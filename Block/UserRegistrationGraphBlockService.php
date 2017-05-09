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

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationGraphBlockService extends BaseBlockService
{
    protected $manager;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param ContainerInterface $container
     */
    public function __construct($name, EngineInterface $templating, ContainerInterface $container)
    {
        $this->container      = $container;
        parent::__construct($name, $templating);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User Registration';
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'title'    => 'User Registration',
            'template' => 'BrueryUserBundle:Block:block_profile_user_registration_graph.html.twig',
            'registrationCount' => null,
            'fetchCountRecord' => 5,
            'mode'       => 'admin',
            'disabled' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('title', 'text', array('required' => false)),
                array('mode', 'choice', array(
                    'choices' => array(
                        'public' => 'public',
                        'admin'  => 'admin'
                    )
                )),
            ),
            'attr'=>array('class'=>'bruery-immutable-container')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getBlock()->getSettings();

        return $this->renderResponse($blockContext->getTemplate(),
            array(
                'context'   => $blockContext,
                'block'     => $blockContext->getBlock(),
                'settings'  => $settings
            ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function load(BlockInterface $block)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $settings = $block->getSettings();
        $userRegistrations = $userManager->fetchRegistrationCount(isset($settings['fetchCountRecord']) ? $settings['fetchCountRecord'] : 5);
        $block->setSetting('userRegistrations', $userRegistrations);
    }
}
