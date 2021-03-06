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

use Migraine\Configuration;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

/**
 * Init command
 */
class InitCommand extends ConfigurationAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Creates a new configuration file')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite existing configuration file')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (file_exists(Configuration::NAME) && $input->getOption('force') === false) {
            $output->writeln('<error>Configuration file already exists.</error>');
            $output->writeln('<comment>To overwrite it use `--force` option.</comment>');

            return;
        }

        $contents = '';
        $dumper = new YamlReferenceDumper();
        $node = $this->getConfiguration()->getConfigTreeBuilder()->buildTree();
        foreach ($node->getChildren() as $childNode) {
            $contents .= $dumper->dumpNode($childNode);
        }
        file_put_contents(Configuration::NAME, trim($contents));

        $output->writeln('<info>Configuration file created successfully!</info>');
    }
}
