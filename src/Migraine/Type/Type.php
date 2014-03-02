<?php

namespace Migraine\Type;

use Migraine\Config;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class Type implements TypeInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $options;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);
        $this->options = $resolver->resolve($config->options);

        $this->init();
    }

    protected function init()
    {
    }

    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }
}