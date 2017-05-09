<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\DependencyInjection;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BrueryUserExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('%s.xml', $config['manager_type']));

        $this->configureClass($config, $container);
        if ($config['user_age_demographics']['enabled']) {
            $loader->load('user_helper.xml');
        }

        $this->aliasManagers($container, $config['manager_type']);
        $this->configureTemplates($config, $container);

        $loader->load('password_strength.xml');
        $this->configurePasswordStrength($config, $container);

        if ($config['password_expire']['enabled']) {
            $loader->load('password_expire.xml');
            $this->configurePasswordExpire($config, $container);
            // BC Implementation
            if (interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface') &&
                interface_exists('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')) {
                $loader->load('password_expiration_listener.xml');
            } else {
                $loader->load('password_expire_listener.xml');
            }
        }

        if ($config['user_authentication_logs']['enabled']) {
            $loader->load('user_authentication_logs_orm.xml');
            //load listeners
            $loader->load('user_authentication_logs_listener.xml');
            $loader->load('user_authentication_logs_block.xml');
            $this->configureUserAuthenticationLogs($config, $container);
        }

        if ($config['user_age_demographics']['enabled']) {
            $loader->load('user_age_demographics_block.xml');
            $loader->load('user_age_demographics_orm.xml');
            $loader->load('user_age_demographics_provider.xml');
            $loader->load('user_age_demographics_listener.xml');
            $this->configureUserAgeDemographics($config, $container);
        }

        $container->setParameter('bruery.user.user_age_demographics.enabled',   $config['user_age_demographics']['enabled']);

        $loader->load('validators.xml');
        $loader->load('form_change_password.xml');
        $this->configureChangePassword($config, $container);

        $loader->load('form_profile_edit.xml');
        $this->configureProfileForm($config, $container);

        $loader->load('form_resetting.xml');
        $this->configureResetting($config, $container);

        $loader->load('form_register.xml');
        $loader->load('seo_block.xml');
        $loader->load('mailer.xml');
        $loader->load('user_gender_block.xml');

        $this->registerDoctrineMapping($config);
    }

    protected function configureClass(array $config, ContainerBuilder $container)
    {

        if ($config['user_age_demographics']['enabled']) {
            $container->setParameter('bruery.user.user_helper.class', $config['user']['class']['helper']);
        }
        $container->setParameter('bruery.user.block.profile_gender.class',  $config['user']['block']['class']['gender']);
    }

    /**
     * Adds aliases for user & group managers depending on $managerType.
     *
     * @param ContainerBuilder $container
     * @param                  $managerType
     */
    protected function aliasManagers(ContainerBuilder $container, $managerType)
    {
        $container->setAlias('bruery.user.user_manager', sprintf('bruery.user.%s.user_manager', $managerType));
        $container->setAlias('bruery.user.group_manager', sprintf('bruery.user.%s.group_manager', $managerType));
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureTemplates(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery_user.templates', $config['templates']);
    }

    public function configurePasswordExpire(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery.user.password_expire.force_update_password_listener.class', $config['password_expire']['listener']['force_password_change']['class']);
        $container->setParameter('bruery.user.password_expire.login_listener.class', $config['password_expire']['listener']['login']['class']);

        if (!empty($config['password_expire'])) {
            $definition = $container->getDefinition('bruery_user.password_expire.config.manager');
            if ($config['password_expire']['enabled'] && array_key_exists('settings', $config['password_expire'])) {
                $definition->addMethodCall('setEnabled', array(true));
                $definition->addMethodCall('setConfig', array('password_expire', $config['password_expire']['settings']));
            } else {
                $definition->addMethodCall('setEnabled', array(false));
            }
        }
    }

    public function configurePasswordStrength(array $config, ContainerBuilder $container)
    {
        if (!empty($config['password_security'])) {
            $definition = $container->getDefinition('bruery_user.password_strength.config.manager');

            if (array_key_exists('requirement', $config['password_security'])) {
                $definition->addMethodCall('setConfig', array('requirement', $config['password_security']['requirement']));
            }

            if (array_key_exists('strength', $config['password_security'])) {
                $definition->addMethodCall('setConfig', array('strength', $config['password_security']['strength']));
            }
        }
    }

    public function configureUserAgeDemographics(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery.user.manager.user_age_demographics.class',           $config['user_age_demographics']['class']['orm']);
        $container->setParameter('bruery.user.manager.user_age_demographics.entity',          $config['user_age_demographics']['class']['entity']);
        $container->setParameter('bruery.user.provider.collection.age_demographics.class',    $config['user_age_demographics']['provider']['class']);

        $container->setParameter('bruery.user.age_demographics.context',                      $config['user_age_demographics']['listener']['context']);
        $container->setParameter('bruery.user.user_age_demographics.doctrine_listener.class', $config['user_age_demographics']['listener']['class']);

        $container->setParameter('bruery.user.block.profile_age_demographics.class',          $config['user_age_demographics']['block']['class']);
        $container->setParameter('bruery.user.block.profile_age_demographics.context',        $config['user_age_demographics']['block']['context']);
    }

    public function configureUserAuthenticationLogs(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery.user.manager.user_authentication_logs.class',              $config['user_authentication_logs']['class']['orm']);
        $container->setParameter('bruery.user.manager.user_authentication_logs.entity',             $config['user_authentication_logs']['class']['entity']);

        $container->setParameter('bruery.user.event_listener.authentication.class',                 $config['user_authentication_logs']['class']['authentication_listener']);
        $container->setParameter('bruery.user.component.authentication.handler.user_logout.class',  $config['user_authentication_logs']['class']['logout_handler']);
        $container->setParameter('bruery.user.user_authentication_logs.enabled',                    $config['user_authentication_logs']['enabled']);

        $container->setParameter('bruery.user.block.user_authentication_logs.class',                $config['user_authentication_logs']['block']['class']['logs']);
        $container->setParameter('bruery.user.block.user_authentication_logs_stats.class',          $config['user_authentication_logs']['block']['class']['logs_stat']);
    }

    public function configureChangePassword(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery.user.change_password.form.type', $config['change_password']['form']['type']);
        $container->setParameter('bruery.user.change_password.form.name', $config['change_password']['form']['name']);
        $container->setParameter('bruery.user.change_password.form.validation_groups', $config['change_password']['form']['validation_groups']);
        $container->setAlias('bruery.user.change_password.form.handler', $config['change_password']['form']['handler']);
    }

    public function configureResetting(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery.user.resetting.form.type', $config['resetting']['form']['type']);
        $container->setParameter('bruery.user.resetting.form.name', $config['resetting']['form']['name']);
        $container->setParameter('bruery.user.resetting.form.validation_groups', $config['resetting']['form']['validation_groups']);
        $container->setAlias('bruery.user.resetting.form.handler', $config['resetting']['form']['handler']);
    }

    public function configureProfileForm(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bruery.user.profile.form.type', $config['profile']['form']['type']);
        $container->setParameter('bruery.user.profile.form.name', $config['profile']['form']['name']);
        $container->setParameter('bruery.user.profile.form.validation_groups', $config['profile']['form']['validation_groups']);
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        if ($config['user_age_demographics']['enabled'] && class_exists($config['user_age_demographics']['class']['entity'])) {
            $collector->addAssociation($config['user_age_demographics']['class']['entity'], 'mapOneToOne', array(
                'fieldName'    => 'user',
                'targetEntity' => $config['user']['class']['entity'],
                'cascade' =>
                    array(
                        1 => 'detach'
                    ),
                'joinColumns' =>
                    array(
                        array(
                            'name' => 'user_id',
                            'referencedColumnName' => 'id',
                            'onDelete' => 'CASCADE',
                        ),
                    ),
                'mappedBy'      => null,
                'inversedBy'    => null,
                'orphanRemoval' => true
            ));
        }

        if ($config['user_age_demographics']['enabled'] && class_exists($config['user_age_demographics']['class']['entity'])) {
            $collector->addAssociation($config['user_age_demographics']['class']['entity'], 'mapManyToOne', array(
                'fieldName' => 'collection',
                'targetEntity' => $config['user_age_demographics']['class']['reference_entity'],
                'cascade' =>
                    array(
                        1 => 'detach',
                    ),
                'mappedBy' => null,
                'inversedBy' => null,
                'joinColumns' =>
                    array(
                        array(
                            'name' => 'collection_id',
                            'referencedColumnName' => 'id',
                        ),
                    ),
                'orphanRemoval' => false,
            ));
        }


        if (class_exists($config['user_authentication_logs']['class']['entity']) && $config['user_authentication_logs']['enabled']) {
            $collector->addAssociation($config['user_authentication_logs']['class']['entity'], 'mapManyToOne', array(
                'fieldName' => 'user',
                'targetEntity' => $config['user']['class']['entity'],
                'cascade' =>
                    array(
                        1 => 'detach',
                    ),
                'mappedBy' => null,
                'inversedBy' => null,
                'joinColumns' =>
                    array(
                        array(
                            'name' => 'user_id',
                            'referencedColumnName' => 'id',
                            'onDelete' => 'CASCADE',
                        ),
                    ),
                'orphanRemoval' => false,
            ));
        }
    }
}
