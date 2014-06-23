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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Symfony bridge
 */
class SymfonyBridge extends AbstractBridge
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'bootstrap' => 'app/bootstrap.php.cache',
            'kernel'    => 'app/AppKernel.php',
            'env'       => 'dev',
            'debug'     => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        if (!file_exists($this->configuration->get('bootstrap'))) {
            throw new MigraineException($this->configuration->get('bootstrap') . ' file not found');
        }

        if (!file_exists($this->configuration->get('kernel'))) {
            throw new MigraineException($this->configuration->get('kernel') . ' file not found');
        }

        require_once $this->configuration->get('bootstrap');
        require_once $this->configuration->get('kernel');

        $kernel = new \AppKernel($this->configuration->get('env'), $this->configuration->get('debug'));
        $kernel->loadClassCache();
        $kernel->boot();

        $class = get_class($kernel);
        $this->version = $class::VERSION;

        $this->container = $kernel->getContainer();
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($key)
    {
        return $this->container->getParameter($key);
    }

    /**
     * Get symfony version
     * 
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get symfony container
     * 
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}