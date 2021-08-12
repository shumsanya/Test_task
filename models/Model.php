<?php
namespace app\models;

use app\system\DB;

 class Model
{
    protected static $db;

    public function __construct()
    {
        self::$db = DB::connToDB();
    }
}