<?php

class Auth{
      
    private $user_id;

    public function __construct(private UserGateway $user_gateway)
    {
    }

    public function authenticationApiKey():bool
    {
        $api_key = $_GET['api-key'];
       $user = $this->user_gateway->getByAPIKey($api_key);
        if( $user === false){
            http_response_code(404);
            echo json_encode(["massege"=>"invalid api key"]);
        return false;
        }else{

            $this->user_id = $user['id'];
            return true;

        }
    }


    public function getUserId():int
    {
       return $this->user_id;

    }
}