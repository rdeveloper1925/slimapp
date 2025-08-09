<?php

namespace App\Controllers;

use App\Middleware\ResponseWrapper as Res;
use App\Services\AuthService;
use App\Services\HelperService;
use App\Services\RequestValidator;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MscController
{
    private HelperService $helper;
    private AuthService $auth;
    private RequestValidator $validator;

    public function __construct(HelperService $helper, AuthService $auth, RequestValidator $validator)
    {
        $this->helper = $helper;
        $this->auth = $auth;
        $this->validator = $validator;
    }

    public function checkHealth(Request $request, Response $response)
    {
        return Res::wrap($this->helper->healthCheck(), $response);
    }

    public function sayHello(Request $request, Response $response)
    {
        return Res::wrap($this->helper->sayHello(), $response);
    }

    public function fallBack(Request $request, Response $response)
    {
        return Res::wrap([], $response, false, "Not Found", 404);
    }

    public function loginSignup(Request $request, Response $response){
        $requestData = $request->getParsedBody() ?? [];
        $rules = [
            'email' => 'required|email',
            'uid' => 'required',
            'name' => 'present',
            'providerId' => 'required',
            'photo' => 'present'
        ];
        $result = $this->validator->validate($requestData, $rules);
        if(!$result){
            $errors = array_merge($this->validator->getErrors(),$this->validator->getWarnings());
            return Res::wrap($errors, $response, false, implode(',', $errors), 400);
        }

        //write to db.
        $uid = $this->auth->loginSignup($requestData);
        return Res::wrap([$uid], $response, true, '', 201);
    }
}
