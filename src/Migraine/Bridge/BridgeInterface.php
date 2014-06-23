<?php

/*
 * This file is part of the Migraine package.
 *
 * (c) Jiabin <dev@jiabin.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Migraine\Bridge;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Bridge interface
 */
interface BridgeInterface
{
    /**
     * Configure options
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolverInterface $resolver);

    /**
     * Initialize bridge
     */
    public function initialize();
}