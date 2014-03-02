<?php

namespace Migraine\Command;

use Migraine\Lock;
use Migraine\Config;
use Migraine\Migration;
use Migraine\Exception\MigraineException as Exception;
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
            ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Migraine type to use in configuration', 'default')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite existing configuration file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $val = $this->getSkeleton($input->getOption('type'));

        $file = getcwd().'/migraine.json';

        if (file_exists($file) && !$input->getOption('force')) {
            return $output->writeln("<error>File migraine.json already exists</error>");
        }

        file_put_contents($file, $val);

        $dir = dirname($file).'/migrations';
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $output->writeln("<info>File migraine.json created</info>");
    }

    private function getSkeleton($type)
    {
        switch ($type) {
            case 'default':
            case 'symfony':
                $skeleton = array(
                    'type' => $type
                );
                break;
            default:
                throw new Exception("Unknown type given: $type");
                break;
        }

        $skeleton['location'] = 'migrations';

        return json_encode($skeleton, JSON_PRETTY_PRINT);
    }
}
