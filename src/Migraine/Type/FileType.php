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
 * File type
 */
class FileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $dir = dirname($this->configuration->get('lock_file'));
        if (file_exists($dir) === false) {
            mkdir($dir, 0777, true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        file_put_contents($this->configuration->get('lock_file'), $version);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        $file = $this->configuration->get('lock_file');
        if (file_exists($file) === false) {
            return 0;
        }

        return intval(file_get_contents($file));
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        $file = $this->configuration->get('lock_file');
        if (file_exists($file) === false) {
            return null;
        }

        $lastUpdatedAt = new \DateTime();
        $lastUpdatedAt->setTimestamp(filemtime($file));

        return $lastUpdatedAt;
    }
}
