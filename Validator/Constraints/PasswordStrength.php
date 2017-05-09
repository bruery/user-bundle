<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordStrength extends Constraint
{
    public $message = 'bruery_user.password_strength.strength.message.password_too_weak';//'password_too_weak';
    public $minLength = 6;
    public $minStrength = 1;
    public $requireLetters = true;
    public $requireCaseDiff = false;
    public $requireNumbers = false;
    public $requireSpecialCharacter = false;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'minStrength';
    }

    public function getRequiredOptions()
    {
        return array('minStrength');
    }

    /**
     * Returns the name of the class that validates this constraint
     *
     * By default, this is the fully qualified name of the constraint class
     * suffixed with "Validator". You can override this method to change that
     * behaviour.
     *
     * @return string
     *
     * @api
     */
    public function validatedBy()
    {
        return 'bruery_user.password_strength.validator.password_strength';
    }
}
