<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Type;

/**
 * Type interface
 */
interface TypeInterface
{
    /**
     * Initialize type
     */
    public function initialize();
    
    /**
     * Set version
     * 
     * @param  integer $version
     * @return self
     */
    public function setVersion($version);

    /**
     * Get version
     * 
     * @return integer|null
     */
    public function getVersion();

    /**
     * Get UpdatedAt
     * 
     * @return DateTime|null
     */
    public function getUpdatedAt();
}