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
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

/**
 * Dump reference command
 */
class DumpReferenceCommand extends ConfigurationAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dump-reference')
            ->setDescription('Dumps the default configuration for Migraine')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info># Default configuration for "Migraine"</info>');
        $dumper = new YamlReferenceDumper();
        $contents = '';
        $node = $this->getConfiguration()->getConfigTreeBuilder()->buildTree();
        foreach ($node->getChildren() as $childNode) {
            $contents .= $dumper->dumpNode($childNode);
        }
        $output->writeln($contents);
    }
}