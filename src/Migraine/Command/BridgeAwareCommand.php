<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Command;

/**
 * Bridge aware command
 */
class BridgeAwareCommand extends ConfigurationAwareCommand
{
    /**
     * @var BridgeInterface
     */
    protected $bridge;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $bridge = $this->getConfiguration()->get('bridge');
        if ($bridge && array_key_exists('name', $bridge)) {
            // Initialize bridge
            $types = $this->getConfiguration()->get('types');
            $class = sprintf('Migraine\Bridge\%sBridge', ucfirst($bridge['name']));

            $this->bridge = new $class($bridge['options']);

            // Bridge parameters override
            foreach ($types as $name => $type) {
                if ($type['enabled'] === false) {
                    continue;
                }
                unset($type['enabled']);
                foreach ($type as $key => $val) {
                    preg_match('/%bridge\.(.*)%/i', $val, $match);
                    if ($match) {
                        $types[$name][$key] = $this->bridge->getParameter($match[1]);
                    }
                }
            }
            $this->getConfiguration()->set('types', $types);
        }
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
