<?php

class Auth{
    

    public function __construct(private UserGateway $user_gateway)
    {
    }

    public function authenticationApiKey():bool
    {
        $api_key = $_GET['api-key'];

        if($this->user_gateway->getByAPIKey($api_key) === false){
            http_response_code(404);
            echo json_encode(["massege"=>"invalid api key"]);
        return false;
        }else{
            print_r($this->user_gateway->getByAPIKey($api_key));
            return true;

        }
    }
}