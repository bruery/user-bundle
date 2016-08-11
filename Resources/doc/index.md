UserBundle
==========

Symfony2 Bundle - An extension of [SonataUserBundle](https://github.com/sonata-project/SonataUserBundle "SonataUserBundle")

Uses a forked version of SonataUserBundle

For installation and configuration you can follow [SonataUserBundle](http://sonata-project.org/bundles/user "SonataUserBundle")

The bundle is used to extend SonataUserBundle and requires BrueryBundles.

Change Logs
-----------

-1.0.1 - 2014-09-29 -- Refactored User bundle to be more compatible with SonataUserBundle and FOSUserBundle, code clean-up.

-1.0.0 - 2014-09-16 -- Initial stable branch

Installation
------------

Follow SonataUserBundle Installation but instrad of using SonataUserBundle routes us BrueryUserBundle Routes Instead:

Replace:

.. code-block:: yaml

    sonata_user_security:
        resource: "@SonataUserBundle/Resources/config/routing/sonata_security_1.xml"

    sonata_user_resetting:
        resource: "@SonataUserBundle/Resources/config/routing/sonata_resetting_1.xml"
        prefix: /resetting

    sonata_user_profile:
        resource: "@SonataUserBundle/Resources/config/routing/sonata_profile_1.xml"
        prefix: /profile

    sonata_user_register:
        resource: "@SonataUserBundle/Resources/config/routing/sonata_registration_1.xml"
        prefix: /register

    sonata_user_change_password:
        resource: "@SonataUserBundle/Resources/config/routing/sonata_change_password_1.xml"
        prefix: /profile

With:

.. code-block:: yaml

    bruery_user_security:
        resource: "@BrueryUserBundle/Resources/config/routing/security.xml"

    bruery_user_resetting:
        resource: "@BrueryUserBundle/Resources/config/routing/resetting.xml"
        prefix: /resetting

    bruery_user_profile:
        resource: "@BrueryUserBundle/Resources/config/routing/profile.xml"
        prefix: /profile

    bruery_user_register:
        resource: "@BrueryUserBundle/Resources/config/routing/registration.xml"
        prefix: /register

    bruery_user_change_password:
        resource: "@BrueryUserBundle/Resources/config/routing/change_password.xml"
        prefix: /profile
        
Advanced Configuration
======================

Full configuration options:

.. code-block:: yaml

        templates:
          login: BrueryUserBundle:Security:login.html.twig
          
        admin:
          user:
            templates:
                edit: 'BrueryUserBundle:Admin:CRUD/edit.html.twig'
                
        registration:
          form:
              type:               bruery_user_registration
              name:               bruery_user_registration_form
              handler:            bruery.user.registration.form.handler.default
              validation_groups:  [Registration, Default]
    
        profile:
            form:
                type:               bruery_user_profile
                name:               bruery_user_profile_form
                handler:            bruery.user.profile.form.handler.default
                validation_groups:  [Profile, Default]
    
            update_password:
                form:
                    type:               bruery_user_profile_update_password
                    name:               bruery_user_profile_update_password_form
                    handler:            bruery.user.profile.update_password.form.handler.default
                    validation_groups:  [UpdatePassword, Default]
    
        change_password:
            form:
                type:               bruery_user_change_password
                name:               bruery_user_change_password_form
                handler:            bruery.user.change_password.form.handler.default
                validation_groups:  [ChangePassword, Default]
    
        resetting:
            form:
                type:               bruery_user_resetting
                name:               bruery_user_resetting_form
                handler:            bruery.user.resetting.form.handler.default
                validation_groups:  [Resetting]
    
        password_security:
          requirement:
            min_length: 8
            require_letters: true
            require_case_diff: false
            require_numbers: false
            require_special_character: false
          strength:
            min_length: 8
            min_strength: 3


Installing Specific Version
---------------------------

To install 1.0.0 use **"bruery/user-bundle": 1.0.0** 

To install 1.0.1 or greater use **"bruery/user-bundle": ~1.0** 


**STABLE VERSION**
==================
