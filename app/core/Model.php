<?php

namespace app\core;

abstract class Model extends Db
{
    public $db;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = new Db;
    }


}