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
 * Mongo type
 */
class MongoType extends AbstractType
{
    /**
     * @var MongoCollection
     */
    protected $collection;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $cl = new \MongoClient($this->configuration->get('server'));
        $db = $cl->selectDB($this->configuration->get('database'));

        $this->collection = $db->selectCollection('migraine');
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->collection->remove();
        $this->collection->insert(array(
            'version'   => $version,
            'updatedAt' => new \MongoDate()
        ));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        $info = $this->collection->findOne();
        if ($info && array_key_exists('version', $info)) {
            return $info['version'];
        }

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        $info = $this->collection->findOne();
        if ($info && array_key_exists('updatedAt', $info)) {
            $mongoDate = $info['updatedAt'];
            $updatedAt = new \DateTime();
            $updatedAt->setTimestamp($mongoDate->sec);

            return $updatedAt;
        }

        return null;
    }
}
