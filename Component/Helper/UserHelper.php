<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Component\Helper;

use Sonata\CoreBundle\Model\ManagerInterface;

class UserHelper
{
    protected $collectionManager;
    /**
     * @return mixed
     */
    public function getCollectionManager()
    {
        return $this->collectionManager;
    }

    /**
     * @param mixed $collectionManager
     */
    public function setCollectionManager(ManagerInterface $collectionManager)
    {
        $this->collectionManager = $collectionManager;
    }

    public function getAgeBracket($age = null, $context = null)
    {
        if ($age && $context) {
            $ageBrackets = $this->collectionManager->findBy(array('context'=>$context, 'enabled'=>true));
            foreach ($ageBrackets as $bracket) {
                if ($settings = $bracket->getSettings()) {
                    if (array_key_exists('min', $settings) && array_key_exists('max', $settings)) {
                        if (((int)$settings['min']) <= $age && (((int)$settings['max']) >= $age)) {
                            return $bracket;
                        }
                    }
                }
            }
        } else {
            return null;
        }
    }
}
