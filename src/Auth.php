<?php

class Auth{
      
    private $user_id;

    public function __construct(private UserGateway $user_gateway,private JWTCodec $codec)
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


    public function authenticateAccessToken(): bool
    {
        if ( ! preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }
        
        try {
            $data = $this->codec->decode($matches[1]);
            
        } catch (Exception $e) {
            
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }
        
        $this->user_id = $data["id"];
        
        return true;
    }
}