<?php


class TaskController {
    public function __construct(private TaskGateway $gateway)
    {
    }


    public function processRequest(string $method, ?string $id)
    {

        if($id ===""){

        
        if($method =="GET"){
            echo json_encode($this->gateway->getAll());
        }elseif($method =="POST"){
            echo "create";
        }else{
            $this->responMethodNotAllowed("GET,POST");

        }
    }else{
            switch($method){
                case "GET":
                    echo json_encode($this->gateway->get($id));
                    break;
                case "PATCH":
                    echo "update $id";
                    break;

                case "DELETE":
                    echo "delete $id";
                    break;
                    default:
                    $this->responMethodNotAllowed("GET,POST,DELETE");
            }
        }
    }


    private function responMethodNotAllowed($allowed_method):void
    {
        http_response_code(405);
        header("allow:$allowed_method");
    }
}