<?php

namespace Migraine;

use Migraine\Command as Commands;
use Symfony\Component\Console\Application;

class Migraine extends Application
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultCommands()
    {
        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new Commands\SelfUpdateCommand();
        $defaultCommands[] = new Commands\MigrateCommand();
        $defaultCommands[] = new Commands\CreateCommand();
        $defaultCommands[] = new Commands\InitCommand();

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
