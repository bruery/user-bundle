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
class PasswordRequirements extends Constraint
{
    public $tooShortMessage = 'bruery_user.password_strength.requirement.message.too_short';//'Your password must be at least {{length}} characters long.';
    public $missingLettersMessage = 'bruery_user.password_strength.requirement.message.missing_letters';//'Your password must include at least one letter.';
    public $requireCaseDiffMessage = 'bruery_user.password_strength.requirement.message.require_case_diff';//'Your password must include both upper and lower case letters.';
    public $missingNumbersMessage = 'bruery_user.password_strength.requirement.message.missing_numbers';//'Your password must include at least one number.';
    public $missingSpecialCharacterMessage = 'bruery_user.password_strength.requirement.message.missing_special_character';//'Your password must contain at least one special character.';

    public $minLength = 6;
    public $requireLetters = true;
    public $requireCaseDiff = false;
    public $requireNumbers = false;
    public $requireSpecialCharacter = false;

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
        return 'bruery_user.password_strength.validator.password_requirements';
    }
}
