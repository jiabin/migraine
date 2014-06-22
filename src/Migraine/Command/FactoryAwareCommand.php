<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) 2014 Jiabin <dev@jiabin.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Command;

use Migraine\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Factory aware command
 */
class FactoryAwareCommand extends BridgeAwareCommand
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * {@inheritdoc}
     */
    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->factory = new Factory($this->getConfiguration());

        return parent::initialize($input, $output);
    }

    /**
     * Get factory
     * 
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
