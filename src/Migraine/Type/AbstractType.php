<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Type;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abstract type
 */
abstract class AbstractType implements TypeInterface
{
    /**
     * @var ArrayCollection
     */
    protected $configuration;

    /**
     * Class constructor
     * 
     * @param array $configuration
     */
    public function __construct(array $configuration = array())
    {
        $this->configuration = new ArrayCollection($configuration);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
    }

    /**
     * {@inheritdoc}
     */
    abstract public function setVersion($version);

    /**
     * {@inheritdoc}
     */
    abstract public function getVersion();

    /**
     * {@inheritdoc}
     */
    abstract public function getUpdatedAt();
}