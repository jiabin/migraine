<?php

namespace Migraine;

use Symfony\Component\Console\Application;

class Migraine extends Application
{
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
