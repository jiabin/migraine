<?php

namespace Migraine\Command;

use Migraine\Lock;
use Migraine\Config;
use Migraine\Migration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends ConfigAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('create')
            ->setDescription('Creates a new migration')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $name = sprintf('M%s', $now->format('Ymd\THis'));

        $val = $this->getSkeleton($name);

        $this->getLocation()->createMigration($name.'.php', $val);
        $output->writeln("<info>Migration $name created</info>");
    }

    private function getSkeleton($name)
    {
        $str = '<?php

use Migraine\Migration;

class {{ name }} extends Migration
{
    public function up()
    {
        
    }

    public function down()
    {

    }

    public function getDescription()
    {
        return \'Migration {{ name }}\';
    }
}';
        return str_replace('{{ name }}', $name, $str);
    }
}
