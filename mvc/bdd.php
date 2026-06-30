<?php
    function getConnexion(){
        return new PDO('mysql:dbname=API-tickets;host=localhost;port=8889', 'root', 'root');
    }