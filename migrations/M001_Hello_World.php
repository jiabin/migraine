<?php

use Migraine\Migration;

/**
 * Migration #1 Hello World
 * Created at 2014-06-22T18:06:52+02:00 by eymen
 */
class M001_Hello_World extends Migration
{
    /**
     * @see Migraine\Migration::up()
     */
    public function up()
    {
        // Execute your migration logic here
        return true;
    }

    /**
     * @see Migraine\Migration::getName()
     */
    public function getName()
    {
        return 'Hello World';
    }

    /**
     * @see Migraine\Migration::getType()
     */
    public function getType()
    {
        // Can be one of: file, mongo, redis
        return 'file';
    }

    /**
     * @see Migraine\Migration::getVersion()
     */
    public function getVersion()
    {
        return 1;
    }
}