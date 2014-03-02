<?php

namespace Migraine\Command;

use Migraine\Lock;
use Migraine\Config;
use Migraine\Migration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends ConfigAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('migrate')
            ->setDescription('Migrates application')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lock = $this->getLock();

        while (!is_null($migration = $this->getLocation()->getNextMigration($lock))) {
            $this->setDependencies($migration, $input, $output);
            $migration->up();
            $lock->write($migration->getCreatedAt());
            $output->writeln('<info>Migrated to ' . $migration->getName() . '</info>');
        }
    }

    private function setDependencies(Migration $migration, InputInterface $input, OutputInterface $output)
    {
        $migration
            ->setInput($input)
            ->setOutput($output)
            ->setType($this->getType())
        ;
    }
}
