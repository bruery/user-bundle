<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Provider;

use Bruery\ClassificationBundle\Provider\Collection\BaseProvider;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\ClassificationBundle\Model\CollectionInterface;

class AgeDemographicsCollectionProvider extends BaseProvider
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * @return array
     */
    public function getFormSettingsKeys(FormMapper $formMapper)
    {
        $settings = array(
            array('min', 'integer', array('required' => true, 'attr'=>array('class'=>'span4'))),
            array('max', 'integer',array('required' => true, 'attr'=>array('class'=>'span4'))),
        );

        return $settings;
    }

    public function load(CollectionInterface $collection)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist(CollectionInterface $collection)
    {
        parent::prePersist($collection);
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate(CollectionInterface $collection)
    {
        parent::prePersist($collection);
    }
}
