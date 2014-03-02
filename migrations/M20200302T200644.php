<?php

use Migraine\Migration;

class M20200302T200644 extends Migration
{
    public function up()
    {
        $output = $this->getOutput();
        $output->writeln('Hello World!');
    }

    public function down()
    {

    }

    public function getDescription()
    {
        return 'Migration M20140302T200644';
    }
}