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

use Predis\Client;

/**
 * Redis type
 */
class RedisType extends AbstractType
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->client = new Client($this->configuration->get('host'), array('prefix' => $this->configuration->get('prefix')));
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->client->set('migraine:version', $version);
        $this->client->set('migraine:date', time());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        if ($this->client->exists('migraine:version')) {
            return intval($this->client->get('migraine:version'));
        }

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        if ($this->client->exists('migraine:date')) {
            $date = new \DateTime();
            $date->setTimestamp(intval($this->client->get('migraine:date')));

            return $date;
        }

        return null;
    }
}
