<?php

namespace Migraine\Command;

use Migraine\Lock;
use Migraine\Config;
use Migraine\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ConfigAwareCommand extends Command
{
    protected $config;
    protected $lock;
    protected $type;
    protected $location;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->config = new Config();    
        $this->lock = new Lock();    
        $class = sprintf('\\Migraine\\Type\\%sType', ucfirst($this->config->type));
        $this->type = new $class($this->config);
        $this->location = $this->config->location;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getLock()
    {
        return $this->lock;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLocation()
    {
        return $this->location;
    }
}
