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
 * Status command
 */
class StatusCommand extends FactoryAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('status')
            ->setDescription('Shows migration status')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = $this->getFactory();
        $types = $factory->getTypes();
        
        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(array('#', 'Name', 'Class', 'Done?'));
        $rows = array();
        list($done, $awaiting) = array(0, 0);
        foreach ($factory->getMigrations() as $migration) {
            $data = array(
                $migration->getVersion(),
                $migration->getName(), 
                get_class($migration)
            );

            $type = $factory->getType($migration);
            $isDone = $type->getVersion() >= $migration->getVersion();
            if ($isDone) {
                $data[] = '<info> ✔ </info>';
                $done++;
            } else {
                $data[] = '<error> X </error>';
                $awaiting++;
            }

            $rows[] = $data;
        }
        if ($factory->getMigrations()->count()) {
            $table->setRows($rows);
            $table->render($output);
        }

        if ($factory->hasNextMigration()) {
            $string = sprintf('* Current version is %s, behind by %s migrations.', $factory->getVersion(), $awaiting);
        } else {
            $string = '* You are on latest version.';
        }
        $output->writeln($string);

        $lastUpdatedAt = null;
        foreach ($types as $name => $type) {
            if ($updatedAt = $type->getUpdatedAt()) {
                $lastUpdatedAt = $updatedAt;
            } 
        }
        if ($lastUpdatedAt) {
            $output->writeln(sprintf('* Last update was at %s', $lastUpdatedAt->format('c')));
        }

        if ($awaiting) {
            return 1;
        }
    }
}
