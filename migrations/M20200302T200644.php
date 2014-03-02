<?php

use Migraine\Migration;

class M20200302T200644 extends Migration
{
    public function up()
    {
        $this->getOutput()->writeln('Starting sample migration...');

        // Access symfony container
        $symfony   = $this->getType();
        $container = $symfony->getContainer();
        
        $this->getOutput()->writeln('You are using Symfony ' . $symfony->getSymfonyVersion());
    }

    public function down()
    {

    }

    public function getDescription()
    {
        return 'Migration M20140302T200644';
    }
}