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

use Sonata\UserBundle\Entity\BaseUser as AbstractedUser;

class BaseUser extends AbstractedUser
{
    /**
     * @var string
     */
    protected $middlename;

    protected $passwordChangedAt;

    /**
     * @return mixed
     */
    public function getPasswordChangedAt()
    {
        return $this->passwordChangedAt;
    }

    /**
     * @param mixed $passwordChangedAt
     */
    public function setPasswordChangedAt($passwordChangedAt)
    {
        $this->passwordChangedAt = $passwordChangedAt;
    }

    public function setPlainPassword($password)
    {
        $this->setPasswordChangedAt(new \DateTime());
        return parent::setPlainPassword($password);
    }

    /**
     * @param string $middlename
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    }

    /**
     * @return string
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }
}
