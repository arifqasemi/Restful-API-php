<?php

require __DIR__ . "/vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
  
    
    $database = new Database("localhost", "restful_api", "root", "");

                             
    $conn = $database->getConnection();
    
    $sql = "INSERT INTO user (name, username, password_hash, api_key)
            VALUES (:name, :username, :password_hash, :api_key)";
            
    $stmt = $conn->prepare($sql);
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $api_key = bin2hex(random_bytes(16));
    
    $stmt->bindValue(":name", $_POST["name"], PDO::PARAM_STR);
    $stmt->bindValue(":username", $_POST["username"], PDO::PARAM_STR);
    $stmt->bindValue(":password_hash", $password_hash, PDO::PARAM_STR);
    $stmt->bindValue(":api_key", $api_key, PDO::PARAM_STR);
    
    $stmt->execute();
    
    echo "Thank you for registering. Your API key is ", $api_key ."<br>" ."<br>"."<a class='loginbtn' href='example-client.html' style='background:blue;padding:10px 12px;color:white; border-radius: 5px; '>Login</a>";
    exit;
}

?>
<style>
    .loginbtn{
        padding:20px;
    }
</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
</head>
<body>
    
    <main class="container">
    
        <h1>Register</h1>
        
        <form method="post">
            
            <label for="name">
                Name
                <input name="name" id="name">
            </label>
            
            <label for="username">
                Username
                <input name="username" id="username">
            </label>
            
            <label for="password">
                Password
                <input type="password" name="password" id="password">
            </label>
            
            <button>Register</button>
        </form>
    </main>
    
</body>
</html>
        
        
        
        
        
        
        
        
        
        
        
        
        