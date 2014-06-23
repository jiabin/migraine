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
 * Composer bridge
 */
class ComposerBridge extends AbstractBridge
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'autoload' => 'vendor/autoload.php'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        require_once $this->configuration->get('autoload');
    }
}