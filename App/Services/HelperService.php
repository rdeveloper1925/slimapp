<?php
namespace App\Services;
use App\Interfaces\DatabaseInterface;

class HelperService{
    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $database){
        $this->db = $database;
    }

    public function healthCheck():array{
        $result= array();
        if($this->db->isConnected()){
            $result['db']=[
                'status'=>'ok',
                'errors'=> $this->db->getLastError() ?? null
            ];
        }else{
            $result['db']=[
                'status' => 'not ok',
                'errors' => $this->db->getLastError() ?? 'no error'
            ];
        }
        
        $result['environment']=$_ENV['ENVIRONMENT'];
        return $result;
    }

    public function sayHello(){
        return ["Welcome to my slim application that is absolutely banging."];
    }
}