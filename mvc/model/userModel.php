<?php
    include_once('./bdd.php');

    class UserModel{
        static function register($email,$password){
            $bdd = getConnexion();
            $req = $bdd->prepare("SELECT COUNT(*) FROM user WHERE email=?");
            $req->execute(array($email));
            $count = $req->fetchColumn();

            if($count > 0){
                throw new Exception("User already exists");
            }

            $req = $bdd->prepare("INSERT INTO user(email,password) VALUE(?,?)");
            $req->execute(array($email,md5($password)));
        }

        static function login($email,$password){
            $bdd = getConnexion();
            $req = $bdd->prepare("SELECT * FROM user WHERE email=?");
            $req->execute(array($email));
            $user = $req->fetch(PDO::FETCH_OBJ);

            if(!$user){
                throw new Exception("Email ou mot de passe incorrect");
            }

            if(md5($password) != $user->password){
                throw new Exception("Email ou mot de passe incorrect");
            }

            return $user;
        }
    }