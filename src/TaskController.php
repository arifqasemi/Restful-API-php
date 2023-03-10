<?php


class TaskController {
    public function __construct(private TaskGateway $gateway, private int $user_id)
    {
    }


    public function processRequest(string $method, ?string $id):void
    {

        if($id === null){

        
        if($method =="GET"){
            echo json_encode($this->gateway->getAllForUser($this->user_id));
        }elseif($method =="POST"){
            $data = (array) json_decode(file_get_contents("php://input"), true);
            // $errors = $this->getValidationErrors($data);
                
            // if ( ! empty($errors)) {
                
            //     $this->respondUnprocessableEntity($errors);
            //     return;
                
            // }
            $id = $this->gateway->create($this->user_id,$data);
            
            $this->respondCreated($id);
        }else{
            $this->responMethodNotAllowed("GET,POST,PATCH");

        }
    }else{
        $task = $this->gateway->get($this->user_id);
            
        if ($task === false) {
            
            $this->respondNotFound($id);
            return;
        }
            switch($method){
                case "GET":
                    echo json_encode($this->gateway->get($this->user_id,$id));
                    break;
                case "POST":
                     json_decode(file_get_contents("php://input"),true);
                    break;

                case "PATCH":
                    $data = (array) json_decode(file_get_contents("php://input"), true);
                    $errors = $this->getValidationErrors($data,false);
                        
                    if ( ! empty($errors)) {
                        
                        $this->respondUnprocessableEntity($errors);
                        return;
                        
                    }
                   $rows = $this->gateway->update($id,$data);
                    echo json_encode(["message" => "Task updated", "rows" => $rows]);

                    break;

                case "DELETE":
                    $rows = $this->gateway->delete($this->user_id,$id);
                    echo json_encode(["message" => "Task deleted", "rows" => $rows]);                    break;
                    default:
                    $this->responMethodNotAllowed("GET, PATCH, DELETE");
            }
        }
    }


    private function responMethodNotAllowed($allowed_method):void
    {
        http_response_code(405);
        header("allow:$allowed_method");
    }


    private function respondUnprocessableEntity(array $errors): void
    {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }

    private function respondNotFound(string $id): void
    {
        http_response_code(404);
        echo json_encode(["message" => "Task with ID $id not found"]);
    }


    private function respondCreated(string $id): void
    {
        http_response_code(201);
        echo json_encode(["message" => "Task created", "id" => $id]);
    }

    private function getValidationErrors(array $data,$new_ob): array
    {
        $errors = [];
        
        if ($new_ob && empty($data["name"])) {
            
            $errors[] = "name is required";
            
        }
        
        if ( ! empty($data["priority"])) {
            
            if (filter_var($data["priority"], FILTER_VALIDATE_INT) === false) {
                
                $errors[] = "priority must be an integer";
                
            }
        }
        
        return $errors;
    }


    
}