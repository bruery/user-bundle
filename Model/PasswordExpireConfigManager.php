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

class PasswordExpireConfigManager extends AbstractConfigManager
{
    /**
     * {@inheritdoc}
     */
    public function getDaysToExpire()
    {
        return isset($this->configs['password_expire']['days_to_expire']) ? $this->configs['password_expire']['days_to_expire'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectRoute()
    {
        return isset($this->configs['password_expire']['redirect_route']) ? $this->configs['password_expire']['redirect_route'] : null;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->getEnabled();
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
