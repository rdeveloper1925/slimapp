<?php
namespace App\Interfaces;

use PDO;

interface DatabaseInterface{
    function connect():void;
    function setDbName(string $dbName);
    function isConnected():bool;
    function getConnection():?PDO;
    function getLastError():array;
}