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

use Migraine\Exception\MigraineException as Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create command
 */
class CreateCommand extends FactoryAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('create')
            ->setDescription('Creates a new migration')
            ->addArgument('name', InputArgument::REQUIRED, 'Migration name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (is_null($input->getArgument('name'))) {
            $dialog = $this->getHelperSet()->get('dialog');

            $name = $dialog->askAndValidate($output, 'Migration name: ', function ($answer) {
                if (is_null($answer)) {
                    throw new Exception('You must give a name to this migration');
                }
                
                return $answer;
            }, 3, null);
            $input->setArgument('name', $name);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migration = $this->factory->create($input->getArgument('name'));
        
        $output->writeln(sprintf('<info>Migration #%s "%s" created in %s</info>', 
            $migration->getVersion(), 
            $migration->getName(),
            $this->getConfiguration()->get('migrations_path')
        ));
    }
}
