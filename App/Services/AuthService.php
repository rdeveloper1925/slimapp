<?php
namespace App\Services;

use App\Repositories\UserRepo;

class AuthService{
    private RequestValidator $validator;
    private UserRepo $userRepo;

    public function __construct(RequestValidator $validator, UserRepo $userRepo){
        $this->validator = $validator;
        $this->userRepo = $userRepo;
    }

    public function loginSignup(array $requestData){
        $uid = $requestData['uid'] ?? null;
        if(!$this->userRepo->userExists($uid)){
            $this->userRepo->insertUser($requestData);
        }else{
            $this->userRepo->updateUser($requestData);
        }
        return $uid;
    }
}