<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Model;

use Bruery\SearchBundle\Exception\ConfigManagerException;

class PasswordStrengthConfigManager extends AbstractConfigManager
{
    /**
     * {@inheritdoc}
     */
    public function getRequirementMinLength()
    {
        return isset($this->configs['requirement']['min_length']) ? $this->configs['requirement']['min_length'] : 8;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequirementRequireLetters()
    {
        return isset($this->configs['requirement']['require_letters']) ? $this->configs['requirement']['require_letters'] : true;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequirementRequireCaseDiff()
    {
        return isset($this->configs['requirement']['require_case_diff']) ? $this->configs['requirement']['require_case_diff'] : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequirementRequireNumbers()
    {
        return isset($this->configs['requirement']['require_numbers']) ? $this->configs['requirement']['require_numbers'] : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequirementRequireSpecialCharacter()
    {
        return isset($this->configs['requirement']['require_special_character']) ? $this->configs['requirement']['require_special_character'] : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getStrengthMinLength()
    {
        return isset($this->configs['strength']['min_length']) ? $this->configs['strength']['min_length'] : 8;
    }

    /**
     * {@inheritdoc}
     */
    public function getStrengthMinStrength()
    {
        return isset($this->configs['strength']['min_strength']) ? $this->configs['strength']['min_strength'] : false;
    }
}
