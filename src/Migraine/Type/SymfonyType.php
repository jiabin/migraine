<?php

namespace Migraine\Type;

use Migraine\Exception\MigraineException as Exception;

class SymfonyType extends Type
{
    protected function init() 
    {
        $bootstrap = getcwd().'/app/bootstrap.php.cache';
        $kernel = getcwd().'/app/AppKernel.php';

        if (!file_exists($bootstrap)) {
            throw new Exception('app/bootstrap.php.cache file not found');
        }

        if (!file_exists($kernel)) {
            throw new Exception('app/AppKernel.php file not found');
        }

        require_once $bootstrap;
        require_once $kernel;

        $kernel = new \AppKernel('dev', true);
        $kernel->loadClassCache();
        $kernel->boot();

        $class = get_class($kernel);
        $this->symfonyVersion = $class::VERSION;

        $this->container = $kernel->getContainer();
    }

    public function getSymfonyVersion()
    {
        return $this->symfonyVersion;
    }

    public function getContainer()
    {
        return $this->container;
    }
}