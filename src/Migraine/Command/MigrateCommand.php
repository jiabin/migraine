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

use Migraine\Config;
use Migraine\Migration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Migrate command
 */
class MigrateCommand extends FactoryAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('migrate')
            ->setDescription('Execute migrations')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->getFactory()->hasNextMigration() === false) {
            return $output->writeln('<comment>No new migrations found. Application is already up to date!</comment>');
        }

        while (true) {
            $migration = $this->getFactory()->getNextMigration();
            if (is_null($migration)) {
                break;
            }
            $migration->setBridge($this->getBridge());

            if ($this->getFactory()->execute($migration) !== true) {
                return $output->writeln(sprintf('<error> An error occured while executing migration #%s "%s" </error>', $migration->getVersion(), $migration->getName()));
            }

            $output->writeln(sprintf('<info>Migrated to #%s "%s"</info>', $migration->getVersion(), $migration->getName()));
        }
    }
}
