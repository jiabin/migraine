<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Command;

use Migraine\Configuration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Configuration aware command
 */
class ConfigurationAwareCommand extends Command
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->configuration = new Configuration();
    }

    /**
     * Get configuration
     * 
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
