<?php

namespace Migraine\Command;

use Migraine\Lock;
use Migraine\Config;
use Migraine\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Creates a basic migraine.json file in current directory.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite existing configuration file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $val = $this->getSkeleton();

        $file = getcwd().'/migraine.json';

        if (file_exists($file) && !$input->getOption('force')) {
            return $output->writeln("<error>File migraine.json already exists</error>");
        }

        file_put_contents($file, $val);
        $output->writeln("<info>File migraine.json created</info>");
    }

    private function getSkeleton()
    {
        return '{
    "type": "default",
    "location": "migrations"
}';
    }
}
