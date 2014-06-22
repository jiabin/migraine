<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) 2014 Jiabin <dev@jiabin.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

/**
 * Configuration
 */
class Configuration implements ConfigurationInterface
{
    const NAME = 'migraine.yml';

    /**
     * Class constructor
     * 
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $config    = file_exists(Configuration::NAME) ? Yaml::parse(Configuration::NAME) : array();
        $processor = new Processor();
        $processed = $processor->processConfiguration($this, array($config));

        $this->configuration = new ArrayCollection($processed);
    }

    /**
     * Get configuration
     * 
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->configuration->get($key);
    }

    /**
     * All
     * 
     * @return ArrayCollection
     */
    public function all()
    {
        return $this->configuration;
    }

    /**
     * To array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->configuration->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('migraine');

        $rootNode
            ->children()
                ->scalarNode('migrations_path')
                    ->info('Migrations will be stored and read from this path')
                    ->defaultValue('./migrations')
                ->end()
                ->integerNode('pad_length')
                    ->info('Number of "zeros" to append to version')
                    ->defaultValue(3)
                ->end()
                ->arrayNode('drivers')
                    ->info('Driver configuration')
                    ->children()
                        ->arrayNode('file')
                            ->canBeDisabled()
                            ->children()
                                ->scalarNode('lock_file')->defaultValue('migraine.lock')->end()
                            ->end()
                        ->end()
                        ->arrayNode('redis')
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('host')->defaultValue('tcp://localhost:6379')->end()
                                ->scalarNode('prefix')->defaultNull()->end()
                            ->end()
                        ->end()
                        ->arrayNode('mongo')
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('server')->defaultValue('mongodb://localhost:27017')->end()
                                ->scalarNode('database')->defaultValue('migraine')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
