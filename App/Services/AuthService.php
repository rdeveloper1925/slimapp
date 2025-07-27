<?php
namespace App\Services;

class AuthService{
    private RequestValidator $validator;

    public function __construct(RequestValidator $validator){
        $this->validator = $validator;
    }

    public function userExists(){
        
    }
}