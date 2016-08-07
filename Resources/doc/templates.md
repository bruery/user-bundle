Templates
=========

* ``layout`` : BrueryUserBundle::layout.html.twig
* ``login`` : BrueryUserBundle:Security:login.html.twig
* ``admin_login`` : BrueryUserBundle:Admin:Security/login.html.twig
* ``resetting`` : BrueryUserBundle:Resetting:reset.html.twig
* ``resetting_content`` : BrueryUserBundle:Resetting:reset_content.html.twig
* ``resetting_request`` : BrueryUserBundle:Resetting:request.html.twig
* ``resetting_request_content`` : BrueryUserBundle:Resetting:request_content.html.twig
* ``resetting_password_already_requested`` : BrueryUserBundle:Resetting:passwordAlreadyRequested.html.twig
* ``resetting_check_email`` : BrueryUserBundle:Resetting:checkEmail.html.twig
* ``resetting_email`` : BrueryUserBundle:Resetting:email.html.twig
* ``profile`` : BrueryUserBundle:Profile:show.html.twig
* ``profile_action`` : BrueryUserBundle:Profile:action.html.twig
* ``profile_edit`` : BrueryUserBundle:Profile:edit_profile.html.twig
* ``profile_edit_authentication`` : BrueryUserBundle:Profile:edit_authentication.html.twig
* ``registration`` : BrueryUserBundle:Registration:register.html.twig
* ``registration_content`` : BrueryUserBundle:Registration:register_content.html.twig
* ``registration_check_email`` : BrueryUserBundle:Registration:checkEmail.html.twig
* ``registration_confirmed`` : BrueryUserBundle:Registration:confirmed.html.twig
* ``registration_email`` : BrueryUserBundle:Registration:email.html.twig
* ``change_password`` : BrueryUserBundle:ChangePassword:changePassword.html.twig
* ``change_password_content`` : BrueryUserBundle:ChangePassword:changePassword_content.html.twig


Configuring templates
---------------------

Like said before, the main goal of this template structure is to make it easy for you
to customize the ones you need. You can simply extend the ones you want in your own bundle,
and tell ``BrueryUserBundle`` to use your templates instead of the default ones. You can do so
in several ways.

You can specify your templates in the config.yml file, like so:

.. configuration-block::

    .. code-block:: yaml

        bruery_user:
            templates:
                layout                                  : BrueryUserBundle::layout.html.twig
                login                                   : BrueryUserBundle:Security:login.html.twig
                admin_login                             : BrueryUserBundle:Admin:Security/login.html.twig
                resetting                               : BrueryUserBundle:Resetting:reset.html.twig
                resetting_content                       : BrueryUserBundle:Resetting:reset_content.html.twig
                resetting_request                       : BrueryUserBundle:Resetting:request.html.twig
                resetting_request_content               : BrueryUserBundle:Resetting:request_content.html.twig
                resetting_password_already_requested    : BrueryUserBundle:Resetting:passwordAlreadyRequested.html.twig
                resetting_check_email                   : BrueryUserBundle:Resetting:checkEmail.html.twig
                resetting_email                         : BrueryUserBundle:Resetting:email.html.twig
                profile                                 : BrueryUserBundle:Profile:show.html.twig
                profile_action                          : BrueryUserBundle:Profile:action.html.twig
                profile_edit                            : BrueryUserBundle:Profile:edit_profile.html.twig
                profile_edit_authentication             : BrueryUserBundle:Profile:edit_authentication.html.twig
                registration                            : BrueryUserBundle:Registration:register.html.twig
                registration_content                    : BrueryUserBundle:Registration:register_content.html.twig
                registration_check_email                : BrueryUserBundle:Registration:checkEmail.html.twig
                registration_confirmed                  : BrueryUserBundle:Registration:confirmed.html.twig
                registration_email                      : BrueryUserBundle:Registration:email.html.twig
                change_password                         : BrueryUserBundle:ChangePassword:changePassword.html.twig
                change_password_content                 : BrueryUserBundle:ChangePassword:changePassword_content.html.twig