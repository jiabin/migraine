<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine;

use Migraine\Command as Commands;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Migraine application
 */
class Application extends BaseApplication
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $cwdOption = new InputOption('cwd', 'w', InputOption::VALUE_OPTIONAL, 'Current working directory');
        $definition->addOption($cwdOption);

        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCommands()
    {
        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new Commands\SelfUpdateCommand();
        $defaultCommands[] = new Commands\DumpReferenceCommand();
        $defaultCommands[] = new Commands\MigrateCommand();
        $defaultCommands[] = new Commands\StatusCommand();
        $defaultCommands[] = new Commands\CreateCommand();
        $defaultCommands[] = new Commands\InitCommand();
        $defaultCommands[] = new Commands\ResetCommand();

        return $defaultCommands;
    }

    /**
     * Get logo
     * 
     * @return string
     */
    public function getLogo()
    {
        return ' __  __ _                 _            
|  \/  (_) __ _ _ __ __ _(_)_ __   ___ 
| |\/| | |/ _` | \'__/ _` | | \'_ \ / _ \
| |  | | | (_| | | | (_| | | | | |  __/
|_|  |_|_|\__, |_|  \__,_|_|_| |_|\___|
          |___/

';
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
        return $this->getLogo() . parent::getHelp();
    }
}
