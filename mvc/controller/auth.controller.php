<?php
    include('./model/user.model.php');
    include('./JWT/JWT.php');

    class AuthController {
        
        function login() {
            $data = file_get_contents("php://input");
            $user = json_decode($data);
            
            $authUser = UserModel::login($user->email,$user->password);

            $token = JWT::encode($authUser,"","HS256");

            include('./view/login.json.php');
        }

        function register() {
            $data = file_get_contents("php://input");
            $user = json_decode($data);

            if(empty($user->email) || empty($user->password)){
                throw new Exception('Email and password required');
            }

            UserModel::register($user->email,$user->password);
            include('./view/register.json.php');
        }
    }
