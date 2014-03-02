<?php

namespace Migraine\Location;

class FilesystemLocation extends Location
{
    public function __construct($location)
    {
        if (substr($location, 0, 1) !== DIRECTORY_SEPARATOR) {
            // Relative path
            $location = getcwd().'/'.$location;
        }

        parent::__construct($location);
    }

    public function createMigration($key, $val)
    {
        $path = implode(DIRECTORY_SEPARATOR, array(rtrim($this->location, DIRECTORY_SEPARATOR), $key));
        file_put_contents($path, $val);
    }

    public function getMigrations()
    {
        $migrations = array();

        foreach (scandir($this->location, 1) as $file) {
            if ($file != "." && $file != ".." && $this->validate($file)) {
                $migration = $this->load($file);
                $migrations[$migration->getName()] = $migration;
            }
        }

        return $migrations;
    }
}