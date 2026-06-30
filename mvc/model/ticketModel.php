<?php
    include_once('./bdd.php');

    class TicketModel{
        static function getAll(){
            $bdd = getConnexion();
            $req = $bdd->prepare("SELECT * FROM ticket");
            $req->execute();
            return $req->fetchAll(PDO::FETCH_OBJ);
        }

        static function getById($id){
            $bdd = getConnexion();
            $req = $bdd->prepare("SELECT * FROM ticket WHERE id = ?");
            $req->execute(array($id));
            return $req->fetch(PDO::FETCH_OBJ);
        }

        static function create($tickets){
             $bdd = getConnexion();
             $req = $bdd->prepare("INSERT INTO ticket(title,category,priority,status) VALUE(?,?,?,?)");
             $req->execute(array($tickets->title, $tickets->category, $tickets->priority, $tickets->status));
             return $req->fetch();
        }

        static function update($id, $tickets){
            $bdd = getConnexion();
            $req = $bdd->prepare("UPDATE ticket SET title = ?, category = ?, priority = ?, status = ? WHERE id = ?");
            $req->execute(array($tickets->title, $tickets->category, $tickets->priority, $tickets->status, $id));
            return $req->fetch();
        }

        static function delete($id){
            $bdd = getConnexion();
            $req = $bdd->prepare("DELETE FROM ticket WHERE id = ?");
            $req->execute(array($id));
            return $req->fetch();
        }
    }