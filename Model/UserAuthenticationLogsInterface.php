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

interface UserAuthenticationLogsInterface
{

    /**
     * @return mixed
     */
    public function getUser();

    /**
     * @param mixed $user
     */
    public function setUser($user);

    /**
     * @return mixed
     */
    public function getLogDate();

    /**
     * @param mixed $logDate
     */
    public function setLogDate($logDate);

    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param mixed $type
     */
    public function setType($type);
}
