<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Bridge;

use Migraine\Exception\MigraineException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Abstract bridge
 */
abstract class AbstractBridge implements BridgeInterface
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
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $configuration = $resolver->resolve($configuration);

        $this->configuration = new ArrayCollection($configuration);
        $this->initialize();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function configureOptions(OptionsResolverInterface $resolver);

    /**
     * {@inheritdoc}
     */
    abstract public function initialize();

    /**
     * {@inheritdoc}
     */
    public function getParameter($key)
    {
        throw new MigraineException("Unknown parameter: $key");
    }

    /**
     * Get configuration
     * 
     * @return ArrayCollection
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}