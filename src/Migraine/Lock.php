<?php

namespace Migraine;

class Lock
{
    /**
     * @var string
     */
    protected $lock;

    /**
     * @var DateTime
     */
    protected $date;

    public function __construct($lock = 'migraine.lock')
    {
        $this->lock = $lock;
        $this->date = $this->load();
    }

    private function load()
    {
        if (file_exists($this->lock)) {
            if ($json = file_get_contents($this->lock)) {
                return new \DateTime($json);
            }
        }

        $now = new \DateTime();
        $this->write($now);

        return $now;
    }

    public function getCreatedAt()
    {
        return $this->date;
    }

    public function write(\DateTime $date)
    {
        $this->date = $date;

        file_put_contents($this->lock, $date->format('c'));
    }
}
