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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Reset command
 */
class ResetCommand extends FactoryAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('reset')
            ->setDescription('Reset migraine')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('no-interaction') === false) {
            $dialog = $this->getHelperSet()->get('dialog');
            if (!$dialog->askConfirmation(
                    $output,
                    '<question>This action will erase entire lock information. Are you sure you want to continue? (y/N)</question>',
                    false
                )) {
                
                return $output->writeln('<comment>Command aborted by user</comment>');
            }
        }

        foreach ($this->getFactory()->getTypes() as $type) {
            $type->setVersion(0);
        }
        $output->writeln('<info>Lock cleared successfully</info>');
    }
}
