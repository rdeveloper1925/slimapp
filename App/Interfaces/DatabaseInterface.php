<?php
namespace App\Interfaces;

interface DatabaseInterface{
    function connect():void;
    function setDbName(string $dbName);
    function isConnected():bool;
    function getConnection();
    function getLastError():array;
    function fetchOne(string $sql, array $params);
    function fetchAssoc(string $sql, array $params);
    function execute(string $sql, array $params);
}