<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;

class ResponseWrapper{

    public static function wrap(array $data, ResponseInterface $response, bool $success=true, string $errors='', int $status=200){
        $rs = [
            'success' => $success,
            'data' => $data,
            'errors' => $errors,
            'size' => count($data)
        ];

        $response->getBody()->write(json_encode($rs));
        return $response->withStatus($status);
    }
}
