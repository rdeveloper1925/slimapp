<?php
namespace App\Repositories;

class UserRepo{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function userExists(string $uid){
        $query = "SELECT COUNT(*) from "
        $this->db->run();
    }
}