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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('bruery_user');
        $supportedManagerTypes = array('orm', 'mongodb');
        $this->addTemplates($node);
        $this->addORMSettings($node, $supportedManagerTypes);
        $this->addClasses($node);
        $this->addPasswordStrength($node);
        $this->addPasswordExpireSection($node);
        $this->addChangePasswordSection($node);
        $this->addProfileFormSection($node);
        $this->addResettingSection($node);
        return $treeBuilder;
    }

    private function addORMSettings(ArrayNodeDefinition $node, $supportedManagerTypes = array('orm', 'mongodb'))
    {
        $node
            ->children()
                ->scalarNode('manager_type')
                    ->defaultValue('orm')
                    ->validate()
                        ->ifNotInArray($supportedManagerTypes)
                        ->thenInvalid('The manager type %s is not supported. Please choose one of '.json_encode($supportedManagerTypes))
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addPasswordStrength(ArrayNodeDefinition $node)
    {
        //TODO: add other templates for configuration
        $node
            ->children()
                ->arrayNode('password_security')
                        ->addDefaultsIfNotSet()
                        ->canBeUnset()
                        ->children()
                            ->arrayNode('requirement')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('min_length')->defaultValue(8)->end()
                                    ->scalarNode('require_letters')->defaultValue(true)->end()
                                    ->scalarNode('require_case_diff')->defaultValue(false)->end()
                                    ->scalarNode('require_numbers')->defaultValue(false)->end()
                                    ->scalarNode('require_special_character')->defaultValue(false)->end()
                                ->end()
                            ->end()
                            ->arrayNode('strength')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('min_length')->defaultValue(8)->end()
                                    ->scalarNode('min_strength')->defaultValue(1)->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addPasswordExpireSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('password_expire')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('enabled')->defaultValue(true)->end()
                        ->arrayNode('listener')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('login')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('class')->defaultValue('Bruery\\UserBundle\\Event\\Listener\\InteractiveLoginListener')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('force_password_change')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('class')->defaultValue('Bruery\\UserBundle\\Event\\Listener\\ForcePasswordUpdateListener')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('settings')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('days_to_expire')->defaultValue(90)->end()
                                ->scalarNode('redirect_route')->defaultValue('fos_user_change_password')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addClasses(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('user')
                    ->children()
                        ->arrayNode('class')
                            ->children()
                                ->scalarNode('entity')->cannotBeEmpty()->end()
                                ->scalarNode('helper')->defaultValue('Bruery\\UserBundle\\Component\\Helper\\UserHelper')->end()
                            ->end()
                        ->end()
                        ->arrayNode('block')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('class')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('gender')->defaultValue('Bruery\\UserBundle\\Block\\ProfileGenderBlockService')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                 ->end()
                 ->arrayNode('group')
                    ->children()
                        ->arrayNode('class')
                            ->children()
                                ->scalarNode('entity')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('user_age_demographics')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('enabled')->defaultValue(false)->end()
                        ->arrayNode('block')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->defaultValue('Bruery\\UserBundle\\Block\\ProfileAgeDemogrphicsBlockService')->end()
                                ->scalarNode('context')->defaultValue('user-age-demographics')->end()
                            ->end()
                        ->end()
                        ->arrayNode('class')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->cannotBeEmpty()->end()
                                ->scalarNode('reference_entity')->cannotBeEmpty()->end()
                                ->scalarNode('orm')->defaultValue('Bruery\\UserBundle\\Entity\\UserAgeDemographicsManager')->end()
                            ->end()
                        ->end()
                        ->arrayNode('provider')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->defaultValue('Bruery\\UserBundle\\Provider\\AgeDemographicsCollectionProvider')->end()
                            ->end()
                        ->end()
                        ->arrayNode('listener')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('context')->defaultValue('user-age-demographics')->end()
                                ->scalarNode('class')->defaultValue('Bruery\\UserBundle\\Event\\Listener\\UserAgeDemographicsListener')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('user_authentication_logs')
                        ->children()
                            ->scalarNode('enabled')->defaultValue(true)->end()
                            ->arrayNode('block')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->arrayNode('class')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->scalarNode('logs')->defaultValue('Bruery\\UserBundle\\Block\\UserAuthenticationLogsBlockService')->end()
                                            ->scalarNode('logs_stat')->defaultValue('Bruery\\UserBundle\\Block\\UserAuthenticationLogsStatsBlockService')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('class')
                                ->children()
                                    ->scalarNode('entity')->cannotBeEmpty()->end()
                                    ->scalarNode('orm')->defaultValue('Bruery\\UserBundle\\Entity\\UserAuthenticationLogsManager')->end()
                                    ->scalarNode('authentication_listener')->defaultValue('Bruery\\UserBundle\\Event\\Listener\\AuthenticationListener')->end()
                                    ->scalarNode('logout_handler')->defaultValue('Bruery\\UserBundle\\Component\\Authentication\\UserLogoutHandler')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

     /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     *
     * @return void
     */
    private function addTemplates(ArrayNodeDefinition $node)
    {
        //TODO: add other templates for configuration
        $node
            ->children()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('layout')->defaultValue('BrueryUserBundle::layout.html.twig')->end()
                        ->arrayNode('login')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('frontend')->defaultValue('BrueryUserBundle:Security:login.html.twig')->end()
                                ->scalarNode('backend')->defaultValue('BrueryUserBundle:Admin:Security/login.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('resetting')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')->defaultValue('BrueryUserBundle:Resetting:reset.html.twig')->end()
                                ->scalarNode('form_content')->defaultValue('BrueryUserBundle:Resetting:reset_content.html.twig')->end()
                                ->scalarNode('request')->defaultValue('BrueryUserBundle:Resetting:request.html.twig')->end()
                                ->scalarNode('request_content')->defaultValue('BrueryUserBundle:Resetting:request_content.html.twig')->end()
                                ->scalarNode('password_already_requested')->defaultValue('BrueryUserBundle:Resetting:password_already_requested.html.twig')->end()
                                ->scalarNode('check_email')->defaultValue('BrueryUserBundle:Resetting:check_email.html.twig')->end()
                                ->scalarNode('email')->defaultValue('BrueryUserBundle:Resetting:email.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('profile')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('show')->defaultValue('BrueryUserBundle:Profile:show.html.twig')->end()
                                ->scalarNode('action')->defaultValue('BrueryUserBundle:Profile:action.html.twig')->end()
                                ->scalarNode('edit')->defaultValue('BrueryUserBundle:Profile:edit_profile.html.twig')->end()
                                ->scalarNode('edit_content')->defaultValue('BrueryUserBundle:Profile:edit_profile_content.html.twig')->end()
                                ->scalarNode('edit_authentication')->defaultValue('BrueryUserBundle:Profile:edit_authentication.html.twig')->end()
                                ->scalarNode('edit_authentication_content')->defaultValue('BrueryUserBundle:Profile:edit_authentication_content.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('registration')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')->defaultValue('BrueryUserBundle:Registration:register.html.twig')->end()
                                ->scalarNode('form_content')->defaultValue('BrueryUserBundle:Registration:register_content.html.twig')->end()
                                ->scalarNode('check_email')->defaultValue('BrueryUserBundle:Registration:check_email.html.twig')->end()
                                ->scalarNode('confirmed')->defaultValue('BrueryUserBundle:Registration:confirmed.html.twig')->end()
                                ->scalarNode('email')->defaultValue('BrueryUserBundle:Registration:email.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('change_password')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')->defaultValue('BrueryUserBundle:ChangePassword:change_password.html.twig')->end()
                                ->scalarNode('form_content')->defaultValue('BrueryUserBundle:ChangePassword:change_password_content.html.twig')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addChangePasswordSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('change_password')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('bruery_user_change_password')->end()
                                ->scalarNode('handler')->defaultValue('bruery.user.change_password.form.handler.default')->end()
                                ->scalarNode('name')->defaultValue('bruery_user_change_password_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('ChangePassword', 'Default'))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }


    private function addResettingSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('resetting')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('bruery_user_resetting')->end()
                                ->scalarNode('handler')->defaultValue('bruery.user.resetting.form.handler.default')->end()
                                ->scalarNode('name')->defaultValue('bruery_user_resetting_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Resetting', 'Default'))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }


    private function addProfileFormSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('profile')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('bruery_user_profile')->end()
                                ->scalarNode('handler')->defaultValue('bruery.user.profile.form.handler.default')->end()
                                ->scalarNode('name')->defaultValue('bruery_user_profile_form')->cannotBeEmpty()->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Profile', 'Default'))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
