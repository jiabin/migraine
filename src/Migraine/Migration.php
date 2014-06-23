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

use Migraine\Bridge\BridgeInterface;

/**
 * Migration
 */
abstract class Migration
{
    /**
     * Migrate up
     *
     * @return boolean
     */
    abstract public function up();

    /**
     * Get type
     * 
     * @return string
     */
    abstract public function getType();

    /**
     * Get version
     * 
     * @return integer
     */
    abstract public function getVersion();

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        $refl = new \ReflectionClass($this);

        return $refl->getShortName();
    }

    /**
     * Set bridge
     * 
     * @param  BridgeInterface $bridge
     * @return self
     */
    public function setBridge(BridgeInterface $bridge = null)
    {
        $this->bridge = $bridge;

        return $this;
    }

    /**
     * Get bridge
     * 
     * @return BridgeInterface
     */
    public function getBridge()
    {
        return $this->bridge;
    }
}
