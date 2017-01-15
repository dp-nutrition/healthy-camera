<?php
require_once __DIR__.'/../db.php';

/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2017/01/03
 * Time: 20:55
 */
abstract class DbAbstract
{
    protected $_db;

    public function __construct()
    {
        $this->_db = getDb();
    }
}