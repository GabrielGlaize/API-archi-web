<?php
//  gère la connexion. 
// si envoie email+mot de passe sur /login, 
// ce fichier vérifie que c'est correct, 
// puis appelle JWT::encode() pour fabriquer un token et le renvoyer.

    include_once('./model/user.model.php');
    include_once('./JWT/JWT.php');

    class AuthController {

        function login() {
            $data = file_get_contents("php://input");
            $user = json_decode($data);

            $authUser = UserModel::login($user->email,$user->password);

            $token = JWT::encode($authUser, JWT_SECRET, "HS256");

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
