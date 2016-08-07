<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Exception;

class PasswordStrengthConfigManagerException extends \Exception
{
    /**
     * Gets the "CONFIG DOES NOT EXIST" exception.
     *
     * @param string $name The invalid CKEditor config name.
     *
     * @return \Bruery\UserBundle\Exception\PasswordStrengthConfigManagerException The "CONFIG DOES NOT EXIST" exception.
     */
    public static function configDoesNotExist($name)
    {
        return new static(sprintf('The BrueryUserBundle config "%s" does not exist.', $name));
    }

    /**
     * Gets the "CONFIG DOES NOT EXIST" exception.
     *
     * @param string $name The invalid CKEditor config name.
     *
     * @return \Bruery\UserBundle\Exception\PasswordStrengthConfigManagerException The "CONFIG DOES NOT EXIST" exception.
     */
    public static function indexDoesNotExist($name)
    {
        return new static(sprintf('The BrueryUserBundle index "%s" does not exist.', $name));
    }

    /**
     * Gets the "CONFIG DOES NOT EXIST" exception.
     *
     * @param string $name The invalid CKEditor config name.
     *
     * @return \Bruery\UserBundle\Exception\PasswordStrengthConfigManagerException The "CONFIG DOES NOT EXIST" exception.
     */
    public static function optionDoesNotExist($name)
    {
        return new static(sprintf('The BrueryUserBundle options "%s" does not exist.', $name));
    }
}
