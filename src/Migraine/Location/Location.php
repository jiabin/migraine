<?php

namespace Migraine\Location;

use Migraine\Lock;

abstract class Location
{
    /**
     * @var string
     */
    protected $location;

    public function __construct($location)
    {
        $this->location = $location;
    }

    public function validate($file)
    {
        if (!preg_match('/^M([0-9]{4})([0-9]{1,2})([0-9]{1,2})T(?:(?:([01]?\d|2[0-3]))?([0-5]?\d))?([0-5]?\d).php$/', $file)) {
            return false;
        }

        return true;
    }

    public function load($file)
    {
        $path = implode(DIRECTORY_SEPARATOR, array(rtrim($this->location, DIRECTORY_SEPARATOR), $file));

        require_once($path);

        $class = str_replace('.php', '', $file);

        return new $class();
    }

    public function getNextMigration(Lock $lock)
    {
        $createdAt = $lock->getCreatedAt();
        $migrations = $this->getMigrations();
        ksort($migrations);
        foreach ($migrations as $migration) {
            if ($migration->getCreatedAt() > $lock->getCreatedAt()) {
                return $migration;
            }
        }

        return null;
    }

    public function getLatestMigration()
    {
        return current($this->getMigrations());
    }

    abstract public function getMigrations();

    abstract public function createMigration($key, $val);
}