<?php
namespace App\Services;

use Exception;

class RequestValidator{
    private array $warnings = [];
    private array $errors = [];

    public function __construct(){

    }

    public function validate(array $data, array $rules): bool{
        $willReturn = true;
        foreach($rules as $k=>$v){
            if(!array_key_exists($k, $data)){
                //specified key in rule is not in data. 
                array_push($this->errors, ucwords("'$k' is missing from the data provided"));
                $willReturn = false;
                continue;
            }

            $rulesList = explode('|', $v);
            foreach($rulesList as $rule){
                if(!method_exists($this, $rule)){
                    throw new Exception("Unassumed rule '$rule'");
                }

                if($rule == 'present'){
                    $this->present($k, $data);
                    continue;
                }

                if(!$this->$rule($k, $data[$k])){
                    $willReturn = false;
                }
            }
        }

        return $willReturn;
    }

    public function getWarnings(): array{
        return $this->warnings;
    }

    public function getErrors(): array{
        return $this->errors;
    }

    public function present(string $key, array $data){
        if(!array_key_exists($key, $data)){
            array_push($this->errors, "$key must be present in request!");
            return false;
        }else return true;
    }

    public function required(string $key, string $value): bool{
        if($value == '' || $value == null){
            array_push($this->errors, "$key is Required!");
            return false;
        }
        return true;
    }

    public function email(string $key, string $email): bool{
        // Basic format validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errors, "$key is invalid!");
            return false;
        }

        // Split into local and domain parts
        [$local, $domain] = explode('@', $email, 2);

        // Ensure domain part exists
        if (empty($domain)) {
            array_push($this->errors, "$key is invalid!");
            return false;
        }

        // Optional DNS check for domain validity
        if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
            array_push($this->errors, "$key is invalid!");
            return false;
        }

        // Check for double dots
        if (strpos($email, '..') !== false) {
            array_push($this->errors, "$key is invalid!");
            return false;
        }

        // Check for invalid characters (basic sanity check beyond filter_var)
        if (preg_match('/[\s]/', $email) && preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', $email) === 1) {
            array_push($this->errors, "$key is invalid!");
            return false;
        }

        return true;
    }

}