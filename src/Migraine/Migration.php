<?php

namespace Migraine;

use Migraine\Type\Type;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Migration
{
    abstract public function up();

    abstract public function down();

    public function setInput(InputInterface $input)
    {
        $this->input = $input;

        return $this;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return get_class($this);
    }

    public function getCreatedAt()
    {
        $str = str_replace('M', '', get_class($this));

        return \DateTime::createFromFormat('Ymd\THis', $str);
    }
}
