<?php

namespace Migraine;

use Migraine\Exception\MigraineException as Exception;
use Migraine\Exception\IOException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Config
{
    /**
     * @var array
     */
    protected $config = array();

    public function __construct($config = 'migraine.json', $version = 1)
    {
        if (!file_exists($config)) {
            throw new IOException('No migraine configuration file found');
        }

        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver, $version);
        $this->config = $resolver->resolve(json_decode(file_get_contents($config), true));
    }

    protected function setDefaultOptions(OptionsResolverInterface $resolver, $version)
    {
        $resolver
            ->setRequired(array(
                'type'
            ))
            ->setDefaults(array(
                'version'  => $version,
                'options'  => array(),
                'location' => 'migrations'
            ))
            ->setNormalizers(array(
                'location' => function (Options $options, $value) {
                    $colon = '://';
                    $pos = strpos($value, $colon);
                    if ($pos === false) {
                        list($value, $pos) = array(sprintf('file%s%s', $colon, $value), 4);
                    }
                    $location = substr($value, $pos + strlen($colon));
                    $type = substr($value, 0, $pos);
                    switch ($type) {
                        case 'file':
                            $type = 'filesystem';
                            break;
                        case 'git':
                            break;
                        default:
                            throw new Exception("Unknown location type $type");
                            break;
                    }
                    $class = sprintf('\\Migraine\\Location\\%sLocation', ucfirst($type));

                    return new $class($location);
                }
            ))
        ;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        throw new Exception("Key $key does not exists");
    }

    public function __set($key, $val)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new Exception("Key $key does not exists");
        }

        $this->config[$key] = $val;
    }
}
