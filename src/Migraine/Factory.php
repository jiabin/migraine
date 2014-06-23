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

use Migraine\Exception\MigraineException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Finder\Finder;

/**
 * Factory
 */
class Factory
{
    const PREFIX    = 'M';
    const EXTENSION = 'php';

    /**
     * @var ArrayCollection
     */
    protected $migrations;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var ArrayCollection
     */
    protected $types;

    /**
     * Class constructor
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->initialize();   
    }

    /**
     * Initialize factory
     */
    public function initialize()
    {
        $migrations = new ArrayCollection();
        $types    = new ArrayCollection();

        // Find migrations
        $finder = new Finder();
        $finder->files()->name(sprintf('/%s([0-9]+)_[a-zA-Z0-9_]+\.%s$/', self::PREFIX, self::EXTENSION))->in($this->configuration->get('migrations_path'));
        foreach ($finder as $file) {
            $migration = $this->getInstance($file);
            $migrations->set($migration->getVersion(), $migration);
        }
        $this->migrations = $migrations;

        // Initialize types
        foreach ($this->configuration->get('types') as $key => $val) {
            $class  = sprintf('Migraine\Type\%sType', ucfirst($key));
            $type = new $class($val);
            $type->initialize();
            $types->set($key, $type);    
        }
        $this->types = $types;
    }

    /**
     * Create migration
     *
     * @param  string    $name
     * @return Migration
     */
    public function create($name)
    {
        $slug     = preg_replace('/\W+/', '_', ucwords(strtolower(strip_tags($name))));
        $version  = $this->getMigrations()->last() ? $this->getMigrations()->last()->getVersion() + 1 : 1;
        $class    = sprintf('%s%s_%s', self::PREFIX, str_pad($version, $this->configuration->get('pad_length'), '0', STR_PAD_LEFT), $slug);
        $skeleton = file_get_contents(sprintf('%s/../../res/migration.skeleton', __DIR__));
        $contents = strtr($skeleton, array(
            '%class%'   => $class,
            '%name%'    => $name,
            '%version%' => $version,
            '%date%'    => date('c'),
            '%user%'    => get_current_user(),
            '%types%'   => implode(', ', array_keys($this->configuration->get('types')))
        ));

        $file = sprintf('%s/%s.%s', realpath($this->configuration->get('migrations_path')), $class, self::EXTENSION);
        file_put_contents($file, $contents);

        return $this->getInstance($file);
    }

    /**
     * Get migration instance
     *
     * @param  string    $file
     * @return Migration
     */
    public function getInstance($file)
    {
        require_once $file;
        $class = str_replace('.' . self::EXTENSION, '', basename($file));

        return new $class();
    }

    /**
     * Get version
     * 
     * @return integer
     */
    public function getVersion()
    {
        $version = 0;
        foreach ($this->getTypes() as $type) {
            if (($v = $type->getVersion()) && $v > $version) {
                $version = $v;
            }
        }

        return $version;
    }

    /**
     * Has next migration
     * 
     * @return boolean
     */
    public function hasNextMigration()
    {
        return $this->getMigrations()->offsetExists($this->getVersion() + 1);
    }

    /**
     * Get next migration
     * 
     * @return Migration
     */
    public function getNextMigration()
    {
        $nextVersion = $this->getVersion() + 1;
        if ($this->getMigrations()->offsetExists($nextVersion) === false) {
            return null;
        }

        return $this->getMigrations()->get($nextVersion);
    }

    /**
     * Get next migration
     *
     * @param  Migration $migration
     * @return boolean
     */
    public function execute(Migration $migration)
    {
        $type = $this->getType($migration);
        $result = $migration->up();
        if ($result) {
            $type->setVersion($migration->getVersion());
        }

        return $result;
    }

    /**
     * Get type
     * 
     * @param  Migration|string $arg
     * @return TypeInterface
     */
    public function getType($arg)
    {
        if (gettype($arg) === 'object' && $arg instanceof Migration) {
            $name = $arg->getType();
        } elseif (is_string($arg)) {
            $name = $arg;
        } else {
            throw new MigraineException('Argument must be a string or a Migration object');
        }

        if ($this->getTypes()->offsetExists($name) === false) {
            throw new MigraineException("Invalid or disabled type: $name");
        }

        return $this->getTypes()->get($name);
    }

    /**
     * Get migrations
     * 
     * @return ArrayCollection
     */
    public function getMigrations()
    {
        return $this->migrations;
    }

    /**
     * Get types
     * 
     * @return ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }
}
