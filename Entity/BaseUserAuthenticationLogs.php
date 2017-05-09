<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Entity;

use Bruery\UserBundle\Model\UserAuthenticationLogs;

class BaseUserAuthenticationLogs extends UserAuthenticationLogs
{

    /**
     * Pre Persist method
     */
    public function prePersist()
    {
        if (!$this->logDate) {
            $this->logDate = new \DateTime();
        }
    }
}
